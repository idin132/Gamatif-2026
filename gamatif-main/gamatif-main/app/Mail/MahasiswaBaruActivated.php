<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MahasiswaBaruActivated extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;

    public function __construct($nama)
    {
        $this->nama = $nama;
    }

    public function build()
    {
        return $this->subject('Akun Mahasiswa Baru Diaktifkan')
                    ->view('emails.mahasiswa_baru_activated')
                    ->with([
                        'nama' => $this->nama,
                    ]);
    }
}
