<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangSitaanResource\Pages;
use App\Filament\Resources\BarangSitaanResource\RelationManagers;
use App\Models\BarangSitaan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangSitaanResource extends Resource
{
    protected static ?string $model = BarangSitaan::class;

    protected static ?string $navigationGroup = 'Barang Bawaan';
    protected static ?string $navigationLabel = 'Barang Sitaan';
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kelompok_id')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->default(fn() => auth()->user()?->kelompok_id)
                    ->disabled(fn() => auth()->user()?->isPk())
                    ->required(),
                Forms\Components\DatePicker::make('tanggal')
                    ->default(now())
                    ->required(),
                Forms\Components\TextInput::make('barang_sitaan')
                    ->label('Nama Barang Sitaan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('foto')
                    ->image()
                    ->directory('barang_sitaan')
                    ->required(fn(string $context): bool => $context === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangSitaans::route('/'),
            'create' => Pages\CreateBarangSitaan::route('/create'),
            'edit' => Pages\EditBarangSitaan::route('/{record}/edit'),
        ];
    }
}
