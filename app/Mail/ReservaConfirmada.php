<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaConfirmada extends Mailable
{
    use Queueable, SerializesModels;

    // 1. Definimos la propiedad pública para que esté disponible en la vista
    public function __construct(
        public Reserva $reserva
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Tu reserva en el Centro Deportivo ha sido confirmada!',
        );
    }

    public function content(): Content
    {
        return new Content(
            // 2. Cambiamos 'view.name' por la ruta real de la vista
            view: 'emails.reserva-confirmada',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}