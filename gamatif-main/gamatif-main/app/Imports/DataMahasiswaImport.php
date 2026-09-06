<?php

namespace App\Imports;

use App\Models\Kelompok;
use App\Models\DataMahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class DataMahasiswaImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    
     public function headingRow(): int
    {
        return 1; // header ada di baris pertama
    }
    
   public function model(array $row) 
{
    
    $nim          = $row['nim'] ?? null;   // bukan 'NIM'
    $nama         = $row['nama'] ?? null;  // bukan 'NAMA'
    $kelompokName = $row['kelompok'] ?? null;
    // dd($row); // cek struktur dulu

    if (empty($nim)) {
        return null; // skip baris kosong
    }

    $kelompok = Kelompok::firstOrCreate([
        'nama_kelompok' => $kelompokName ?? 'Tanpa Kelompok',
    ]);

    return DataMahasiswa::firstOrCreate(
        ['nim' => $nim],
        [
            'nama'        => $nama ?? '-',
            'kelompok_id' => $kelompok->id,
        ]
    );
}

}

