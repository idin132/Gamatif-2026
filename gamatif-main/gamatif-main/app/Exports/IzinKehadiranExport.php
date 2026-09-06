<?php

namespace App\Exports;

use App\Models\IzinKehadiran;
use App\Models\Kelompok;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IzinKehadiranExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kelompokId;

    public function __construct($kelompokId = null)
    {
        $this->kelompokId = $kelompokId;
    }

    public function collection()
    {
        $query = IzinKehadiran::with(['kelompok', 'mahasiswa']); // eager load relasi

        if ($this->kelompokId) {
            $query->where('kelompok_id', $this->kelompokId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Mahasiswa',
            'Tanggal',
            'Kelompok',
            'Keterangan',
            'Catatan', // ✅ tambahkan
            'Day', // ✅ tambahkan
        ];
    }

    public function map($row): array
    {
        return [
            $row->nim,
            optional($row->mahasiswa)->nama ?? '-',
            $row->tanggal,
            optional($row->kelompok)->nama_kelompok ?? $row->kelompok_id,
            $row->keterangan,
            $row->catatan, // ✅ ambil data dari kolom 'catatan'
            implode(', ', $row->day ?? []), // ✅ ubah array 'day' menjadi string
        ];
    }
}
