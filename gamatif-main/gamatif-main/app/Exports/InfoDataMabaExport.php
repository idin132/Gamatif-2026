<?php

namespace App\Exports;

use App\Models\InfoDataMaba;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class InfoDataMabaExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected ?int $kelompokId = null;

    public function __construct($kelompokId = null)
    {
        $this->kelompokId = $kelompokId;
    }

    public function query()
    {
        $query = InfoDataMaba::with('kelompok');

        if ($this->kelompokId) {
            $query->where('kelompok_id', $this->kelompokId);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Lengkap',
            'Nomor WhatsApp',   
            'Kelompok',
        ];
    }

    public function map($row): array
    {
        return [
            $row->nim,
            $row->nama_lengkap,
            $row->nomor_whatsapp,
            $row->kelompok->nama_kelompok ?? 'Maba belum ambil kelompok',
        ];
    }
}
