<?php

namespace App\Filament\Resources\AbsensiResource\Pages;

use Filament\Resources\Pages\Page;
use App\Models\MahasiswaBaru;
use App\Models\JadwalKegiatan;
use Filament\Notifications\Notification;

class AbsenQR extends Page
{
    protected static string $resource = \App\Filament\Resources\AbsensiResource::class;

    protected static string $view = 'filament.pages.absensi-q-r';

    protected static ?string $title = 'Absensi Seminar';

    public $kodeAbsen = '';

    // Dipanggil saat form auto-submit atau klik button
    public function submit()
    {
        $this->validate([
            'kodeAbsen' => 'required|string',
        ]);

        $maba = MahasiswaBaru::where('nim', $this->kodeAbsen)->first();

        if (! $maba) {
            Notification::make()
                ->danger()
                ->title('Mahasiswa Baru tidak ditemukan!')
                ->send();
            return;
        }

        // Cari jadwal kegiatan hari ini
        $jadwal = JadwalKegiatan::where('tanggal', today())->first();

        if (!$jadwal) {
            Notification::make()
                ->danger()
                ->title('tidak ada kegiatan hari ini')
                ->send();
            return;
        }

        // Insert absensi jika belum ada
        $absen = \App\Models\Absensi::firstOrCreate(
            ['mahasiswa_baru_id' => $maba->id, 'jadwal_kegiatan_id' => $jadwal->id],
            ['status' => 'hadir']
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

        $this->reset('kodeAbsen'); // kosongkan input biar siap scan berikutnya
    }
}
