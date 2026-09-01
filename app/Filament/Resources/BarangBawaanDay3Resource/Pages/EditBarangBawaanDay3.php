<?php

namespace App\Filament\Resources\BarangBawaanDay3Resource\Pages;

use App\Filament\Resources\BarangBawaanDay3Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangBawaanDay3 extends EditRecord
{
    protected static string $resource = BarangBawaanDay3Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
