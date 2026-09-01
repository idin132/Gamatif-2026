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
                    ->columns(5)
                    ->schema([
                        Forms\Components\Toggle::make('barang_1_day_1')->label('Barang 1'),
                        Forms\Components\Toggle::make('barang_2_day_1')->label('Barang 2'),
                        Forms\Components\Toggle::make('barang_3_day_1')->label('Barang 3'),
                        Forms\Components\Toggle::make('barang_4_day_1')->label('Barang 4'),
                        Forms\Components\Toggle::make('barang_5_day_1')->label('Barang 5'),
                    ]),
                Forms\Components\Section::make('Kelengkapan Day 2')
                    ->columns(5)
                    ->schema([
                        Forms\Components\Toggle::make('barang_1_day_2')->label('Barang 1'),
                        Forms\Components\Toggle::make('barang_2_day_2')->label('Barang 2'),
                        Forms\Components\Toggle::make('barang_3_day_2')->label('Barang 3'),
                        Forms\Components\Toggle::make('barang_4_day_2')->label('Barang 4'),
                        Forms\Components\Toggle::make('barang_5_day_2')->label('Barang 5'),
                    ]),
                Forms\Components\Section::make('Kelengkapan Day 3')
                    ->columns(5)
                    ->schema([
                        Forms\Components\Toggle::make('barang_1_day_3')->label('Barang 1'),
                        Forms\Components\Toggle::make('barang_2_day_3')->label('Barang 2'),
                        Forms\Components\Toggle::make('barang_3_day_3')->label('Barang 3'),
                        Forms\Components\Toggle::make('barang_4_day_3')->label('Barang 4'),
                        Forms\Components\Toggle::make('barang_5_day_3')->label('Barang 5'),
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
                Tables\Columns\TextColumn::make('day_1')->label('Hadir D1')->badge(),
                Tables\Columns\TextColumn::make('day_2')->label('Hadir D2')->badge(),
                Tables\Columns\TextColumn::make('day_3')->label('Hadir D3')->badge(),
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