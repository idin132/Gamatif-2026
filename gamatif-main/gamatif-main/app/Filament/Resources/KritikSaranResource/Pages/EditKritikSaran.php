<?php

namespace App\Filament\Resources\KritikSaranResource\Pages;

use App\Filament\Resources\KritikSaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKritikSaran extends EditRecord
{
    protected static string $resource = KritikSaranResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}
