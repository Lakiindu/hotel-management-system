@extends('emails.layouts.master')

@section('content')

<h2 style="color:#020617; margin-top:0;">
    Payment Successful
</h2>

<p>
    Hello {{ $payment->booking->user->name }},
</p>

<p>
    We have successfully received your card payment.
</p>

<div style="background:#dcfce7; border-left:5px solid #16a34a; padding:22px; border-radius:12px; margin:30px 0;">

    <p><strong>Invoice No:</strong> INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>

    <p><strong>Booking ID:</strong> #{{ $payment->booking->id }}</p>

    <p><strong>Room:</strong> {{ $payment->booking->room->room_type }}</p>

    <p><strong>Room Number:</strong> {{ $payment->booking->room->room_number }}</p>

    <p><strong>Check-In:</strong> {{ $payment->booking->check_in_date->format('Y-m-d') }}</p>

    <p><strong>Check-Out:</strong> {{ $payment->booking->check_out_date->format('Y-m-d') }}</p>

    <p><strong>Payment Method:</strong> Card</p>

    <p><strong>Amount Paid:</strong> Rs. {{ number_format($payment->amount, 2) }}</p>

</div>

<p>
    Your payment has been completed successfully. You can view or download your invoice from your RoyalStay account.
</p>

<br>

<p>
    Thank you,<br>
    <strong>RoyalStay Hotel Team</strong>
</p>

@endsection