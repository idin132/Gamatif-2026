<?php

namespace App\Filament\Resources\BarangDay3Resource\Pages;

use App\Filament\Resources\BarangDay3Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarangDay3 extends EditRecord
{
    protected static string $resource = BarangDay3Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
