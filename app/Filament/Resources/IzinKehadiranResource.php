<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IzinKehadiranResource\Pages;
use App\Models\IzinKehadiran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class IzinKehadiranResource extends Resource
{
    protected static ?string $model = IzinKehadiran::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-minus';
    protected static ?string $navigationGroup = 'Absensi Mahasiswa';
    protected static ?string $navigationLabel = 'Izin / Sakit';

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
                    ->required(),
                Forms\Components\Select::make('jadwal_kegiatan_id')
                    ->relationship('jadwalKegiatan', 'nama')
                    ->required(),
                Forms\Components\Select::make('keterangan')
                    ->options([
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('catatan')
                    ->label('Alasan / Catatan')
                    ->required(),
                Forms\Components\FileUpload::make('foto')
                    ->label('Bukti Surat / Foto')
                    ->image()
                    ->directory('bukti_izin')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswaBaru.nama_lengkap')->label('Mahasiswa')->searchable(),
                Tables\Columns\TextColumn::make('jadwalKegiatan.nama')->label('Kegiatan'),
                Tables\Columns\BadgeColumn::make('keterangan')
                    ->colors([
                        'warning' => 'izin',
                        'danger' => 'sakit',
                    ]),
                Tables\Columns\TextColumn::make('catatan')->limit(30),
                Tables\Columns\ImageColumn::make('foto')->label('Bukti'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIzinKehadirans::route('/'),
            'create' => Pages\CreateIzinKehadiran::route('/create'),
            'edit' => Pages\EditIzinKehadiran::route('/{record}/edit'),
        ];
    }
}