<?php

namespace App\Filament\Resources\SosialMediaResource\Pages;

use App\Filament\Resources\SosialMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSosialMedia extends EditRecord
{
    protected static string $resource = SosialMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
