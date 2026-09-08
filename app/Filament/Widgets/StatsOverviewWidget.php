<?php

namespace App\Filament\Widgets;

use App\Models\MahasiswaBaru;
use App\Models\IzinKehadiran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalMaba = MahasiswaBaru::count();
        $lakiLaki = MahasiswaBaru::where('jenis_kelamin', 'L')->count();
        $perempuan = MahasiswaBaru::where('jenis_kelamin', 'P')->count();

        $accCount = MahasiswaBaru::where('status', 1)->count();
        $pendingCount = MahasiswaBaru::where('status', 0)->count();
        $totalIzin = IzinKehadiran::count();

        return [
            Stat::make('Total Mahasiswa Baru', $totalMaba)
                ->description("L: {$lakiLaki} · P: {$perempuan}")
                ->descriptionIcon('heroicon-m-users')
                ->chart([7, 12, 18, 25, 30, $totalMaba])
                ->color('primary'),

            Stat::make('Sudah di-ACC', $accCount)
                ->description('Status verifikasi aktif')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Menunggu ACC', $pendingCount)
                ->description('Perlu tindakan verifikasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingCount > 0 ? 'warning' : 'gray'),

            Stat::make('Pengajuan Izin / Sakit', $totalIzin)
                ->description('Surat izin masuk')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),
        ];
    }
}