<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan mail:test email@tujuan.com
     */
    protected $signature = 'mail:test {email}';

    /**
     * The console command description.
     */
    protected $description = 'Kirim email test menggunakan konfigurasi mail saat ini';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        Mail::raw('Ini adalah email test dari Laravel menggunakan konfigurasi MAIL_* di .env', function ($msg) use ($email) {
            $msg->to($email)
                ->subject('✅ Test Email Laravel');
        });

        $this->info("📧 Email test dikirim ke: {$email}");
    }
}
