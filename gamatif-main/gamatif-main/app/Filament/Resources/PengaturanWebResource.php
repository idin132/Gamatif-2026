<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PengaturanWeb;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PengaturanWebResource\Pages;
use App\Filament\Resources\PengaturanWebResource\RelationManagers;

class PengaturanWebResource extends Resource
{
    protected static ?string $model = PengaturanWeb::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $pluralModelLabel = 'Pengaturan web';
    protected static ?int $navigationSort = 2;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Data Kegiatan')
                ->description('Lengkapi data kegiatan berikut.')
                ->schema([

                    TextInput::make('nama_kegiatan')
                        ->label('Nama Kegiatan')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('admin_wa_1')
                        ->label('Admin WhatsApp 1')
                        ->tel()
                        ->maxLength(20),

                    TextInput::make('admin_wa_2')
                        ->label('Admin WhatsApp 2')
                        ->tel()
                        ->maxLength(20),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255),

                    Fieldset::make('Upload Logo')
                        ->schema([
                            FileUpload::make('logo_unikom')
                                ->label('Logo UNIKOM')
                                ->image()
                                ->preserveFilenames()
                                ->disk('public')
                                ->directory('logo_unikom')
                                ->openable()
                                ->previewable()
                                ->downloadable()
                                ->maxSize(5120),

                            FileUpload::make('logo_hmif')
                                ->label('Logo HMIF')
                                ->image()
                                ->preserveFilenames()
                                ->disk('public')
                                ->directory('logo_hmif')
                                ->openable()
                                ->previewable()
                                ->downloadable()
                                ->maxSize(5120),

                            FileUpload::make('logo_kabinet')
                                ->label('Logo Kabinet')
                                ->image()
                                ->preserveFilenames()
                                ->disk('public')
                                ->directory('logo_kabinet')
                                ->openable()
                                ->previewable()
                                ->downloadable()
                                ->maxSize(5120),

                            FileUpload::make('logo_gamatif')
                                ->label('Logo Gamatif')
                                ->image()
                                ->preserveFilenames()
                                ->disk('public')
                                ->directory('logo_gamatif')
                                ->openable()
                                ->previewable()
                                ->downloadable()
                                ->maxSize(5120),

                            FileUpload::make('logo_maskot')
                                ->label('Logo Maskot')
                                ->image()
                                ->preserveFilenames()
                                ->disk('public')
                                ->directory('logo_maskot')
                                ->openable()
                                ->previewable()
                                ->downloadable()
                                ->maxSize(5120),
                          FileUpload::make('buku_saku')
                                ->label('Buku Saku (PDF)')
                                ->acceptedFileTypes(['application/pdf'])
                                ->preserveFilenames()
                                ->disk('public')
                                ->directory('buku_saku')
                                ->maxSize(10240) // max 10 MB
                                ->downloadable()
                                ->openable() // biar bisa langsung dibuka

                        ]),
                ]),
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            ImageColumn::make('logo_hmif')
                ->label('Logo HMIF')
                ->disk('public')
                ->width(120)
                ->height(70)
                ->square()
                ->url(fn ($record) => Storage::disk('public')->url($record->logo_hmif))
                ->extraImgAttributes(['loading' => 'lazy']),

            ImageColumn::make('logo_gamatif')
                ->label('Logo Gamatif')
                ->disk('public')
                ->width(120)
                ->height(70)
                ->square()
                ->url(fn ($record) => Storage::disk('public')->url($record->logo_gamatif))
                ->extraImgAttributes(['loading' => 'lazy']),

            // Tambahin kolom untuk Buku Saku (PDF)
            TextColumn::make('buku_saku')
                ->label('Buku Saku')
                ->url(fn ($record) => $record->buku_saku 
                    ? asset('storage/' . $record->buku_saku) 
                    : null)
                ->openUrlInNewTab()
                ->formatStateUsing(fn ($state) => $state ? '📕 Download PDF' : '-'),
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
            'index' => Pages\ListPengaturanWebs::route('/'),
            'create' => Pages\CreatePengaturanWeb::route('/create'),
            'edit' => Pages\EditPengaturanWeb::route('/{record}/edit'),
        ];
    }
}
