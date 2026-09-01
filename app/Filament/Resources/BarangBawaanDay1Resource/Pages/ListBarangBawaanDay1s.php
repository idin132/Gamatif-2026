<?php

namespace App\Filament\Resources\BarangBawaanDay1Resource\Pages;

use App\Filament\Resources\BarangBawaanDay1Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangBawaanDay1s extends ListRecords
{
    protected static string $resource = BarangBawaanDay1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
