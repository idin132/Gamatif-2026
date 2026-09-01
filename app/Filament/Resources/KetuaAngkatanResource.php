<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KetuaAngkatanResource\Pages;
use App\Models\KetuaAngkatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KetuaAngkatanResource extends Resource
{
    protected static ?string $model = KetuaAngkatan::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Ketua Angkatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nim')->required()->maxLength(255),
                Forms\Components\TextInput::make('nama')->required()->maxLength(255),
                Forms\Components\TextInput::make('kelas')->required()->maxLength(255),
                Forms\Components\FileUpload::make('foto')
                    ->image()
                    ->directory('ketua_angkatan')
                    ->required(),
                Forms\Components\Textarea::make('visi')->required()->columnSpanFull(),
                Forms\Components\Textarea::make('misi')->required()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')->circular(),
                Tables\Columns\TextColumn::make('nim')->searchable(),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('kelas'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKetuaAngkatans::route('/'),
            'create' => Pages\CreateKetuaAngkatan::route('/create'),
            'edit' => Pages\EditKetuaAngkatan::route('/{record}/edit'),
        ];
    }
}