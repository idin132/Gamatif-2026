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
        $user = auth()->user();
        return $form
            ->schema([
                Forms\Components\Select::make('mahasiswa_baru_id')
                    ->label('Mahasiswa Baru')
                    ->relationship('mahasiswaBaru', 'nama_lengkap', function (Builder $query) use ($user) {
                        if ($user && $user->isPk()) {
                            return $query->where('kelompok_id', $user->kelompok_id);
                        }
                        return $query;
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('jadwal_kegiatan_id')
                    ->label('Jadwal Kegiatan')
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
                    ->default('alpa')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswaBaru.nim')->label('NIM')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('mahasiswaBaru.nama_lengkap')->label('Nama Mahasiswa')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('mahasiswaBaru.kelompok.nama_kelompok')->label('House')->badge()->color('warning'),
                Tables\Columns\TextColumn::make('jadwalKegiatan.nama')->label('Kegiatan'),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'telat' => 'Telat',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpa' => 'Alpa',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jadwal_kegiatan_id')
                    ->relationship('jadwalKegiatan', 'nama')
                    ->label('Filter Jadwal'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'telat' => 'Telat',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpa' => 'Alpa',
                    ]),
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