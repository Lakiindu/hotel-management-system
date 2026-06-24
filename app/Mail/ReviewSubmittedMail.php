<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Review $review)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Customer Review - RoyalStay Hotel',
        );
    }

public function content(): Content
{
    return new Content(
        view: 'emails.review-submitted',
        with: [
            'review' => $this->review,
            'emailTitle' => 'New Customer Review',
            'emailSubtitle' => 'Admin Review Notification',
        ],
    );
}

    public function attachments(): array
    {
        return [];
    }
}