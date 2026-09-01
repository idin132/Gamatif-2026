<?php

namespace App\Filament\Resources\PengaturanWebResource\Pages;

use App\Filament\Resources\PengaturanWebResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengaturanWebs extends ListRecords
{
    protected static string $resource = PengaturanWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
