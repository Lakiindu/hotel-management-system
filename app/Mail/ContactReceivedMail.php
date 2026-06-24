<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contact $contact)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We Received Your Message - RoyalStay Hotel',
        );
    }

    public function content(): Content
{
    return new Content(
        view: 'emails.contact-received',
        with: [
            'contact' => $this->contact,
            'emailTitle' => 'Message Received',
            'emailSubtitle' => 'Contact Confirmation',
        ],
    );
}

    public function attachments(): array
    {
        return [];
    }
}