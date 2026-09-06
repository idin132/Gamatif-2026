<?php

namespace App\Filament\Resources\IzinKehadiranResource\Pages;

use App\Filament\Resources\IzinKehadiranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIzinKehadiran extends CreateRecord
{
    protected static string $resource = IzinKehadiranResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
