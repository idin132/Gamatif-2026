<?php

namespace App\Filament\Resources\BarangBawaanResource\Pages;

use App\Filament\Resources\BarangBawaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangBawaans extends ListRecords
{
    protected static string $resource = BarangBawaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
