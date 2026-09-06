<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kelompok;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BarangSitaan;
use App\Models\DataMahasiswa;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangSitaanResource\Pages;
use App\Filament\Resources\BarangSitaanResource\RelationManagers;

class BarangSitaanResource extends Resource
{
    protected static ?string $model = BarangSitaan::class;
    protected static ?string $navigationGroup = 'Barang Bawaan';

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
protected static ?int $navigationSort = 3;

 protected static ?string $pluralModelLabel = 'Barang Sitaan';

    public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();
    $user = auth()->user();

    // Jika login bukan admin, filter berdasarkan kelompok
    if ($user->email !== 'admin@gmail.com') {
        $kelompokId = $user->kelompok_id;
        $query->where('kelompok_id', $kelompokId);
    }

    return $query;
}

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Data Mahasiswa')
                ->schema([
                    DatePicker::make('tanggal')
                        ->native(false)
                        ->required(),

                    Select::make('kelompok_id')
                        ->label('Kelompok')
                        ->formatStateUsing(fn ($state) => str_replace('_', ' ', $state))
                        ->options(Kelompok::pluck('nama_kelompok', 'id'))
                        ->searchable()
                        ->required(),

                    TextInput::make('barang_sitaan')
                        ->label('Barang Sitaan')
                        ->required(),

                    Section::make('Bukti Barang Sitaan')
                        ->description('Wajib Melampirkan Bukti!!')
                        ->schema([
                            Fieldset::make('Maximum Ukuran Foto 5 MB !!')
                                ->schema([
                                    FileUpload::make('foto')
                                        ->label('')
                                        ->image()
                                        ->preserveFilenames()
                                        ->disk('public')
                                        ->directory('BarangSitaan')
                                        ->openable()
                                        ->previewable()
                                        ->downloadable()
                                        ->maxSize(5120) // max 5 MB
                                        ->required()
                                        ->columnSpanFull(),
                                ]),
                        ]),
                ]),
        ]);
}


  public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('No')
                ->rowIndex(),

          
            TextColumn::make('kelompok.nama_kelompok')
                ->formatStateUsing(fn ($state) => str_replace('_', ' ', $state))
                ->label('Kelompok'),

            TextColumn::make('barang_sitaan'),
            
            ImageColumn::make('foto')
                ->label('Bukti Pelanggaran')
                ->disk('public')
                ->width(120)
                ->height(70)
                ->square()
                ->url(fn ($record) => Storage::disk('public')->url($record->foto))
                ->extraImgAttributes(['loading' => 'lazy']),

            TextColumn::make('download_link')
                ->label('Download')
                ->getStateUsing(fn ($record) => 'Download')
                ->url(fn ($record) => route('BarangSitaan.download', $record->id))
                ->openUrlInNewTab()
                ->extraAttributes([
                    'class' => 'text-blue-600 hover:underline font-medium',
                ])
                ->sortable(false),
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
            'index' => Pages\ListBarangSitaans::route('/'),
            'create' => Pages\CreateBarangSitaan::route('/create'),
            'edit' => Pages\EditBarangSitaan::route('/{record}/edit'),
        ];
    }
}
