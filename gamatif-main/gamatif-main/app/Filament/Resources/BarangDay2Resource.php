<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\BarangDay2;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangDay2Resource\Pages;
use App\Filament\Resources\BarangDay2Resource\RelationManagers;

class BarangDay2Resource extends Resource
{
    protected static ?string $model = BarangDay2::class;

protected static ?int $navigationSort = 3;
    
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $pluralModelLabel = 'Barang Bawaan Day 2';

    protected static ?string $navigationGroup = 'Barang Bawaan';

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
                            in_array('day2', $izin->day ?? [])  
                            
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
                            in_array('day2', $izin->day ?? []) 
                        )
                        ? 'danger' 
                        : null
                ),

            TextColumn::make('kelompok.nama_kelompok')->searchable()
            ->formatStateUsing(fn ($state) => str_replace('_', ' ', $state)),

            CheckboxColumn::make('barang_1_day_2')->label('Indomilk')->alignCenter(),
            CheckboxColumn::make('barang_2_day_2')->label('Roti Sobek')->alignCenter(),
            CheckboxColumn::make('barang_3_day_2')->label('Chiki Taro')->alignCenter(),
            CheckboxColumn::make('barang_4_day_2')->label('Makanan Beban')->alignCenter(),
            CheckboxColumn::make('barang_5_day_2')->label('Slai Olai')->alignCenter(),
        ])
               ->filters(array_filter([
            auth()->user()->role === 'admin'
                ? SelectFilter::make('kelompok_id')
                    ->label('Kelompok')
                    ->relationship('kelompok', 'nama_kelompok')
                : null,
        ]))
        
        ->actions([
            // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBarangDay2s::route('/'),
            // 'create' => Pages\CreateBarangDay2::route('/create'),
            // 'edit' => Pages\EditBarangDay2::route('/{record}/edit'),
        ];
    }
}
