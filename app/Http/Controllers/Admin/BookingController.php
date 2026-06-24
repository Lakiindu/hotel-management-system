<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingApprovedMail;
use App\Mail\BookingCancelledMail;

class BookingController extends Controller
{
    // Display all bookings in the admin panel
    public function index(Request $request)
    {
        // Get selected booking status filter from request
        $status = $request->status;

        // Get bookings with related customer and room details
        $bookings = Booking::with(['user', 'room'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        // Send bookings data to admin booking page
        return view('admin.bookings.index', compact('bookings', 'status'));
    }

    // Load bookings using AJAX for search/filter without refreshing the page
    public function ajaxBookings(Request $request)
    {
        // Get search keyword and selected status
        $search = $request->search;
        $status = $request->status;

        // Search bookings by customer name/email or room number/type
        $bookings = Booking::with(['user', 'room'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('room', function ($roomQuery) use ($search) {
                        $roomQuery->where('room_number', 'like', "%{$search}%")
                            ->orWhere('room_type', 'like', "%{$search}%");
                    });
                });
            })

            // Filter bookings by selected status
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        // Return booking data as JSON for AJAX
        return response()->json([
            'success' => true,
            'bookings' => $bookings,
        ]);
    }

    // Update booking status from admin panel
    public function updateStatus(Request $request, Booking $booking)
    {
        // Validate allowed booking status values
        $request->validate([
            'status' => 'required|in:approved,cancelled,checked_in,checked_out,completed',
        ]);

        // Update booking status
        $booking->update([
            'status' => $request->status,
        ]);

        // If booking is approved, create payment record and notify customer
        if ($request->status === 'approved') {
            Payment::firstOrCreate(
                [
                    'booking_id' => $booking->id,
                ],
                [
                    'amount' => $booking->total_amount,
                    'payment_method' => 'cash',
                    'status' => 'pending',
                ]
            );

            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking Approved',
                'message' => 'Your booking has been approved.',
                'is_read' => false,
            ]);

            $booking->load('user', 'room');

            // Send booking approval email to customer
            Mail::to($booking->user->email)->send(new BookingApprovedMail($booking));
        }

        // If booking is cancelled, notify customer
        if ($request->status === 'cancelled') {
            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking Cancelled',
                'message' => 'Your booking has been cancelled.',
                'is_read' => false,
            ]);

            $booking->load('user', 'room');

            // Send booking cancellation email to customer
            Mail::to($booking->user->email)->send(new BookingCancelledMail($booking));
        }

        // If customer checks in, mark room as occupied and notify customer
        if ($request->status === 'checked_in') {
            $booking->room->update([
                'status' => 'occupied',
            ]);

            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Check-In Successful',
                'message' => 'You have successfully checked in.',
                'is_read' => false,
            ]);
        }

        // If customer checks out, notify customer
        if ($request->status === 'checked_out') {
            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Check-Out Successful',
                'message' => 'You have successfully checked out.',
                'is_read' => false,
            ]);
        }

        // Make room available again after checkout, completion or cancellation
        if (
            $request->status === 'checked_out' ||
            $request->status === 'completed' ||
            $request->status === 'cancelled'
        ) {
            $booking->room->update([
                'status' => 'available',
            ]);
        }

        // Return JSON response for AJAX status updates
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully.',
                'status' => $booking->status,
            ]);
        }

        // Redirect back for normal form submission
        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking status updated successfully.');
    }
}