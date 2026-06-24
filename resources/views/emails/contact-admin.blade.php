@extends('emails.layouts.master')

@section('content')

<h2 style="color:#020617; margin-top:0;">
    New Contact Message
</h2>

<p>
    A new message has been submitted from the RoyalStay website contact form.
</p>

<div style="background:#dbeafe; border-left:5px solid #2563eb; padding:22px; border-radius:12px; margin:30px 0;">

    <p><strong>Name:</strong> {{ $contact->name }}</p>

    <p><strong>Email:</strong> {{ $contact->email }}</p>

    <p><strong>Status:</strong> {{ ucfirst($contact->status) }}</p>

    <p><strong>Message:</strong></p>

    <div style="background:#ffffff; padding:15px; border-radius:10px; border:1px solid #bfdbfe;">
        {!! nl2br(e($contact->message)) !!}
    </div>

</div>

<p>
    Please log in to the admin dashboard to view and manage this message.
</p>

<br>

<p>
    <strong>RoyalStay Hotel System</strong>
</p>

@endsection