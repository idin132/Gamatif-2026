<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaturanWebResource\Pages;
use App\Models\PengaturanWeb;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PengaturanWebResource extends Resource
{
    protected static ?string $model = PengaturanWeb::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Pengaturan Web';

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_kegiatan')->required(),
                Forms\Components\TextInput::make('email')->email(),
                Forms\Components\TextInput::make('admin_wa_1')->label('Nomor WA Admin 1'),
                Forms\Components\TextInput::make('admin_wa_2')->label('Nomor WA Admin 2'),
                Forms\Components\FileUpload::make('buku_saku')->label('File Buku Panduan / Saku')->directory('buku_saku')->openable(),
                Forms\Components\Section::make('Logo & Maskot')
                    ->columns(3)
                    ->schema([
                        Forms\Components\FileUpload::make('logo_gamatif')->image()->directory('logos'),
                        Forms\Components\FileUpload::make('logo_unikom')->image()->directory('logos'),
                        Forms\Components\FileUpload::make('logo_hmif')->image()->directory('logos'),
                        Forms\Components\FileUpload::make('logo_kabinet')->image()->directory('logos'),
                        Forms\Components\FileUpload::make('logo_maskot')->image()->directory('logos'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kegiatan'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('admin_wa_1'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengaturanWebs::route('/'),
            'edit' => Pages\EditPengaturanWeb::route('/{record}/edit'),
        ];
    }
}