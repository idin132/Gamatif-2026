<?php

namespace App\Exports;

use App\Models\DataMahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataMahasiswaExport implements FromCollection, WithHeadings, WithMapping
{
    private ?int $kelompokId;
    private int $rowNumber = 0;

    public function __construct(?int $kelompokId = null)
    {
        $this->kelompokId = $kelompokId;
    }

    public function collection()
    {
        $query = DataMahasiswa::with('kelompok')->orderBy('nim');

        if ($this->kelompokId) {
            $query->where('kelompok_id', $this->kelompokId);
        }

        return $query->get();
    }

    public function map($row): array
    {
        $this->rowNumber++;

        $present = function ($val) {
            return ($val == 1) ? 'Hadir' : 'Tidak Hadir';
        };

        $bawa = function ($val) {
            return ($val == 1) ? 'Bawa' : 'Tidak Bawa';
        };

        return [
            $this->rowNumber,                            
            $row->nim,
            $row->nama,
            $row->kelompok?->nama_kelompok ?? '-',

            // hadir / tidak hadir (day 1..3)
            $present($row->day_1 ?? 0),
            $present($row->day_2 ?? 0),
            $present($row->day_3 ?? 0),

            // barang day 1
            $bawa($row->barang_1_day_1 ?? 0),
            $bawa($row->barang_2_day_1 ?? 0),
            $bawa($row->barang_3_day_1 ?? 0),
            $bawa($row->barang_4_day_1 ?? 0),
            $bawa($row->barang_5_day_1 ?? 0),

            // barang day 2
            $bawa($row->barang_1_day_2 ?? 0),
            $bawa($row->barang_2_day_2 ?? 0),
            $bawa($row->barang_3_day_2 ?? 0),
            $bawa($row->barang_4_day_2 ?? 0),
            $bawa($row->barang_5_day_2 ?? 0),

            // barang day 3
            $bawa($row->barang_1_day_3 ?? 0),
            $bawa($row->barang_2_day_3 ?? 0),
            $bawa($row->barang_3_day_3 ?? 0),
            $bawa($row->barang_4_day_3 ?? 0),
            $bawa($row->barang_5_day_3 ?? 0),
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama',
            'Kelompok',
            'Day 1',
            'Day 2',
            'Day 3',
            // day 1 barang bawaan
            'Day 1 better ',
            'Day 1 makanan beban ',
            'Day 1 air susu putih ',
            'Day 1 roti croissant ',
            'Day 1 Barang 5 ',
            // day 2 barang bawaan
            'Day 2 Indomilk ',
            'Day 2 Roti Sobek ',
            'Day 2 Chiki Taro ',
            'Day 2 Makanan Beban ',
            'Day 2 Slai Olai ',
            // day 3 barang bawaan
            'Day 3 Permen Relaxa ',
            'Day 3 Oreo ',
            'Day 3 Makanan Beban ',
            'Day 3 Milo ',
            'Day 3 Roti Dorayaki ',
        ];
    }
}
