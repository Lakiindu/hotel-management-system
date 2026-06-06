<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $payments = Payment::with('booking.user', 'booking.room')
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.payments.index', compact('payments', 'status'));
    }

    public function ajaxPayments(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $payments = Payment::with('booking.user', 'booking.room')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('booking.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('booking.room', function ($roomQuery) use ($search) {
                        $roomQuery->where('room_number', 'like', "%{$search}%")
                            ->orWhere('room_type', 'like', "%{$search}%");
                    })
                    ->orWhereHas('booking', function ($bookingQuery) use ($search) {
                        $bookingQuery->where('id', 'like', "%{$search}%");
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
            'payments' => $payments,
        ]);
    }

    public function confirm(Payment $payment)
    {
        $payment->update([
            'status' => 'paid',
            'payment_date' => now(),
        ]);

        return back()->with('success', 'Payment confirmed successfully.');
    }
}