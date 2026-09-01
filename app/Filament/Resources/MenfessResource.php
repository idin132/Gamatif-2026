<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenfessResource\Pages;
use App\Models\Menfess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenfessResource extends Resource
{
    protected static ?string $model = Menfess::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Menfess';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('from')->label('Dari')->required(),
                Forms\Components\TextInput::make('to')->label('Untuk')->required(),
                Forms\Components\Textarea::make('message')->label('Pesan')->required()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from')->label('Dari')->searchable(),
                Tables\Columns\TextColumn::make('to')->label('Untuk')->searchable(),
                Tables\Columns\TextColumn::make('message')->label('Pesan')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenfesses::route('/'),
        ];
    }
}