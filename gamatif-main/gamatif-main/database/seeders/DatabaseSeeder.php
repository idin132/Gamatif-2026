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
            ['nama_kelompok' => 'Gipsy Danger', 'url_grub' => 'https://chat.whatsapp.com/BZsFiidskgqL22jrzFDdol'],
            ['nama_kelompok' => 'Striker Eureka', 'url_grub' => 'https://chat.whatsapp.com/BBVfieNwyW3AI1Vjfe5tPg?mode=ems_wa_t'],
            ['nama_kelompok' => 'Crimson Typhoon', 'url_grub' => 'https://chat.whatsapp.com/BAQ2nT5accALPoqoLj7PUd'],
            ['nama_kelompok' => 'Cherno Alpha', 'url_grub' => 'https://chat.whatsapp.com/HcbjRPHB46cEalHnySS6V2'],
            ['nama_kelompok' => 'Bracer Phoenix', 'url_grub' => 'https://chat.whatsapp.com/I915MvyzQD6H25Xb3f38LB'],
            ['nama_kelompok' => 'Saber Athena', 'url_grub' => 'https://chat.whatsapp.com/F3V3tjONYn5LyBpBylGXS7'],
            ['nama_kelompok' => 'Titan Redeemer', 'url_grub' => 'https://chat.whatsapp.com/DEhQLmCai ps7RCGhPYmZnv'], // <-- hapus spasi
            ['nama_kelompok' => 'Guardian Bravo', 'url_grub' => 'https://chat.whatsapp.com/CeArAaJgKC9CQ3KAqlxFTu'],
            ['nama_kelompok' => 'Obsidian Fury', 'url_grub' => 'https://chat.whatsapp.com/DPN3iHxA2RBDJ0t4IRFTBQ'],
            ['nama_kelompok' => 'Horizon Brave', 'url_grub' => 'https://chat.whatsapp.com/LR2GP8JtLc09NZ2VDpRGhQ'],
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
            'password' => Hash::make('adm_admin123'),
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
            ['nim' => '10001', 'nama' => 'Gipsy Danger', 'nama_kelompok' => 'Gipsy Danger'],
            ['nim' => '10002', 'nama' => 'Striker Eureka', 'nama_kelompok' => 'Striker Eureka'],
            ['nim' => '10003', 'nama' => 'Crimson Typhoon', 'nama_kelompok' => 'Crimson Typhoon'],
            ['nim' => '10004', 'nama' => 'Cherno Alpha', 'nama_kelompok' => 'Cherno Alpha'],
            ['nim' => '10005', 'nama' => 'Bracer Phoenix', 'nama_kelompok' => 'Bracer Phoenix'],
            ['nim' => '10006', 'nama' => 'Saber Athena', 'nama_kelompok' => 'Saber Athena'],
            ['nim' => '10007', 'nama' => 'Titan Redeemer', 'nama_kelompok' => 'Titan Redeemer'],
            ['nim' => '10008', 'nama' => 'Guardian Bravo', 'nama_kelompok' => 'Guardian Bravo'],
            ['nim' => '10009', 'nama' => 'Obsidian Fury', 'nama_kelompok' => 'Obsidian Fury'],
            ['nim' => '10010', 'nama' => 'Horizon Brave', 'nama_kelompok' => 'Horizon Brave'],
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
