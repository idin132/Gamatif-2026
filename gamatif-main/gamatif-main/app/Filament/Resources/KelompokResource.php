<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kelompok;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KelompokResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KelompokResource\RelationManagers;

class KelompokResource extends Resource
{
    protected static ?string $model = Kelompok::class;

     protected static ?string $navigationLabel = 'Kelompok';
    protected static ?string $pluralLabel = 'Kelompok';
      protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data Master';
  protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
         return $form
        ->schema([
            TextInput::make('nama_kelompok') 
                ->label('Nama Kelompok')
                ->required()
                ->maxLength(255)
                ->placeholder('Masukkan nama kelompok'),
                 TextInput::make('url_grub')
                ->label('Link Grup')
                ->url() // otomatis validasi format URL
                ->maxLength(255)
                ->placeholder('Masukkan link grup (misal: https://chat.whatsapp.com/xxx)'),
        ]);

    }
     public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('nama_kelompok')
                    ->label('Nama Kelompok')
                    ->searchable()
                    ->sortable(),
                    TextColumn::make('url_grub')
                    ->label('url grub')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
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
    public static function getRelations(): array
    {
        return [
            //
        ];
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
