<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KetuaAngkatanResource\Pages;
use App\Filament\Resources\KetuaAngkatanResource\RelationManagers;
use App\Models\KetuaAngkatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KetuaAngkatanResource extends Resource
{
    protected static ?string $model = KetuaAngkatan::class;


    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $pluralModelLabel = 'Ketua Angkatan';
    protected static ?int $navigationSort = 1;
   public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('nim')
                ->label('NIM')
                ->required()
                ->maxLength(20),

            Forms\Components\TextInput::make('nama')
                ->label('Nama')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('kelas')
                ->label('Kelas')
                ->required()
                ->maxLength(50),

            Forms\Components\FileUpload::make('foto')
                ->label('Foto')
                ->image()
                ->directory('uploads/foto')
                ->required(),

            Forms\Components\Textarea::make('visi')
                ->label('Visi')
                ->rows(3)
                ->required(),

            Forms\Components\Textarea::make('misi')
                ->label('Misi')
                ->rows(3)
                ->required(),
        ]);
}



public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('nim')
                ->label('NIM')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('nama')
                ->label('Nama')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('kelas')
                ->label('Kelas')
                ->sortable(),

            Tables\Columns\ImageColumn::make('foto')
                ->label('Foto')
                ->disk('public')
                ->height(60),

            Tables\Columns\TextColumn::make('visi')
                ->label('Visi')
                ->limit(50)
                ->tooltip(fn ($record) => $record->visi),

            Tables\Columns\TextColumn::make('misi')
                ->label('Misi')
                ->limit(50)
                ->tooltip(fn ($record) => $record->misi),

            
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
            'index' => Pages\ListKetuaAngkatans::route('/'),
            'create' => Pages\CreateKetuaAngkatan::route('/create'),
            'edit' => Pages\EditKetuaAngkatan::route('/{record}/edit'),
        ];
    }
}
