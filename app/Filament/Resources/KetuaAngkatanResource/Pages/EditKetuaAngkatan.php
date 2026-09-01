<?php

namespace App\Filament\Resources\KetuaAngkatanResource\Pages;

use App\Filament\Resources\KetuaAngkatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKetuaAngkatan extends EditRecord
{
    protected static string $resource = KetuaAngkatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
