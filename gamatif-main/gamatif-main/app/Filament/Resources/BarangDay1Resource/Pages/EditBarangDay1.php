<?php

namespace App\Filament\Resources\BarangDay1Resource\Pages;

use App\Filament\Resources\BarangDay1Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangDay1 extends EditRecord
{
    protected static string $resource = BarangDay1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
