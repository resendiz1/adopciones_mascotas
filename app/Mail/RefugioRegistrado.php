<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RefugioRegistrado extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registro recibido - Adopciones Mascotas',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.refugio-registrado', ['user' => $this->user])->render(),
        );
    }
}
