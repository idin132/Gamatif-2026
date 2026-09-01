<?php

namespace App\Filament\Resources\BarangBawaanDay2Resource\Pages;

use App\Filament\Resources\BarangBawaanDay2Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangBawaanDay2 extends EditRecord
{
    protected static string $resource = BarangBawaanDay2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
