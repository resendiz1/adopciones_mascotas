<?php

namespace App\Mail;

use App\Models\Shelter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RefugioRechazado extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Shelter $shelter)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Refugio rechazado - Adopciones Mascotas',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.refugio-rechazado', ['shelter' => $this->shelter])->render(),
        );
    }
}
