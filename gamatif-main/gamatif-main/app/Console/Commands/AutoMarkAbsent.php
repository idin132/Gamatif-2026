<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Absensi;
use App\Models\JadwalKegiatan;
use App\Models\MahasiswaBaru;
use Carbon\Carbon;

class AutoMarkAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:auto-mark-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto mark absensi as alpa jika sudah lewat 1 jam dari waktu_mulai jadwal_kegiatan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $today = $now->toDateString();

        $this->info("Memeriksa jadwal kegiatan pada tanggal {$today}...");

        // Ambil jadwal yang tanggalnya hari ini dan waktu_mulai + 1 jam sudah lewat
        // $jadwals = JadwalKegiatan::where('tanggal', $today)
        //     ->whereRaw("CONCAT(tanggal, ' ', waktu_mulai) < ?", [$now->copy()->subHour()->toDateTimeString()])
        //     ->get();

        // Ambil jadwal yang tanggalnya hari ini dan waktu_mulai + 1 menit sudah lewat
        $jadwals = JadwalKegiatan::where('tanggal', $today)
            ->whereRaw("CONCAT(tanggal, ' ', waktu_mulai) < ?", [
                // Untuk uji coba 1 menit, ganti subHour() jadi subMinute()
                $now->copy()->subHour()->toDateTimeString()
                // $now->copy()->subMinute()->toDateTimeString() // <- Uncomment ini untuk uji coba 1 menit
            ])
            ->get();


        if ($jadwals->isEmpty()) {
            $this->info('Tidak ada jadwal yang perlu diproses.');
            return;
        }

        $totalCreated = 0;

        foreach ($jadwals as $jadwal) {
            $this->info("Memproses jadwal: {$jadwal->nama} (ID: {$jadwal->id})");

            // Ambil mahasiswa yang belum absen untuk jadwal ini
            $mahasiswaBelumAbsen = MahasiswaBaru::whereDoesntHave('absensi', function ($query) use ($jadwal) {
                $query->where('jadwal_kegiatan_id', $jadwal->id);
            })->get();

            foreach ($mahasiswaBelumAbsen as $mahasiswa) {
                Absensi::create([
                    'mahasiswa_baru_id' => $mahasiswa->id,
                    'jadwal_kegiatan_id' => $jadwal->id,
                    'status' => 'alpa',
                ]);
                $totalCreated++;
            }

            $this->info("Dibuat {$mahasiswaBelumAbsen->count()} absensi 'alpa' untuk jadwal {$jadwal->nama}");
        }

        $this->info("Total absensi 'alpa' yang dibuat: {$totalCreated}");
    }
}
