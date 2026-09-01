<?php

namespace Database\Seeders;

use App\Models\JadwalKegiatan;
use Illuminate\Database\Seeder;

class JadwalKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $jadwalData = [
            [
                'nama' => 'hari 1',
                'tanggal' => '2025-09-15',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '10:00',
            ],
            [
                'nama' => 'hari 2',
                'tanggal' => '2025-09-16',
                'waktu_mulai' => '10:30',
                'waktu_selesai' => '12:00',
            ],
            [
                'nama' => 'hari 3',
                'tanggal' => '2025-09-17',
                'waktu_mulai' => '12:00',
                'waktu_selesai' => '13:00',
            ],
          
        ];

        foreach ($jadwalData as $data) {
            JadwalKegiatan::create($data);
        }
    }
}
