@extends('emails.layouts.master')

@section('content')

<h2 style="color:#020617; margin-top:0;">
    New Review Submitted
</h2>

<p>
    A customer has submitted a new review after completing their stay.
</p>

<div style="background:#fef3c7; border-left:5px solid #f59e0b; padding:22px; border-radius:12px; margin:30px 0;">

    <p><strong>Customer:</strong> {{ $review->user->name }}</p>

    <p><strong>Email:</strong> {{ $review->user->email }}</p>

    <p><strong>Room:</strong> {{ $review->room->room_type }}</p>

    <p><strong>Booking ID:</strong> #{{ $review->booking_id }}</p>

    <p>
        <strong>Rating:</strong>
        {{ str_repeat('⭐', $review->rating) }}
        ({{ $review->rating }}/5)
    </p>

    <p><strong>Customer Comment:</strong></p>

    <div style="background:#ffffff; padding:15px; border-radius:10px; border:1px solid #fde68a;">
        {{ $review->comment ?? 'No comment provided.' }}
    </div>

</div>

<p>
    Please log in to the admin dashboard to review and manage customer feedback.
</p>

<br>

<p>
    <strong>RoyalStay Hotel System</strong>
</p>

@endsection