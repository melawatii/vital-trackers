<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class VerifyEmailMail extends Mailable
{
    public function __construct(public string $url)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Email Address',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'auth.verify-email',
            with: [
                'url' => $this->url,
            ],
        );
    }
}
