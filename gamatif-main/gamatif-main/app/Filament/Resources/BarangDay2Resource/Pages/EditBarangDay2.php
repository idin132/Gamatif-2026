<?php

namespace App\Filament\Resources\BarangDay2Resource\Pages;

use App\Filament\Resources\BarangDay2Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangDay2 extends EditRecord
{
    protected static string $resource = BarangDay2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
