<?php

namespace App\Filament\Resources\InfoDataMabaResource\Pages;

use App\Filament\Resources\InfoDataMabaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInfoDataMabas extends ListRecords
{
    protected static string $resource = InfoDataMabaResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
