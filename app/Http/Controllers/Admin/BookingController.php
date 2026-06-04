<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
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

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:approved,cancelled,checked_in,checked_out,completed',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        // Create payment record when booking is approved
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
        }

        if ($request->status === 'checked_in') {
            $booking->room->update([
                'status' => 'occupied',
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

        // AJAX / JSON response
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