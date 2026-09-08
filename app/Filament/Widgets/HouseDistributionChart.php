<?php

namespace App\Filament\Widgets;

use App\Models\Kelompok;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HouseDistributionChart extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // Ambil semua kelompok beserta hitungan maba dan jenis kelaminnya
        $kelompoks = Kelompok::withCount([
            'mahasiswaBarus as total_anggota',
            'mahasiswaBarus as total_l' => function ($query) {
                $query->where('jenis_kelamin', 'L');
            },
            'mahasiswaBarus as total_p' => function ($query) {
                $query->where('jenis_kelamin', 'P');
            },
        ])->get();

        $stats = [];

        foreach ($kelompoks as $kelompok) {
            $stats[] = Stat::make($kelompok->nama_kelompok, $kelompok->total_anggota)
                ->description("L: {$kelompok->total_l} · P: {$kelompok->total_p}")
                ->descriptionIcon('heroicon-m-user-group')
                ->color($kelompok->total_anggota > 0 ? 'warning' : 'gray');
        }

        return $stats;
    }
}