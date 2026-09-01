<?php

namespace App\Filament\Widgets;

use App\Models\MahasiswaBaru;
use App\Models\BarangSitaan;
use App\Models\Kelompok;
use App\Models\IzinKehadiran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = auth()->user();

        // Tampilan Statistik untuk PK (Khusus House-nya saja)
        if ($user && $user->isPk()) {
            $kelompokId = $user->kelompok_id;
            $totalAnggota = MahasiswaBaru::where('kelompok_id', $kelompokId)->count();
            $terverifikasi = MahasiswaBaru::where('kelompok_id', $kelompokId)->where('status', 1)->count();
            $totalSitaan = BarangSitaan::where('kelompok_id', $kelompokId)->count();

            return [
                Stat::make('Anggota House', $totalAnggota)
                    ->description('Mahasiswa baru di kelompok Anda')
                    ->descriptionIcon('heroicon-m-user-group')
                    ->color('primary'),
                Stat::make('Terverifikasi (ACC)', $terverifikasi)
                    ->description('Anggota yang sudah di-ACC')
                    ->descriptionIcon('heroicon-m-check-badge')
                    ->color('success'),
                Stat::make('Barang Disita', $totalSitaan)
                    ->description('Total barang sitaan kelompok')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('danger'),
            ];
        }

        // Tampilan Statistik untuk Admin (Seluruh Data)
        $totalMaba = MahasiswaBaru::count();
        $accCount = MahasiswaBaru::where('status', 1)->count();
        $pendingCount = MahasiswaBaru::where('status', 0)->count();
        $totalIzin = IzinKehadiran::count();

        return [
            Stat::make('Total Mahasiswa Baru', $totalMaba)
                ->description('Pendaftar terdata')
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