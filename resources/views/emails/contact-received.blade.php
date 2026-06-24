@extends('emails.layouts.master')

@section('content')

<h2 style="color:#020617; margin-top:0;">
    Hello {{ $contact->name }},
</h2>

<p>
    Thank you for contacting <strong>RoyalStay Hotel</strong>. We have successfully received your message.
</p>

<div style="background:#fef3c7; border-left:5px solid #f59e0b; padding:22px; border-radius:12px; margin:30px 0;">

    <p><strong>Email:</strong> {{ $contact->email }}</p>

    <p><strong>Your Message:</strong></p>

    <div style="background:#ffffff; padding:15px; border-radius:10px; border:1px solid #fde68a;">
        {!! nl2br(e($contact->message)) !!}
    </div>

</div>

<p>
    Our hotel team will review your inquiry and respond to you as soon as possible.
</p>

<p>
    If your request is urgent, please feel free to contact us by phone.
</p>

<br>

<p>
    Thank you for choosing <strong>RoyalStay Hotel</strong>.
</p>

@endsection