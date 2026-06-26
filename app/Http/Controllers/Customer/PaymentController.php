<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessfulMail;

class PaymentController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $payments = Payment::with('booking.room')
            ->whereHas('booking', fn ($query) => $query->where('user_id', $userId))
            ->latest()
            ->paginate(8);

        $totalPaid = Payment::where('status', 'paid')
            ->whereHas('booking', fn ($query) => $query->where('user_id', $userId))
            ->sum('amount');

        $pendingAmount = Payment::where('status', 'pending')
            ->whereHas('booking', fn ($query) => $query->where('user_id', $userId))
            ->sum('amount');

        $paidCount = Payment::where('status', 'paid')
            ->whereHas('booking', fn ($query) => $query->where('user_id', $userId))
            ->count();

        $lastPayment = Payment::where('status', 'paid')
            ->whereHas('booking', fn ($query) => $query->where('user_id', $userId))
            ->latest('payment_date')
            ->first();

        return view('customer.payments.index', compact(
            'payments',
            'totalPaid',
            'pendingAmount',
            'paidCount',
            'lastPayment'
        ));
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
        $payment->update([
            'payment_method' => 'card',
            'status' => 'pending',
            'payment_date' => null,
        ]);

        return redirect()->route('customer.payments.payhere', $payment->id);
    }

    $payment->update([
        'payment_method' => 'cash',
        'status' => 'pending',
        'payment_date' => null,
    ]);

    return back()->with('success', 'Cash payment selected. Waiting for admin confirmation.');
}

    public function payhereCheckout(Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($payment->status === 'paid') {
            return redirect()->route('customer.payments.invoice', $payment->id)
                ->with('success', 'This payment is already completed.');
        }

        $payment->load('booking.user', 'booking.room');

        $merchantId = config('payhere.merchant_id');
        $merchantSecret = config('payhere.merchant_secret');

        if (!$merchantId || !$merchantSecret) {
            return redirect()->route('customer.payments.index')
                ->with('error', 'PayHere credentials are missing. Please check your .env file.');
        }

        $orderId = 'PAY-' . $payment->id;
        $amount = number_format((float) $payment->amount, 2, '.', '');
        $currency = 'LKR';

        $hash = strtoupper(md5(
            $merchantId .
            $orderId .
            $amount .
            $currency .
            strtoupper(md5($merchantSecret))
        ));

        return view('customer.payments.payhere-checkout', compact(
            'payment',
            'merchantId',
            'orderId',
            'amount',
            'currency',
            'hash'
        ));
    }

    public function payhereSuccess(Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->refresh();

        return redirect()->route('customer.payments.invoice', $payment->id)
            ->with('success', 'PayHere payment finished. If the status is still pending, refresh after a few seconds.');
    }

    public function payhereCancel(Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        return redirect()->route('customer.payments.index')
            ->with('error', 'PayHere payment was cancelled.');
    }

    public function payhereNotify(Request $request)
    {
        $merchantSecret = config('payhere.merchant_secret');

        $localMd5sig = strtoupper(md5(
            $request->merchant_id .
            $request->order_id .
            $request->payhere_amount .
            $request->payhere_currency .
            $request->status_code .
            strtoupper(md5($merchantSecret))
        ));

        if ($localMd5sig === $request->md5sig && (int) $request->status_code === 2) {
            $paymentId = str_replace('PAY-', '', $request->order_id);

            $payment = Payment::with('booking.user', 'booking.room')->find($paymentId);

            if ($payment && $payment->status !== 'paid') {
                $payment->update([
                    'payment_method' => 'card',
                    'status' => 'paid',
                    'payment_date' => Carbon::now(),
                ]);

                Mail::to($payment->booking->user->email)
                    ->send(new PaymentSuccessfulMail($payment));

                $admins = User::where('role', 'admin')->get();

                foreach ($admins as $admin) {
                    Notification::create([
                        'user_id' => $admin->id,
                        'title' => 'Payment Received',
                        'message' => 'Rs. ' . number_format($payment->amount, 2) . ' payment received from ' . $payment->booking->user->name . '.',
                        'is_read' => false,
                    ]);
                }
            }
        }

        return response('OK', 200);
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
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->load('booking.room', 'booking.user');

        $pdf = Pdf::loadView('customer.payments.invoice-pdf', compact('payment'));

        return $pdf->download('invoice-' . $payment->id . '.pdf');
    }

    public function downloadInvoiceCsv(Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
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