<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangBawaanDay1Resource\Pages;
use App\Models\DataMahasiswa;
use App\Models\NamaBarangBawaan;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BarangBawaanDay1Resource extends Resource
{
    protected static ?string $model = DataMahasiswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Barang Bawaan';
    protected static ?string $navigationLabel = 'Barang Bawaan Day 1';

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
        // Ambil daftar master barang khusus Day 1 berdasarkan urutan ID
        $items = NamaBarangBawaan::where('hari', 'day_1')->orderBy('id', 'asc')->pluck('nama_barang')->toArray();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nim')->label('Nim')->searchable(),
                Tables\Columns\TextColumn::make('nama')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')->label('Kelompok')->badge()->color('warning'),

                // Label dinamis: Jika ada di DB pakai nama barangnya, jika belum diisi fallback ke Barang X
                Tables\Columns\ToggleColumn::make('makanan_berat_day_1')->label($items[0] ?? 'Makanan Berat'),
                Tables\Columns\ToggleColumn::make('susu_superhero_day_1')->label($items[1] ?? 'Ultra Milk'),
                Tables\Columns\ToggleColumn::make('raja_dangdut_day_1')->label($items[2] ?? 'Roma'),
                Tables\Columns\ToggleColumn::make('snack_rindu_day_1')->label($items[3] ?? 'Dilan'),
                Tables\Columns\ToggleColumn::make('wafer_terkenal_day_1')->label($items[4] ?? 'Superstar')


            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelompok_id')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->visible(fn() => auth()->user()?->isAdmin()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangBawaanDay1s::route('/'),
        ];
    }
}