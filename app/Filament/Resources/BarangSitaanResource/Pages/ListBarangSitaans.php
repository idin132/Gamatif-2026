<?php

namespace App\Filament\Resources\BarangSitaanResource\Pages;

use App\Filament\Resources\BarangSitaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangSitaans extends ListRecords
{
    protected static string $resource = BarangSitaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
