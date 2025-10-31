<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class AlbumManagerEmail extends Mailable
{
    public function __construct(
        public string $albumName,
        public string $password,
        public string $loginUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Digital Art Studio',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.album-manager',
        );
    }
}
