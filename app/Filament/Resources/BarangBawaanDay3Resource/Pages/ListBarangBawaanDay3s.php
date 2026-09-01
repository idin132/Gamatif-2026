<?php

namespace App\Filament\Resources\BarangBawaanDay3Resource\Pages;

use App\Filament\Resources\BarangBawaanDay3Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangBawaanDay3s extends ListRecords
{
    protected static string $resource = BarangBawaanDay3Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
