<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KetuaAngkatanResource\Pages;
use App\Models\DataMahasiswa;
use App\Models\KetuaAngkatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KetuaAngkatanResource extends Resource
{
    protected static ?string $model = KetuaAngkatan::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Ketua Angkatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('nim')
                    ->label('Mahasiswa')
                    ->options(fn () => DataMahasiswa::query()
                        ->orderBy('nama')
                        ->get()
                        ->mapWithKeys(fn (DataMahasiswa $mahasiswa) => [
                            $mahasiswa->nim => "{$mahasiswa->nama} ({$mahasiswa->nim})",
                        ]))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->live()
                    ->afterStateUpdated(function (?string $state, Set $set): void {
                        $mahasiswa = DataMahasiswa::query()
                            ->where('nim', $state)
                            ->first();

                        $set('nama', $mahasiswa?->nama);
                        $set('kelompok_id', $mahasiswa?->kelompok_id);
                    }),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\TextInput::make('kelas')->required()->maxLength(255),
                Forms\Components\Select::make('kelompok_id')
                    ->label('House')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\FileUpload::make('foto')
                    ->image()
                    ->directory('ketua_angkatan')
                    ->nullable(),
                Forms\Components\Textarea::make('visi')->required()->columnSpanFull(),
                Forms\Components\Textarea::make('misi')->required()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')->circular(),
                Tables\Columns\TextColumn::make('nim')->searchable(),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('kelas'),
                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')->label('House')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('votes_count')->label('Suara')->counts('votes'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKetuaAngkatans::route('/'),
            'create' => Pages\CreateKetuaAngkatan::route('/create'),
            'edit' => Pages\EditKetuaAngkatan::route('/{record}/edit'),
        ];
    }
}