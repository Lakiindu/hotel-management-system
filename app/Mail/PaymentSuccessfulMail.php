<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessfulMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Payment $payment)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Successful - RoyalStay Hotel',
        );
    }

    public function content(): Content
{
    return new Content(
        view: 'emails.payment-successful',
        with: [
            'payment' => $this->payment,
            'emailTitle' => 'Payment Successful',
            'emailSubtitle' => 'Payment Receipt',
        ],
    );
}

    public function attachments(): array
    {
        return [];
    }
}