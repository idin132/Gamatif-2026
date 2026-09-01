<?php

namespace App\Filament\Resources\BarangBawaanDay1Resource\Pages;

use App\Filament\Resources\BarangBawaanDay1Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangBawaanDay1 extends EditRecord
{
    protected static string $resource = BarangBawaanDay1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
