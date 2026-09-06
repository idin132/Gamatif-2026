<?php

namespace App\Filament\Resources\AccpetDatamabaResource\Pages;

use App\Filament\Resources\AccpetDatamabaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccpetDatamaba extends EditRecord
{
    protected static string $resource = AccpetDatamabaResource::class;

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
