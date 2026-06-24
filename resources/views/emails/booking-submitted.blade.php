@extends('emails.layouts.master')

@section('content')

<h2 style="margin:0 0 20px;color:#020617;">
    New Booking Received
</h2>

<p style="color:#475569;">
    A customer has submitted a new booking request through the RoyalStay website.
</p>

<div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:22px;margin:28px 0;">

    <table width="100%" cellpadding="8" cellspacing="0">

        <tr>
            <td><strong>Customer</strong></td>
            <td>{{ $booking->user->name }}</td>
        </tr>

        <tr>
            <td><strong>Email</strong></td>
            <td>{{ $booking->user->email }}</td>
        </tr>

        <tr>
            <td><strong>Room</strong></td>
            <td>{{ $booking->room->room_type }}</td>
        </tr>

        <tr>
            <td><strong>Room Number</strong></td>
            <td>{{ $booking->room->room_number }}</td>
        </tr>

        <tr>
            <td><strong>Check-In</strong></td>
            <td>{{ $booking->check_in_date->format('d M Y') }}</td>
        </tr>

        <tr>
            <td><strong>Check-Out</strong></td>
            <td>{{ $booking->check_out_date->format('d M Y') }}</td>
        </tr>

        <tr>
            <td><strong>Guests</strong></td>
            <td>{{ $booking->guests }}</td>
        </tr>

        <tr>
            <td><strong>Total Amount</strong></td>
            <td><strong>Rs. {{ number_format($booking->total_amount,2) }}</strong></td>
        </tr>

    </table>

</div>

<div style="background:#fff7ed;border-left:5px solid #f59e0b;padding:18px;border-radius:12px;">
    Please review this booking request from the Admin Dashboard and approve or reject it.
</div>

<p style="margin-top:30px;font-weight:bold;color:#020617;">
    RoyalStay Hotel System
</p>

@endsection