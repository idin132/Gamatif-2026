<?php

namespace App\Filament\Resources\MenfessResource\Pages;

use App\Filament\Resources\MenfessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMenfesses extends ListRecords
{
    protected static string $resource = MenfessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
