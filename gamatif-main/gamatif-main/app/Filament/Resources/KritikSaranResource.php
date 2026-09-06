<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KritikSaranResource\Pages;
use App\Filament\Resources\KritikSaranResource\RelationManagers;
use App\Models\KritikSaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KritikSaranResource extends Resource
{
    protected static ?string $model = KritikSaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $pluralModelLabel = 'Kritik Saran';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

  public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('nama')
                ->label('Nama')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('pesan')
                ->label('Pesan')
                ->limit(50) // biar tidak kepanjangan di tabel
                ->tooltip(fn ($record) => $record->pesan),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Tanggal Dibuat')
                ->dateTime('d M Y H:i') // format tanggal
                ->sortable(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\ViewAction::make(), // bisa lihat detail
      
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
            'index' => Pages\ListKritikSarans::route('/'),
            // 'create' => Pages\CreateKritikSaran::route('/create'),
            // 'edit' => Pages\EditKritikSaran::route('/{record}/edit'),
        ];
    }
}
