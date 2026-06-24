@extends('emails.layouts.master')

@section('content')

<h2 style="color:#020617; margin-top:0;">
    Hello, {{ $booking->user->name }}
</h2>

<p>
    We are sorry to inform you that your booking has been cancelled.
</p>

<div style="background:#fee2e2; border-left:5px solid #dc2626; padding:22px; border-radius:12px; margin:30px 0;">

    <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>

    <p><strong>Room:</strong> {{ $booking->room->room_type }}</p>

    <p><strong>Room Number:</strong> {{ $booking->room->room_number }}</p>

    <p><strong>Check-In:</strong> {{ $booking->check_in_date->format('Y-m-d') }}</p>

    <p><strong>Check-Out:</strong> {{ $booking->check_out_date->format('Y-m-d') }}</p>

    <p><strong>Guests:</strong> {{ $booking->guests }}</p>

    <p><strong>Total Amount:</strong> Rs. {{ number_format($booking->total_amount,2) }}</p>

</div>

<p>
    You may log in to your RoyalStay account and make another booking whenever you're ready.
</p>

<p>
    If you believe this cancellation was made in error, please contact our support team and we'll be happy to assist you.
</p>

<br>

<p>
    Thank you for choosing <strong>RoyalStay Hotel</strong>.
</p>

@endsection