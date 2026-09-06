<?php

namespace App\Filament\Widgets;

use App\Models\Kelompok;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KelompokCard extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    // 🏷️ Tambahkan judul di atas widget
    protected function getHeading(): string
    {
        return 'Daftar Kelompok';
    }

    protected function getStats(): array
    {
        $kelompok = Kelompok::withCount([
            'mahasiswaBaru as total_maba',
            'mahasiswaBaru as jumlah_laki' => fn($q) => $q->where('jenis_kelamin', 'L'),
            'mahasiswaBaru as jumlah_perempuan' => fn($q) => $q->where('jenis_kelamin', 'P'),
        ])->get();

        return $kelompok->map(function ($item, $index) {
            $bgColor = $index % 2 === 0 ? 'bg-white' : 'bg-gray-100';

            return Stat::make($item->nama_kelompok, $item->total_maba)
                ->description("L: {$item->jumlah_laki} | P: {$item->jumlah_perempuan}");
        })->toArray();
    }
}
