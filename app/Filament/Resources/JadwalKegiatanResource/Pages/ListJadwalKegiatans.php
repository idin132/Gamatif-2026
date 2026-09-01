<?php

namespace App\Filament\Resources\JadwalKegiatanResource\Pages;

use App\Filament\Resources\JadwalKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJadwalKegiatans extends ListRecords
{
    protected static string $resource = JadwalKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
