<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Review $review)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank You for Your Review - RoyalStay Hotel',
        );
    }

public function content(): Content
{
    return new Content(
        view: 'emails.review-thank-you',
        with: [
            'review' => $this->review,
            'emailTitle' => 'Thank You for Your Review',
            'emailSubtitle' => 'Thank You for Your Feedback',
        ],
    );
}

    public function attachments(): array
    {
        return [];
    }
}