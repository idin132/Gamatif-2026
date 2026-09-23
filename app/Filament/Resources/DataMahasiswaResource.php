<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataMahasiswaResource\Pages;
use App\Models\DataMahasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DataMahasiswaResource extends Resource
{
    protected static ?string $model = DataMahasiswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Barang Bawaan';
    protected static ?string $navigationLabel = 'Checklist Bawaan Maba';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->isPk()) {
            return $query->where('kelompok_id', $user->kelompok_id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nim')
                    ->label('NIM')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('kelompok_id')
                    ->label('Kelompok / House')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->required(),
                Forms\Components\Section::make('Kelengkapan Day 1')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Toggle::make('makanan_berat_day_1')->label('Makanan Berat'),
                        Forms\Components\Toggle::make('roti_kepompong_day_1')->label('Roti Kepompong (Croissant)'),
                        
                    ]),
                Forms\Components\Section::make('Kelengkapan Day 2')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Toggle::make('makanan_berat_day_2')->label('Makanan Berat'),
                        Forms\Components\Toggle::make('roti_kepompong_day_2')->label('Roti Kepompong (Croissant)'),
                    ]),
                Forms\Components\Section::make('Kelengkapan Day 3')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Toggle::make('makanan_berat_day_3')->label('Makanan Berat'),
                        Forms\Components\Toggle::make('roti_kepompong_day_3')->label('Roti Kepompong (Croissant)'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nim')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')->badge()->color('warning'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelompok_id')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->visible(fn() => auth()->user()?->isAdmin()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataMahasiswas::route('/'),
            'edit' => Pages\EditDataMahasiswa::route('/{record}/edit'),
        ];
    }
}