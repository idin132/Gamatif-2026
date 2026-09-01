<?php

namespace App\Filament\Resources\NamaBarangBawaanResource\Pages;

use App\Filament\Resources\NamaBarangBawaanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNamaBarangBawaans extends ListRecords
{
    protected static string $resource = NamaBarangBawaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
