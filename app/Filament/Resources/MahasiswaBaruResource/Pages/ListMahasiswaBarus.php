<?php

namespace App\Filament\Resources\MahasiswaBaruResource\Pages;

use App\Filament\Resources\MahasiswaBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMahasiswaBarus extends ListRecords
{
    protected static string $resource = MahasiswaBaruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
