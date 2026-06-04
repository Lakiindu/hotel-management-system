<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function downloadInvoicePdf(Payment $payment)
{
if ($payment->booking->user_id !== Auth::id()) {        abort(403);
    }

    $payment->load('booking.room', 'booking.user');

    $pdf = Pdf::loadView('customer.payments.invoice-pdf', compact('payment'));

    return $pdf->download('invoice-' . $payment->id . '.pdf');
}

public function downloadInvoiceCsv(Payment $payment)
{
if ($payment->booking->user_id !== Auth::id()) {        abort(403);
    }

    $payment->load('booking.room', 'booking.user');

    $fileName = 'invoice-' . $payment->id . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$fileName",
    ];

    $callback = function () use ($payment) {
        $file = fopen('php://output', 'w');

        fputcsv($file, ['Invoice ID', 'INV-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT)]);
        fputcsv($file, ['Customer', $payment->booking->user->name]);
        fputcsv($file, ['Email', $payment->booking->user->email]);
        fputcsv($file, ['Booking ID', $payment->booking->id]);
        fputcsv($file, ['Room', $payment->booking->room->room_type]);
        fputcsv($file, ['Check In', $payment->booking->check_in_date->format('Y-m-d')]);
        fputcsv($file, ['Check Out', $payment->booking->check_out_date->format('Y-m-d')]);
        fputcsv($file, ['Payment Method', $payment->payment_method]);
        fputcsv($file, ['Status', $payment->status]);
        fputcsv($file, ['Amount', $payment->amount]);

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}