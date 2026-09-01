<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelompokResource\Pages;
use App\Models\Kelompok;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KelompokResource extends Resource
{
    protected static ?string $model = Kelompok::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Kelompok';

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_kelompok')
                    ->label('Nama Kelompok / House')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url_grub')
                    ->label('Link WhatsApp Group')
                    ->url()
                    ->placeholder('https://chat.whatsapp.com/...')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('nama_kelompok')->label('Nama House')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('mahasiswa_barus_count')
                    ->counts('mahasiswaBarus')
                    ->label('Jumlah Maba')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('url_grub')
                    ->label('Link WhatsApp')
                    ->openUrlInNewTab()
                    ->icon('heroicon-m-link'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKelompoks::route('/'),
            'create' => Pages\CreateKelompok::route('/create'),
            'edit' => Pages\EditKelompok::route('/{record}/edit'),
        ];
    }
}