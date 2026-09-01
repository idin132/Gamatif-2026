<?php

use App\Models\User;
use App\Models\Kelompok;
use App\Models\DataMahasiswa;
use Database\Seeders\MahasiswaBaruSeeder;
use Database\Seeders\JadwalKegiatanSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil seeder lain
        $this->call([
            MahasiswaBaruSeeder::class,
            JadwalKegiatanSeeder::class,
        ]);

        // Daftar nama kelompok + url grup
     $kelompokData = [
            ['nama_kelompok' => 'Atreides', 'url_grub' => 'https://chat.whatsapp.com/GIg1XxjpWIwBeB9GMitFtE?s=cl&p=a&mlu=4'],
            ['nama_kelompok' => 'Harkonnen', 'url_grub' => 'https://chat.whatsapp.com/Llw3KVnw9nqKkwJB4YOQvs?s=cl&p=a&mlu=4'],
            ['nama_kelompok' => 'Corinno', 'url_grub' => 'https://chat.whatsapp.com/IDFc84TTGBq8V09hBfj56z?s=cl&p=a&mlu=4'],
            ['nama_kelompok' => 'Vernius', 'url_grub' => 'https://chat.whatsapp.com/HiB1D8zPrht8r0JSg4f0R5?s=cl&p=a&mlu=4'],
            ['nama_kelompok' => 'Richese', 'url_grub' => 'https://chat.whatsapp.com/KWDU8egEu0CL1XwDC1OZBx?s=cl&p=a&mlu=4'],
            ['nama_kelompok' => 'Ginaz', 'url_grub' => 'https://chat.whatsapp.com/BGoNbkEFYEqHtxd9LyQyy7?s=cl&p=a&mlu=4'],
        ];


        // Simpan data kelompok ke DB dan buat mapping
        $kelompoks = [];
        foreach ($kelompokData as $data) {
            $kelompoks[$data['nama_kelompok']] = Kelompok::create($data);
        }

        // Buat user Admin
        User::factory()->create([
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'kelompok_id' => null,
        ]);

        // Buat user untuk masing-masing kelompok
        foreach ($kelompoks as $namaKelompok => $kelompok) {
            $emailName = str_replace(' ', '_', $namaKelompok);

            User::factory()->create([
                'name' => 'PK - ' . $namaKelompok,
                'role' => 'pk',
                'email' => strtolower($emailName) . '@gmail.com',
                'password' => Hash::make(strtolower($emailName)),
                'kelompok_id' => $kelompok->id,
            ]);
        }

        // Data mahasiswa
        $mahasiswaData = [
            ['nim' => '10001', 'nama' => 'Atreides', 'nama_kelompok' => 'Atreides'],
            ['nim' => '10002', 'nama' => 'Harkonnen', 'nama_kelompok' => 'Harkonnen'],
            ['nim' => '10003', 'nama' => 'Corinno', 'nama_kelompok' => 'Corinno'],
            ['nim' => '10004', 'nama' => 'Vernius', 'nama_kelompok' => 'Vernius'],
            ['nim' => '10005', 'nama' => 'Richese', 'nama_kelompok' => 'Richese'],
            ['nim' => '10006', 'nama' => 'Ginaz', 'nama_kelompok' => 'Ginaz'],
        ];

        foreach ($mahasiswaData as $data) {
            DataMahasiswa::create([
                'nim' => $data['nim'],
                'nama' => $data['nama'],
                'kelompok_id' => $kelompoks[$data['nama_kelompok']]->id,
            ]);
        }
    }
}
