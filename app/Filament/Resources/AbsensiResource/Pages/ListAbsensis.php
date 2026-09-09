<?php

namespace App\Filament\Resources\AbsensiResource\Pages;

use App\Filament\Resources\AbsensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsensis extends ListRecords
{
    protected static string $resource = AbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tombol Pintasan ke Halaman Scanner QR
            Actions\Action::make('scan_qr')
                ->label('Scan QR Presensi')
                ->icon('heroicon-o-qr-code')
                ->color('warning')
                ->url(url('/admin-scan'))
                ->openUrlInNewTab(),
            Actions\CreateAction::make(),
        ];
    }
}
