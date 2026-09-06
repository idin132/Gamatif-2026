<?php

namespace App\Filament\Widgets;

use App\Models\Kelompok;
use App\Models\MahasiswaBaru;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class DashboardOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // Ambil jumlah maba per hari (7 hari terakhir) untuk grafik mini
        $mabaPerHari = MahasiswaBaru::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total')
            ->toArray();

        // Untuk laki-laki
        $lakiPerHari = MahasiswaBaru::where('jenis_kelamin', 'L')
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total')
            ->toArray();

        // Untuk perempuan
        $perempuanPerHari = MahasiswaBaru::where('jenis_kelamin', 'P')
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total')
            ->toArray();

        return [
            Stat::make('Total Kelompok', Kelompok::count())
                ->description('Jumlah kelompok yang terdaftar')
                ->color('primary'),

            Stat::make('Total Maba', MahasiswaBaru::count())
                ->description('Jumlah seluruh mahasiswa baru')
                ->color('success')
                ->chart($mabaPerHari),

            Stat::make('Laki-laki', MahasiswaBaru::where('jenis_kelamin', 'L')->count())
                ->description('Jumlah maba laki-laki')
                ->color('info')
                ->chart($lakiPerHari),

            Stat::make('Perempuan', MahasiswaBaru::where('jenis_kelamin', 'P')->count())
                ->description('Jumlah maba perempuan')
                ->color('danger')
                ->chart($perempuanPerHari),
        ];
    }
}
