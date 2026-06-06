<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $bookings = Booking::with(['user', 'room'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings', 'status'));
    }

    public function ajaxBookings(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

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
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'bookings' => $bookings,
        ]);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:approved,cancelled,checked_in,checked_out,completed',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

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
        }

        if ($request->status === 'cancelled') {
            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking Cancelled',
                'message' => 'Your booking has been cancelled.',
                'is_read' => false,
            ]);
        }

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

        if ($request->status === 'checked_out') {
            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Check-Out Successful',
                'message' => 'You have successfully checked out.',
                'is_read' => false,
            ]);
        }

        if (
            $request->status === 'checked_out' ||
            $request->status === 'completed' ||
            $request->status === 'cancelled'
        ) {
            $booking->room->update([
                'status' => 'available',
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully.',
                'status' => $booking->status,
            ]);
        }

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking status updated successfully.');
    }
}