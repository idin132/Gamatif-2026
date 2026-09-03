<?php

namespace App\Mail;

use App\Models\MahasiswaBaru;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MabaAccNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public MahasiswaBaru $maba) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran GAMATIF 2026 Telah Diverifikasi (ACC)',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.maba_acc',
        );
    }
}