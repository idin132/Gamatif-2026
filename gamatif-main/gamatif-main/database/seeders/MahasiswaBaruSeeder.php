<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MahasiswaBaru;
use Illuminate\Support\Facades\Hash;

class MahasiswaBaruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Membuat data spesifik dari Anda
        MahasiswaBaru::updateOrCreate(
            ['email' => 'irsyaad.10122074@mahasiswa.unikom.ac.id'],
            [
                'nama_lengkap' => 'Rerey',
                'nim' => '10122074',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2002-07-06',
                'alamat' => 'Jl. Dipatiukur No. 112, Bandung',
                'nomor_whatsapp' => '081234567890',
                'bukti_registrasi' => 'bukti_registrasi/rBwWHTSbGMysEfRymdq9oN9855u8f1F50BzRL7Kp.jpg',
                'bukti_sosmed' => [
                    "bukti_sosmed/wmkJkzTfjZtnLlfa3hGfcr3wmzbIXgMU592ON3ri.png",
                    "bukti_sosmed/ny7514J5wHtUcdlTN2YgKF6AcKZXBLUkcGJ4qc9M.png"
                ],
                'status' => false,
                'password' => Hash::make('password'),
            ]
        );

        // 2. Membuat 9 data dummy lainnya menggunakan factory
        MahasiswaBaru::factory()->count(9)->create();
    }
}