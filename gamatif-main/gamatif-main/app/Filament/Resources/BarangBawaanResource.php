<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Absensi;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BarangBawaan;
use App\Models\NamaBarangBawaan;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangBawaanResource\Pages;
use App\Filament\Resources\BarangBawaanResource\RelationManagers;
use App\Filament\Resources\BarangBawaanResource\Pages\EditBarangBawaan;
use App\Filament\Resources\BarangBawaanResource\Pages\ListBarangBawaans;
use App\Filament\Resources\BarangBawaanResource\Pages\CreateBarangBawaan;
use Illuminate\Support\Facades\Auth;
use App\Exports\BarangBawaanExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\Action;

class BarangBawaanResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralModelLabel = 'barang bawaan';

 


public static function getEloquentQuery(): Builder
{
    $user = Auth::user();

    $query = parent::getEloquentQuery()
        ->with(['mahasiswaBaru.kelompok', 'barangBawaans'])
        ->where('status', 'hadir');

    if ($user->role == 'pk') {
        $query->whereHas('mahasiswaBaru.kelompok', function ($q) use ($user) {
            $q->where('id', $user->kelompok_id);
        });
    }

    return $query;
}


public static function table(Table $table): Table
{
    // Ambil filter jadwal kegiatan aktif
    $selectedJadwalId = request()->input('tableFilters.jadwal_kegiatan_id.value');

    // Barang bawaan sesuai filter
    $barangList = NamaBarangBawaan::query()
        ->when($selectedJadwalId, fn($q) => $q->where('jadwal_kegiatan_id', $selectedJadwalId))
        ->orderBy('id')
        ->get();

    return $table
   
        ->headerActions([
    // Export semua data barang bawaan
    Action::make('export_barang_bawaan')
        ->label('Export Barang Bawaan')
        ->icon('heroicon-o-arrow-down-tray')
        ->action(function () {
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\BarangBawaanExport(),
                'barang_bawaan.xlsx'
            );
        }),
])

        ->columns(array_merge([
            TextColumn::make('id')
                ->label('No')
                ->rowIndex(),

            TextColumn::make('mahasiswaBaru.nim')
                ->label('NIM')
                ->sortable()
                ->searchable(),

            TextColumn::make('mahasiswaBaru.nama_lengkap')
                ->label('Nama')
                ->sortable()
                ->searchable(),

            TextColumn::make('jadwalKegiatan.nama')
                ->label('Jadwal Kegiatan')
                ->sortable()
                ->searchable(),

            
        ], $barangList->map(function ($barang) {
            return CheckboxColumn::make("barang_{$barang->id}")
                ->label($barang->Nama_Barang)
                ->alignCenter()
                ->getStateUsing(fn($record) => $record->barangBawaans
                    ->contains('Nama_Barang_Bawaan_id', $barang->id))
                ->afterStateUpdated(function ($state, $record) use ($barang) {
                    if ($state) {
                        BarangBawaan::firstOrCreate([
                            'absensi_id'            => $record->id,
                            'jadwal_kegiatan_id'    => $record->jadwal_kegiatan_id,
                            'Nama_Barang_Bawaan_id' => $barang->id,
                        ]);
                    } else {
                        BarangBawaan::where('absensi_id', $record->id)
                            ->where('jadwal_kegiatan_id', $record->jadwal_kegiatan_id)
                            ->where('Nama_Barang_Bawaan_id', $barang->id)
                            ->delete();
                    }
                });
        })->toArray()))
        ->filters([
            Tables\Filters\SelectFilter::make('jadwal_kegiatan_id')
                ->label('Jadwal Kegiatan')
                ->relationship('jadwalKegiatan', 'nama')
                ->searchable()
                ->preload(),
        ])
        ->defaultSort('id', 'asc');
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
            'index' => Pages\ListBarangBawaans::route('/'),
           
        ];
    }
}
