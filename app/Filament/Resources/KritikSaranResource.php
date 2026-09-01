<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KritikSaranResource\Pages;
use App\Models\KritikSaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KritikSaranResource extends Resource
{
    protected static ?string $model = KritikSaran::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Kritik & Saran';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->placeholder('Anonim')->searchable(),
                Tables\Columns\TextColumn::make('pesan')->wrap(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKritikSarans::route('/'),
        ];
    }
}