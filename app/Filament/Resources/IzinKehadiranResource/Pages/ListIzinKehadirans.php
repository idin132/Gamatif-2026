<?php

namespace App\Filament\Resources\IzinKehadiranResource\Pages;

use App\Filament\Resources\IzinKehadiranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIzinKehadirans extends ListRecords
{
    protected static string $resource = IzinKehadiranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
