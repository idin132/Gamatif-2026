<?php

namespace App\Filament\Resources\BarangSitaanResource\Pages;

use App\Filament\Resources\BarangSitaanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangSitaan extends EditRecord
{
    protected static string $resource = BarangSitaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
