<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalKegiatanResource\Pages;
use App\Models\JadwalKegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JadwalKegiatanResource extends Resource
{
    protected static ?string $model = JadwalKegiatan::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Jadwal Kegiatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Kegiatan / Hari')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal')
                    ->required(),
                Forms\Components\TimePicker::make('waktu_mulai')
                    ->required(),
                Forms\Components\TimePicker::make('waktu_selesai')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Kegiatan')->searchable(),
                Tables\Columns\TextColumn::make('tanggal')->date('d F Y')->sortable(),
                Tables\Columns\TextColumn::make('waktu_mulai')->time('H:i'),
                Tables\Columns\TextColumn::make('waktu_selesai')->time('H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn () => auth()->user()?->isAdmin()),
                Tables\Actions\DeleteAction::make()->visible(fn () => auth()->user()?->isAdmin()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwalKegiatans::route('/'),
            'create' => Pages\CreateJadwalKegiatan::route('/create'),
            'edit' => Pages\EditJadwalKegiatan::route('/{record}/edit'),
        ];
    }
}