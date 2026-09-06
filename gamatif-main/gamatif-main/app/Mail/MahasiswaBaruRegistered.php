<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MahasiswaBaruRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $email;
    public $password;

    public function __construct($nama, $email, $password)
    {
        $this->nama = $nama;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Akun Mahasiswa Baru - Teknik Informatika UNIKOM')
                    ->view('emails.mahasiswa_baru_registered')
                    ->with([
                        'nama' => $this->nama,
                        'email' => $this->email,
                        'password' => $this->password,
                    ]);
    }
}
