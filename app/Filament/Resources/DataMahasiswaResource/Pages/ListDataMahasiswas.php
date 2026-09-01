<?php

namespace App\Filament\Resources\DataMahasiswaResource\Pages;

use App\Filament\Resources\DataMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataMahasiswas extends ListRecords
{
    protected static string $resource = DataMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
