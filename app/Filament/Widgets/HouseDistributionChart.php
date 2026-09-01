<?php

namespace App\Filament\Widgets;

use App\Models\Kelompok;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HouseDistributionChart extends BaseWidget
{
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    protected function getStats(): array
    {
        $kelompoks = Kelompok::withCount('mahasiswaBarus')->get();

        $stats = [];
        foreach ($kelompoks as $kelompok) {
            $stats[] = Stat::make($kelompok->nama_kelompok, $kelompok->mahasiswa_barus_count)
                ->description('Total anggota')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning');
        }

        return $stats;
    }
}