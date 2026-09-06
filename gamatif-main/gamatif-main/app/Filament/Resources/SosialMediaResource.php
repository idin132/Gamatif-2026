<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SosialMedia;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SosialMediaResource\Pages;
use App\Filament\Resources\SosialMediaResource\RelationManagers;

class SosialMediaResource extends Resource
{
    protected static ?string $model = SosialMedia::class;

    protected static ?string $navigationIcon = 'heroicon-o-share';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $pluralModelLabel = 'Sosial Media';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Data Konten')
                ->description('Isi data konten dengan lengkap.')
                ->schema([

                    TextInput::make('nama')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    FileUpload::make('thumbnail')
                        ->label('Thumbnail')
                        ->image()
                        ->preserveFilenames()
                        ->disk('public')
                        ->directory('Thumbnail')
                        ->openable()
                        ->previewable()
                        ->downloadable()
                        ->maxSize(5120) // Maks 5 MB
                        ->columnSpanFull(),

                    TextInput::make('url')
                        ->label('URL')
                        ->url()
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                ImageColumn::make('thumbnail')
                ->label('thumbnail')
                ->disk('public')
                ->width(120)
                ->height(70)
                ->square()
                ->url(fn ($record) => Storage::disk('public')->url($record->thumbnail))
                ->extraImgAttributes(['loading' => 'lazy']),

                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSosialMedia::route('/'),
            'create' => Pages\CreateSosialMedia::route('/create'),
            'edit' => Pages\EditSosialMedia::route('/{record}/edit'),
        ];
    }
}
