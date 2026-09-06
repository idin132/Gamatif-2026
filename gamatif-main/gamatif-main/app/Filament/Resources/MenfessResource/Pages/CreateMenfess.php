<?php

namespace App\Filament\Resources\MenfessResource\Pages;

use App\Filament\Resources\MenfessResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMenfess extends CreateRecord
{
    protected static string $resource = MenfessResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
