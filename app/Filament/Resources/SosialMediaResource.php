<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SosialMediaResource\Pages;
use App\Models\SosialMedia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SosialMediaResource extends Resource
{
    protected static ?string $model = SosialMedia::class;
    protected static ?string $navigationIcon = 'heroicon-o-share';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Sosial Media';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')->required(),
                Forms\Components\TextInput::make('url')->url()->required(),
                Forms\Components\FileUpload::make('thumbnail')->image()->directory('sosmed_icons'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->circular(),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('url')->openUrlInNewTab(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSosialMedia::route('/'),
            'create' => Pages\CreateSosialMedia::route('/create'),
            'edit' => Pages\EditSosialMedia::route('/{record}/edit'),
        ];
    }
}