<?php

namespace App\Filament\Resources\NamaBarangBawaanResource\Pages;

use App\Filament\Resources\NamaBarangBawaanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNamaBarangBawaan extends EditRecord
{
    protected static string $resource = NamaBarangBawaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
      protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
