<?php

namespace App\Filament\Resources\KetuaAngkatanResource\Pages;

use App\Filament\Resources\KetuaAngkatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKetuaAngkatans extends ListRecords
{
    protected static string $resource = KetuaAngkatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
