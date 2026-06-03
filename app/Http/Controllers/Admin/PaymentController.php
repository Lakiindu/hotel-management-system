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

    public function confirm(Payment $payment)
    {
        $payment->update([
            'status' => 'paid',
            'payment_date' => now(),
        ]);

        return back()->with('success', 'Payment confirmed successfully.');
    }
}