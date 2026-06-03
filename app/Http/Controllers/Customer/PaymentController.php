<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('booking.room')
            ->whereHas('booking', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(8);

        return view('customer.payments.index', compact('payments'));
    }

    public function pay(Request $request, Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|in:cash,card',
        ]);

        if ($request->payment_method === 'card') {
            return redirect()->route('customer.payments.card', $payment->id);
        }

        $payment->update([
            'payment_method' => 'cash',
            'status' => 'pending',
            'payment_date' => null,
        ]);

        return back()->with('success', 'Cash payment selected. Waiting for admin confirmation.');
    }

    public function cardForm(Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->load('booking.room');

        return view('customer.payments.card', compact('payment'));
    }

    public function processCard(Request $request, Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'card_holder' => 'required|string|max:255',
            'card_number' => 'required|string|min:16|max:19',
            'expiry_date' => 'required|string|max:10',
            'cvv' => 'required|string|min:3|max:4',
        ]);

        $payment->update([
            'payment_method' => 'card',
            'status' => 'paid',
            'payment_date' => Carbon::now(),
        ]);

        return redirect()->route('customer.payments.invoice', $payment->id)
            ->with('success', 'Demo card payment completed successfully.');
    }

    public function invoice(Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->load('booking.room', 'booking.user');

        return view('customer.payments.invoice', compact('payment'));
    }
}