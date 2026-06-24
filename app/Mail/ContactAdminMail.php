<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contact $contact)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Message - RoyalStay Hotel',
        );
    }

public function content(): Content
{
    return new Content(
        view: 'emails.contact-admin',
        with: [
            'contact' => $this->contact,
            'emailTitle' => 'New Contact Message',
            'emailSubtitle' => 'Admin Contact Notification',
        ],
    );
}

    public function attachments(): array
    {
        return [];
    }
}