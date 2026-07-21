<?php

namespace App\Mail;

use App\Models\Shelter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevaSolicitudRefugio extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Shelter $shelter)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva solicitud de aprobación de refugio',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.nueva-solicitud-refugio', ['shelter' => $this->shelter])->render(),
        );
    }
}
