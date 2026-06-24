<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Room Booking Received',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-submitted',
            with: [
                'booking' => $this->booking,
                'emailTitle' => 'New Room Booking',
                'emailSubtitle' => 'Administrator Notification',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}