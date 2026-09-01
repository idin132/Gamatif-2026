<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NamaBarangBawaanResource\Pages;
use App\Models\NamaBarangBawaan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NamaBarangBawaanResource extends Resource
{
    protected static ?string $model = NamaBarangBawaan::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Nama Barang Bawaans';
    protected static ?int $navigationSort = 2; // Tepat di bawah Dashboard

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_barang')->required(),
                Forms\Components\Select::make('hari')
                    ->options([
                        'day_1' => 'Day 1',
                        'day_2' => 'Day 2',
                        'day_3' => 'Day 3',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('deskripsi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_barang')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('hari')
                    ->colors([
                        'primary' => 'day_1',
                        'warning' => 'day_2',
                        'success' => 'day_3',
                    ]),
                Tables\Columns\TextColumn::make('deskripsi')->limit(50),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNamaBarangBawaans::route('/'),
            'create' => Pages\CreateNamaBarangBawaan::route('/create'),
            'edit' => Pages\EditNamaBarangBawaan::route('/{record}/edit'),
        ];
    }
}