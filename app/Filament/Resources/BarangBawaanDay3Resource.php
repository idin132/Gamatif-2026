<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangBawaanDay3Resource\Pages;
use App\Models\DataMahasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BarangBawaanDay3Resource extends Resource
{
    protected static ?string $model = DataMahasiswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-trash';
    protected static ?string $navigationGroup = 'Barang Bawaan';
    protected static ?string $navigationLabel = 'Barang Bawaan Day 3';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();
        if ($user && $user->isPk()) {
            return $query->where('kelompok_id', $user->kelompok_id);
        }
        return $query;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nim')->searchable(),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')->badge()->color('warning'),
                Tables\Columns\ToggleColumn::make('barang_1_day_3')->label('Barang 1'),
                Tables\Columns\ToggleColumn::make('barang_2_day_3')->label('Barang 2'),
                Tables\Columns\ToggleColumn::make('barang_3_day_3')->label('Barang 3'),
                Tables\Columns\ToggleColumn::make('barang_4_day_3')->label('Barang 4'),
                Tables\Columns\ToggleColumn::make('barang_5_day_3')->label('Barang 5'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelompok_id')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->visible(fn () => auth()->user()?->isAdmin()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangBawaanDay3s::route('/'),
        ];
    }
}