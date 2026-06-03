<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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

        if ($request->status === 'checked_in') {
            $booking->room->update(['status' => 'occupied']);
        }

        if ($request->status === 'checked_out' || $request->status === 'completed' || $request->status === 'cancelled') {
            $booking->room->update(['status' => 'available']);
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking status updated successfully.');
    }
}