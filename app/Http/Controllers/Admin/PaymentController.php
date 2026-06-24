<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmedMail;

class PaymentController extends Controller
{
    // Display all payments in the admin panel
    public function index(Request $request)
    {
        // Get selected payment status filter
        $status = $request->status;

        // Retrieve payments with related booking, customer and room details
        $payments = Payment::with('booking.user', 'booking.room')
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        // Return payments to the admin payment page
        return view('admin.payments.index', compact('payments', 'status'));
    }

    // Load payment data using AJAX for live searching and filtering
    public function ajaxPayments(Request $request)
    {
        // Get search keyword and selected status
        $search = $request->search;
        $status = $request->status;

        // Search payments by customer, room, or booking ID
        $payments = Payment::with('booking.user', 'booking.room')

            // Search by customer name, email, room number, room type or booking ID
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    // Search customer information
                    $q->whereHas('booking.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })

                    // Search room information
                    ->orWhereHas('booking.room', function ($roomQuery) use ($search) {
                        $roomQuery->where('room_number', 'like', "%{$search}%")
                            ->orWhere('room_type', 'like', "%{$search}%");
                    })

                    // Search booking ID
                    ->orWhereHas('booking', function ($bookingQuery) use ($search) {
                        $bookingQuery->where('id', 'like', "%{$search}%");
                    });
                });
            })

            // Filter payments by payment status
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })

            // Show newest payments first
            ->latest()
            ->get();

        // Return payment data as JSON for AJAX
        return response()->json([
            'success' => true,
            'payments' => $payments,
        ]);
    }

    // Confirm a customer's payment
    public function confirm(Payment $payment)
    {
        // Update payment status and payment date
        $payment->update([
            'status' => 'paid',
            'payment_date' => now(),
        ]);

        // Load booking, customer and room details
        $payment->load('booking.user', 'booking.room');

        // Send payment confirmation email to customer
        Mail::to($payment->booking->user->email)->send(new PaymentConfirmedMail($payment));

        // Send notification to the customer
        Notification::create([
            'user_id' => $payment->booking->user_id,
            'title' => 'Payment Confirmed',
            'message' => 'Your payment has been confirmed.',
            'is_read' => false,
        ]);

        // Return back with success message
        return back()->with('success', 'Payment confirmed successfully.');
    }
}