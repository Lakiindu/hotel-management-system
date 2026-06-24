@extends('emails.layouts.master')

@section('content')

<h2 style="color:#020617; margin-top:0;">
    Hello {{ $booking->user->name }},
</h2>

<p>
    Thank you for choosing <strong>RoyalStay Hotel</strong>. We have successfully received your booking request.
</p>

<div style="background:#fef3c7; border-left:5px solid #f59e0b; padding:22px; border-radius:12px; margin:30px 0;">

    <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>

    <p><strong>Status:</strong> Pending Approval</p>

    <p><strong>Room:</strong> {{ $booking->room->room_type }}</p>

    <p><strong>Room Number:</strong> {{ $booking->room->room_number }}</p>

    <p><strong>Check-In:</strong> {{ $booking->check_in_date->format('Y-m-d') }}</p>

    <p><strong>Check-Out:</strong> {{ $booking->check_out_date->format('Y-m-d') }}</p>

    <p><strong>Guests:</strong> {{ $booking->guests }}</p>

    <p><strong>Total Amount:</strong> Rs. {{ number_format($booking->total_amount, 2) }}</p>

</div>

<p>
    Our hotel team will review your booking request and notify you once it has been approved.
</p>

<br>

<p>
    Thank you,<br>
    <strong>RoyalStay Hotel Team</strong>
</p>

@endsection