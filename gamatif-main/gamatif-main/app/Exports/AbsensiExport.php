<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kelompokId;

    // Konstruktor biar bisa passing filter kelompok
    public function __construct($kelompokId = null)
    {
        $this->kelompokId = $kelompokId;
    }

    /**
     * Ambil semua data absensi dengan relasi mahasiswa & jadwal
     */
    public function collection()
    {
        $query = Absensi::with(['mahasiswaBaru.kelompok', 'jadwalKegiatan']);

        if ($this->kelompokId) {
            $query->whereHas('mahasiswaBaru', function ($q) {
                $q->where('kelompok_id', $this->kelompokId);
            });
        }

        return $query->get();
    }

    /**
     * Judul kolom CSV
     */
    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Kelompok',
            'Kegiatan',
            'Status',
            'Waktu Absen',
        ];
    }

    /**
     * Mapping isi setiap baris
     */
    public function map($absensi): array
    {
        return [
            $absensi->mahasiswaBaru->nim ?? '-',
            $absensi->mahasiswaBaru->nama_lengkap ?? '-',
            $absensi->mahasiswaBaru->kelompok->nama_kelompok ?? '-',
            $absensi->jadwalKegiatan->nama ?? '-',
            ucfirst($absensi->status),
            $absensi->created_at ? $absensi->created_at->format('d M Y H:i') : '-',
        ];
    }
}
