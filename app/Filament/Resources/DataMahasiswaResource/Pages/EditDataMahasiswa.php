<?php

namespace App\Filament\Resources\DataMahasiswaResource\Pages;

use App\Filament\Resources\DataMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataMahasiswa extends EditRecord
{
    protected static string $resource = DataMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
