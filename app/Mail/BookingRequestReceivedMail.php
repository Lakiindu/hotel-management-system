<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingRequestReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Request Received - RoyalStay Hotel',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-request-received',
            with: [
                'booking' => $this->booking,
                'emailTitle' => 'Booking Request Received',
                'emailSubtitle' => 'Pending Booking Confirmation',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}