<?php

namespace App\Filament\Resources\NamaBarangBawaanResource\Pages;

use App\Filament\Resources\NamaBarangBawaanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNamaBarangBawaan extends CreateRecord
{
    protected static string $resource = NamaBarangBawaanResource::class;
      protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
