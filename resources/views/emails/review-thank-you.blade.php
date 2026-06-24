@extends('emails.layouts.master')

@section('content')

<h2 style="color:#020617; margin-top:0;">
    Thank you, {{ $review->user->name }}!
</h2>

<p>
    We truly appreciate you taking the time to share your experience with <strong>RoyalStay Hotel</strong>.
</p>

<div style="background:#fef3c7; border-left:5px solid #f59e0b; padding:22px; border-radius:12px; margin:30px 0;">

    <p><strong>Room:</strong> {{ $review->room->room_type }}</p>

    <p><strong>Booking ID:</strong> #{{ $review->booking_id }}</p>

    <p>
        <strong>Your Rating:</strong>
        {{ str_repeat('⭐', $review->rating) }}
        ({{ $review->rating }}/5)
    </p>

    <p><strong>Your Comment:</strong></p>

    <div style="background:#ffffff; padding:15px; border-radius:10px; border:1px solid #fde68a;">
        {{ $review->comment ?? 'No comment provided.' }}
    </div>

</div>

<p>
    Your feedback helps us improve our service and provide a better hotel experience for future guests.
</p>

<br>

<p>
    Thank you,<br>
    <strong>RoyalStay Hotel Team</strong>
</p>

@endsection