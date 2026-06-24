@extends('emails.layouts.master')

@section('content')

    <h2 style="margin:0 0 16px; color:#020617; font-size:26px; line-height:1.3;">
        Welcome, {{ $user->name }}!
    </h2>

    <p style="margin:0 0 16px; color:#475569; font-size:16px;">
        Thank you for creating an account with RoyalStay Hotel.
    </p>

    <p style="margin:0 0 24px; color:#475569; font-size:16px;">
        You can now browse rooms, make bookings, manage payments, view invoices and submit reviews after your stay.
    </p>

    <div style="background:#fef3c7; border:1px solid #fde68a; padding:20px; border-radius:16px; margin:24px 0;">
        <p style="margin:0 0 8px; color:#020617;">
            <strong>Email:</strong> {{ $user->email }}
        </p>

        <p style="margin:0; color:#020617;">
            <strong>Account Type:</strong> Customer
        </p>
    </div>

    <p style="margin:0 0 24px; color:#475569; font-size:16px;">
        We look forward to giving you a comfortable and memorable hotel experience.
    </p>

    <div style="margin-top:28px;">
        <a href="{{ route('login') }}"
           style="display:inline-block; background:#fbbf24; color:#020617; text-decoration:none; padding:14px 24px; border-radius:999px; font-weight:bold;">
            Login to Your Account
        </a>
    </div>

    <p style="margin:30px 0 0; color:#020617; font-weight:bold;">
        Thank you,<br>
        RoyalStay Hotel Team
    </p>

@endsection