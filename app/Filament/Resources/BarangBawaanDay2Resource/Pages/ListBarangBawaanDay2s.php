<?php

namespace App\Filament\Resources\BarangBawaanDay2Resource\Pages;

use App\Filament\Resources\BarangBawaanDay2Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangBawaanDay2s extends ListRecords
{
    protected static string $resource = BarangBawaanDay2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
