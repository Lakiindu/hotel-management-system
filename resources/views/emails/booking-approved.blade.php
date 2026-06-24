@extends('emails.layouts.app')

@section('title', 'Booking Approved')

@section('header')
Booking Approved
@endsection

@section('content')

<h2 style="margin-top:0;color:#0f172a;">
    Great news, {{ $booking->user->name }}! 🎉
</h2>

<p style="color:#475569;font-size:16px;line-height:26px;">
    Your room booking has been approved by our hotel administration.
</p>

<div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin:25px 0;">

<strong>Booking ID:</strong> #{{ $booking->id }}<br><br>

<strong>Room Type:</strong> {{ $booking->room->room_type }}<br>

<strong>Room Number:</strong> {{ $booking->room->room_number }}<br>

<strong>Check-In:</strong>
{{ $booking->check_in_date->format('d M Y') }}<br>

<strong>Check-Out:</strong>
{{ $booking->check_out_date->format('d M Y') }}<br>

<strong>Guests:</strong>
{{ $booking->guests }}<br>

<strong>Total Amount:</strong>
Rs. {{ number_format($booking->total_amount,2) }}

</div>

<p style="color:#475569;font-size:16px;line-height:26px;">
You can now log into your RoyalStay account and complete your payment to confirm your reservation.
</p>

<a href="{{ url('/login') }}"
style="
display:inline-block;
background:#f59e0b;
color:white;
padding:14px 28px;
text-decoration:none;
border-radius:10px;
font-weight:bold;
margin-top:15px;
">
Login to Your Account
</a>

<p style="margin-top:35px;color:#475569;">
We look forward to welcoming you to <strong>RoyalStay Hotel</strong>.
</p>

@endsection