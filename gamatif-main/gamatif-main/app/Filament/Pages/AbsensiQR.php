<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use App\Models\MahasiswaBaru;
use Filament\Notifications\Notification;

class AbsensiQR extends Page
{
    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.pages.absensi';
    protected static ?string $title = 'Absensi Seminar';

    public $nimMaba = '';

    // Dipanggil saat form auto-submit atau klik button
    public function submit()
    {
        $this->validate([
            'kodeAbsen' => 'required|string',
        ]);

        $maba = MahasiswaBaru::where('nim', $this->nimMaba)->first();

        if (! $maba) {
            Notification::make()
                ->danger()
                ->title('Mahasiswa Baru tidak ditemukan!')
                ->send();
            return;
        }

        // Insert absensi jika belum ada
        $absen = \App\Models\Absensi::firstOrCreate(
            ['mahasiswa_baru_id' => $maba->id],
            ['created_at' => now()]
        );

        if ($absen->wasRecentlyCreated) {
            Notification::make()
                ->success()
                ->title("Absensi berhasil untuk {$maba->nama_lengkap}")
                ->send();
        } else {
            Notification::make()
                ->warning()
                ->title("Peserta {$maba->nama_lengkap} sudah absen sebelumnya")
                ->send();
        }

        $this->reset('nimMaba'); // kosongkan input biar siap scan berikutnya
    }
}
