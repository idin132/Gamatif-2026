<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\BarangDay1;
use Filament\Tables\Table;
use App\Models\BarangBawaan;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangDay1Resource\Pages;
use App\Filament\Resources\BarangDay1Resource\RelationManagers;
use Filament\Tables\Columns\IconColumn;
use App\Models\IzinKehadiran;

class BarangDay1Resource extends Resource
{
    protected static ?string $model = BarangDay1::class;

   
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $pluralModelLabel = 'Barang Bawaan Day 1';

    protected static ?string $navigationGroup = 'Barang Bawaan';
protected static ?int $navigationSort = 3;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

public static function getEloquentQuery(): Builder
{
    // $query = parent::getEloquentQuery()->with('izins'); // eager-load relasi izins
    $query = parent::getEloquentQuery(); // eager-load relasi izins

    $user = auth()->user();
    if ($user->email !== 'admin@gmail.com') {
        $query->where('kelompok_id', $user->kelompok_id);
    }

    return $query;
}

public static function table(Table $table): Table
{
    return $table
        ->defaultPaginationPageOption('all')
        ->defaultSort('nim', 'asc')
        ->columns([
            TextColumn::make('index')->label('No')->rowIndex(),
            TextColumn::make('nim')
            ->searchable()
            ->sortable()
            ->color(fn ($record) => 
                    // Akses relasi 'izin' untuk mendapatkan data
                    // Ganti 'izinKehadiran' dengan nama relasi yang benar di model Anda
                    collect($record->izinKehadiran)
                        ->contains(fn ($izin) => 
                            in_array('day1', $izin->day ?? [])  
                            
                        )
                        ? 'danger' 
                        : null
                ),
            
         
            TextColumn::make('nama')
                ->searchable()
                ->sortable()
                ->color(fn ($record) => 
                    // Akses relasi 'izin' untuk mendapatkan data
                    // Ganti 'izinKehadiran' dengan nama relasi yang benar di model Anda
                    collect($record->izinKehadiran)
                        ->contains(fn ($izin) => 
                            in_array('day1', $izin->day ?? [])  
                            
                        )
                        ? 'danger' 
                        : null
                ),

            TextColumn::make('kelompok.nama_kelompok')
                ->searchable()
                ->formatStateUsing(fn ($state) => str_replace('_', ' ', $state)),

            CheckboxColumn::make('barang_1_day_1')->label('Better')->alignCenter(),
            CheckboxColumn::make('barang_2_day_1')->label('Makanan Beban')->alignCenter(),
            CheckboxColumn::make('barang_3_day_1')->label('Air Susu Putih')->alignCenter(),
            CheckboxColumn::make('barang_4_day_1')->label('Roti Croissant')->alignCenter(),
            CheckboxColumn::make('barang_5_day_1')->label('Paket 5')->alignCenter(),
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
            'index' => Pages\ListBarangDay1s::route('/'),
            // 'create' => Pages\CreateBarangDay1::route('/create'),
            // 'edit' => Pages\EditBarangDay1::route('/{record}/edit'),
        ];
    }
}
