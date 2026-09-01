<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfoDataMabaResource\Pages;
use App\Models\MahasiswaBaru;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InfoDataMabaResource extends Resource
{
    // Tambahkan baris ini untuk menyembunyikan dari sidebar:
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = MahasiswaBaru::class;
    protected static ?string $slug = 'info-data-maba';
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'Absensi Mahasiswa';
    protected static ?string $navigationLabel = 'Info DataMaba';

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
                Tables\Columns\TextColumn::make('nim')->label('NIM')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nama_lengkap')->label('Nama Lengkap')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')->label('House')->badge()->color('warning'),
                Tables\Columns\TextColumn::make('nomor_whatsapp')->label('No. WA')->copyable()->icon('heroicon-m-phone'),
                Tables\Columns\TextColumn::make('jenis_kelamin')->label('JK')->badge(),
                Tables\Columns\TextColumn::make('alamat')->label('Alamat')->limit(30),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInfoDataMabas::route('/'),
        ];
    }
}