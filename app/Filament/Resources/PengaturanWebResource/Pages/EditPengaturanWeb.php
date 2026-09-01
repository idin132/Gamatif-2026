<?php

namespace App\Filament\Resources\PengaturanWebResource\Pages;

use App\Filament\Resources\PengaturanWebResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengaturanWeb extends EditRecord
{
    protected static string $resource = PengaturanWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
