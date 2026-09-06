<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\JadwalKegiatan;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JadwalKegiatanResource\Pages;
use App\Filament\Resources\JadwalKegiatanResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class JadwalKegiatanResource extends Resource
{
    protected static ?string $model = JadwalKegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $pluralModelLabel = 'jadwal kegiatan';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?int $navigationSort = 1;
  public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('nama')
                ->label('Nama Kegiatan')
                ->required()
                ->maxLength(255),

            DatePicker::make('tanggal')
                ->label('Tanggal')
                ->required(),

            TimePicker::make('waktu_mulai')
                ->label('Waktu Mulai')
                ->required(),

            TimePicker::make('waktu_selesai')
                ->label('Waktu Selesai')
                ->required(),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),

                TextColumn::make('waktu_mulai')
                    ->label('Waktu Mulai')
                    ->dateTime('H:i')
                    ->sortable(),

                TextColumn::make('waktu_selesai')
                    ->label('Waktu Selesai')
                    ->dateTime('H:i')
                    ->sortable(),

                TextColumn::make('created_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListJadwalKegiatans::route('/'),
            'create' => Pages\CreateJadwalKegiatan::route('/create'),
            'edit' => Pages\EditJadwalKegiatan::route('/{record}/edit'),
        ];
    }
}
