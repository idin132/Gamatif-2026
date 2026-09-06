<?php

namespace App\Filament\Resources\PengaturanWebResource\Pages;

use App\Filament\Resources\PengaturanWebResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePengaturanWeb extends CreateRecord
{
    protected static string $resource = PengaturanWebResource::class;
   
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
