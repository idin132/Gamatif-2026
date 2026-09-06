<?php

namespace App\Filament\Resources\IzinKehadiranResource\Pages;

use App\Filament\Resources\IzinKehadiranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIzinKehadiran extends EditRecord
{
    protected static string $resource = IzinKehadiranResource::class;

     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
