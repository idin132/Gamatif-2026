<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\BarangDay3;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangDay3Resource\Pages;
use App\Filament\Resources\BarangDay3Resource\RelationManagers;

class BarangDay3Resource extends Resource
{
    protected static ?string $model = BarangDay3::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $pluralModelLabel = 'Barang Bawaan Day 3';
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
    $query = parent::getEloquentQuery();
    $user = auth()->user();

    // Jika login bukan admin, filter berdasarkan kelompok
    if ($user->email !== 'admin@gmail.com') {
        $kelompokId = $user->kelompok_id;
        $query->where('kelompok_id', $kelompokId);
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
                            in_array('day3', $izin->day ?? [])  
                            
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
                    collect($record->izinKehadiran) // Asumsi relasi 'izinKehadiran' adalah hasMany
                        ->contains(fn ($izin) => 
                            in_array('day3', $izin->day ?? [])
                        )
                        ? 'danger' 
                        : null
                ),

            TextColumn::make('kelompok.nama_kelompok')->searchable()
            ->formatStateUsing(fn ($state) => str_replace('_', ' ', $state)),

            CheckboxColumn::make('barang_1_day_3')->label('Permen Relaxa')->alignCenter(),
            CheckboxColumn::make('barang_2_day_3')->label('Oreo')->alignCenter(),
            CheckboxColumn::make('barang_3_day_3')->label('Makanan Beban')->alignCenter(),
            CheckboxColumn::make('barang_4_day_3')->label('Milo')->alignCenter(),
            CheckboxColumn::make('barang_5_day_3')->label('Roti Dorayaki')->alignCenter(),
        ])
         
        ->actions([
            // Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
          ->filters(array_filter([
            auth()->user()->role === 'admin'
                ? SelectFilter::make('kelompok_id')
                    ->label('Kelompok')
                    ->relationship('kelompok', 'nama_kelompok')
                : null,
        ]));
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
            'index' => Pages\ListBarangDay3s::route('/'),
            // 'create' => Pages\CreateBarangDay3::route('/create'),
            // 'edit' => Pages\EditBarangDay3::route('/{record}/edit'),
        ];
    }
}
