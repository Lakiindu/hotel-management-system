<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingSubmittedMail;
use App\Mail\BookingRequestReceivedMail;

class BookingController extends Controller
{
    public function create(Room $room)
    {
        if (Auth::user()->role !== 'customer') {
            return redirect()->route('admin.dashboard');
        }

        return view('customer.bookings.create', compact('room'));
    }

    public function store(Request $request, Room $room)
    {
        if (Auth::user()->role !== 'customer') {
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1|max:' . $room->capacity,
            'special_requests' => 'nullable|string|max:1000',
        ]);

        if ($room->status !== 'available') {
            return back()->with('error', 'This room is not available right now.');
        }

        $alreadyBooked = Booking::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'approved', 'checked_in'])
            ->where('check_in_date', '<', $request->check_out_date)
            ->where('check_out_date', '>', $request->check_in_date)
            ->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'This room is already booked for the selected dates.');
        }

        $days = Carbon::parse($request->check_in_date)
            ->diffInDays(Carbon::parse($request->check_out_date));

        $totalAmount = $days * $room->price_per_night;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'guests' => $request->guests,
            'special_requests' => $request->special_requests,
            'status' => 'pending',
            'total_amount' => $totalAmount,
        ]);

        $booking->load('user', 'room');

        // Send booking request received email to customer
        Mail::to($booking->user->email)->send(new BookingRequestReceivedMail($booking));

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'New Booking',
                'message' => 'A new booking has been received.',
                'is_read' => false,
            ]);

            Mail::to($admin->email)->send(new BookingSubmittedMail($booking));
        }

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Booking submitted successfully. Waiting for admin approval.');
    }

    public function index()
    {
        $userId = Auth::id();

        $bookings = Booking::with(['room', 'review'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(8);

        $totalBookings = Booking::where('user_id', $userId)->count();

        $activeBookings = Booking::where('user_id', $userId)
            ->whereIn('status', ['pending', 'approved', 'checked_in'])
            ->count();

        $completedBookings = Booking::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        return view('customer.bookings.index', compact(
            'bookings',
            'totalBookings',
            'activeBookings',
            'completedBookings'
        ));
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load('room');

        return view('customer.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($booking->status, ['pending', 'approved'])) {
            return back()->with('error', 'This booking cannot be cancelled now.');
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Booking Cancelled',
                'message' => Auth::user()->name . ' cancelled booking #' . $booking->id . '.',
                'is_read' => false,
            ]);
        }

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
}