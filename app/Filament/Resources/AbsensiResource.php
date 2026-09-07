<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Models\Absensi;
use App\Models\MahasiswaBaru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Absensi Mahasiswa';
    protected static ?string $navigationLabel = 'Absensi';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->isPk()) {
            return $query->whereHas('mahasiswaBaru', function ($q) use ($user) {
                $q->where('kelompok_id', $user->kelompok_id);
            });
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('mahasiswa_baru_id')
                    ->relationship('mahasiswaBaru', 'nama_lengkap')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('kelompok_id')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('jadwal_kegiatan_id')
                    ->relationship('jadwalKegiatan', 'nama')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'telat' => 'Telat',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpa' => 'Alpa',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. NIM
                Tables\Columns\TextColumn::make('mahasiswaBaru.nim')
                    ->label('NIM')
                    ->searchable()
                    ->sortable(),

                // 2. Kelompok (Langsung dari kolom kelompok_id di tabel absensi)
                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')
                    ->label('Kelompok')
                    ->badge()
                    ->color('warning')
                    ->searchable()
                    ->sortable(),

                // 3. Jadwal Kegiatan
                Tables\Columns\TextColumn::make('jadwalKegiatan.nama')
                    ->label('Jadwal Kegiatan')
                    ->sortable(),

                // 4. Status Kehadiran
                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'hadir' => 'Hadir',
                        'telat' => 'Telat',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpa' => 'Alpa',
                    ]),
            ])
            ->filters([
                // Filter Kelompok / House
                Tables\Filters\SelectFilter::make('kelompok_id')
                    ->label('Filter Berdasarkan Kelompok')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->preload(),

                // Filter Kegiatan
                Tables\Filters\SelectFilter::make('jadwal_kegiatan_id')
                    ->label('Filter Jadwal Kegiatan')
                    ->relationship('jadwalKegiatan', 'nama')
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }
}