<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenfessResource\Pages;
use App\Filament\Resources\MenfessResource\RelationManagers;
use App\Models\Menfess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenfessResource extends Resource
{
    protected static ?string $model = Menfess::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $pluralModelLabel = 'Menfess';
    protected static ?int $navigationSort = 2;
  public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('from')
                ->label('From')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('to')
                ->label('To')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('message')
                ->label('Message')
                ->required()
                ->rows(4),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('from')
                ->label('From')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('to')
                ->label('To')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('message')
                ->label('Message')
                ->limit(50)
                ->tooltip(fn ($record) => $record->message),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime('d M Y H:i')
                ->sortable(),
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
            'index' => Pages\ListMenfesses::route('/'),
            'create' => Pages\CreateMenfess::route('/create'),
            'edit' => Pages\EditMenfess::route('/{record}/edit'),
        ];
    }
}
