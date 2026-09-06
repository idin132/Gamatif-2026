<?php

namespace App\Filament\Resources\BarangSitaanResource\Pages;

use App\Filament\Resources\BarangSitaanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBarangSitaan extends CreateRecord
{
    protected static string $resource = BarangSitaanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
