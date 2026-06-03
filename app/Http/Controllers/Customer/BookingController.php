<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $days = Carbon::parse($request->check_in_date)
            ->diffInDays(Carbon::parse($request->check_out_date));

        $totalAmount = $days * $room->price_per_night;

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'guests' => $request->guests,
            'special_requests' => $request->special_requests,
            'status' => 'pending',
            'total_amount' => $totalAmount,
        ]);

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Booking submitted successfully. Waiting for admin approval.');
    }

    public function index()
    {
        $bookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(8);

        return view('customer.bookings.index', compact('bookings'));
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

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
}