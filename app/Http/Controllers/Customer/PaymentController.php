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

class PaymentController extends Controller
{
    // Display all payments that belong to the logged-in customer
    public function index()
{
    // Get current logged-in customer ID
    $userId = Auth::id();

    // Get customer payments with related booking and room details
    $payments = Payment::with('booking.room')
        ->whereHas('booking', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->latest()
        ->paginate(8);

    // Calculate total paid amount by this customer
    $totalPaid = Payment::where('status', 'paid')
        ->whereHas('booking', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->sum('amount');

    // Calculate total pending payment amount
    $pendingAmount = Payment::where('status', 'pending')
        ->whereHas('booking', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->sum('amount');

    // Count how many payments are already paid
    $paidCount = Payment::where('status', 'paid')
        ->whereHas('booking', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->count();

    // Get the latest paid payment
    $lastPayment = Payment::where('status', 'paid')
        ->whereHas('booking', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->latest('payment_date')
        ->first();

    // Send payment data to customer payment page
    return view('customer.payments.index', compact(
        'payments',
        'totalPaid',
        'pendingAmount',
        'paidCount',
        'lastPayment'
    ));
}
    // Handle payment method selection: cash or card
    public function pay(Request $request, Payment $payment)
    {
        // Prevent customers from accessing payments that do not belong to them
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Validate selected payment method
        $request->validate([
            'payment_method' => 'required|in:cash,card',
        ]);
        
        // If customer selects card, redirect to card payment form
        if ($request->payment_method === 'card') {
            return redirect()->route('customer.payments.card', $payment->id);
        }

        // If customer selects cash, keep payment pending until admin confirms it
        $payment->update([
            'payment_method' => 'cash',
            'status' => 'pending',
            'payment_date' => null,
        ]);

        return back()->with('success', 'Cash payment selected. Waiting for admin confirmation.');
    }

    // Show demo card payment form
    public function cardForm(Payment $payment)
    {
        // Only payment owner can view this card form
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Load booking and room details for card payment page
        $payment->load('booking.room');

        return view('customer.payments.card', compact('payment'));
    }

     // Process demo card payment
    public function processCard(Request $request, Payment $payment)
    {
        // Customer can pay only their own payment
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Validate demo card details
        $request->validate([
            'card_holder' => 'required|string|max:255',
            'card_number' => 'required|string|min:16|max:19',
            'expiry_date' => 'required|string|max:10',
            'cvv' => 'required|string|min:3|max:4',
        ]);

        // Mark card payment as paid immediately
        $payment->update([
            'payment_method' => 'card',
            'status' => 'paid',
            'payment_date' => Carbon::now(),
        ]);

        // Load booking and customer details for notification message
        $payment->load('booking.user');

        // Get all admin users
        $admins = User::where('role', 'admin')->get();

        // Send notification to each admin about the received payment
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Payment Received',
                'message' => 'Rs. ' . number_format($payment->amount, 2) . ' payment received from ' . $payment->booking->user->name . '.',
                'is_read' => false,
            ]);
        }

        // Redirect customer to invoice page after successful card payment
        return redirect()->route('customer.payments.invoice', $payment->id)
            ->with('success', 'Demo card payment completed successfully.');
    }

    // Show invoice page for a payment
    public function invoice(Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Load room and customer details for invoice display
        $payment->load('booking.room', 'booking.user');

        return view('customer.payments.invoice', compact('payment'));
    }

    // Download invoice as PDF
    public function downloadInvoicePdf(Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Load related booking, room and customer details
        $payment->load('booking.room', 'booking.user');

         // Generate PDF using invoice-pdf blade view
        $pdf = Pdf::loadView('customer.payments.invoice-pdf', compact('payment'));

        // Download generated PDF file
        return $pdf->download('invoice-' . $payment->id . '.pdf');
    }

    // Download invoice as CSV file
    public function downloadInvoiceCsv(Payment $payment)
    {
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

       // Load related booking, room and customer details
        $payment->load('booking.room', 'booking.user');

        // CSV file name
        $fileName = 'invoice-' . $payment->id . '.csv';

        // Browser download headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        $callback = function () use ($payment) {
            $file = fopen('php://output', 'w');

            //invoice data
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