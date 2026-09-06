<?php
namespace App\Exports;

use App\Models\Absensi;
use App\Models\NamaBarangBawaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BarangBawaanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $allBarang;

    public function __construct()
    {
        $this->allBarang = NamaBarangBawaan::pluck('Nama_Barang', 'id')->toArray();
    }

    public function collection()
    {
        return Absensi::with(['mahasiswaBaru.kelompok','jadwalKegiatan','barangBawaans.namaBarangBawaan'])
            ->where('status', 'hadir')
            ->get();
    }

    public function headings(): array
    {
        $headings = ['NIM','Nama Mahasiswa','Kelompok','Jadwal Kegiatan'];

        // Tambahkan nama semua barang sebagai kolom
        return array_merge($headings, array_values($this->allBarang));
    }

    public function map($row): array
    {
        $base = [
            $row->mahasiswaBaru->nim ?? '-',
            $row->mahasiswaBaru->nama_lengkap ?? '-',
            $row->mahasiswaBaru->kelompok->nama_kelompok ?? '-',
            $row->jadwalKegiatan->nama ?? '-',
        ];

        // Buat kolom barang bawaan (1 = dibawa, 0 = tidak)
        $barangColumns = [];
        foreach ($this->allBarang as $id => $nama) {
            $barangColumns[] = $row->barangBawaans->contains('Nama_Barang_Bawaan_id', $id) ? 1 : 0;
        }

        return array_merge($base, $barangColumns);
    }
}
