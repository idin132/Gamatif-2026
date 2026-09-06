<?php

namespace App\Filament\Resources;

use App\Models\Kelompok;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions;
use App\Models\DataMahasiswa;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use App\Exports\DataMahasiswaExport;
use App\Imports\DataMahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use pxlrbt\FilamentExcel\Actions\ImportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use App\Filament\Resources\DataMahasiswaResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Forms\Components\Select as FormsSelect;

class DataMahasiswaResource extends Resource
{
    protected static ?string $model = DataMahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $pluralModelLabel = 'Data Mahasiswa';
        protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Mahasiswa')
                    ->schema([
                        TextInput::make('nim')
                            ->required()
                            ->placeholder('Masukkan Nim Mahasiswa'),
                        TextInput::make('nama')
                            ->required()
                            ->placeholder('Masukkan Nama Mahasiswa'),
                        Select::make('kelompok_id')
                            ->label('Kelompok')
                            ->placeholder('Pilih Kelompok')
                            ->searchable()
                            ->options(function () {
                                return Kelompok::orderBy('nama_kelompok')
                                    ->pluck('nama_kelompok', 'id')
                                    ->toArray();
                            })
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('index')
                ->label('No')
                ->rowIndex(),
            TextColumn::make('nim')
                ->label('NIM')
                ->searchable()
                ->sortable(),
            TextColumn::make('nama')
                ->label('Nama')
                ->searchable()
                ->sortable(),
            TextColumn::make('kelompok.nama_kelompok')
                ->label('Kelompok')
                ->sortable()
                 ->formatStateUsing(fn ($state) => str_replace('_', ' ', $state)),
        ])
        ->filters([
            // Filter Kelompok
            \Filament\Tables\Filters\SelectFilter::make('kelompok_id')
                ->label('Kelompok')
                ->options(
                    \App\Models\Kelompok::orderBy('nama_kelompok')
                        ->pluck('nama_kelompok', 'id')
                        ->toArray()
                )
                ->searchable(),
        ])
         ->headerActions([
    // Export semua data
    Action::make('export_all')
        ->label('Export Semua')
        ->icon('heroicon-o-arrow-down-tray')
        ->action(function () {
            return Excel::download(new DataMahasiswaExport(null), 'data_mahasiswa_all.xlsx');
        }),

    // Export per kelompok (modal pilih kelompok)
        Action::make('export_per_kelompok')
        ->label('Export per Kelompok')
        ->icon('heroicon-o-funnel') // 
        ->form([
            FormsSelect::make('kelompok_id')
                ->label('Kelompok')
                ->options(fn () => Kelompok::orderBy('nama_kelompok')->pluck('nama_kelompok', 'id')->toArray())
                ->searchable()
                ->required(),
        ])
        ->action(function (array $data) {
            $kelompokId = $data['kelompok_id'];
            $kelompok = Kelompok::find($kelompokId);
            $filename = 'data_mahasiswa_' . ($kelompok?->nama_kelompok ?? $kelompokId) . '.xlsx';

            return Excel::download(new DataMahasiswaExport($kelompokId), $filename);
        }),
        

           
        ])
        ->actions([
            Actions\ViewAction::make(),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
                ExportBulkAction::make()
                    ->label('Export Excel')
                    ->icon('heroicon-o-document-arrow-down'),
            ]),
        ])

        ->defaultSort('nim', 'asc')
        ->defaultPaginationPageOption(50);
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
            'index' => Pages\ListDataMahasiswas::route('/'),
            'create' => Pages\CreateDataMahasiswa::route('/create'),
            'edit' => Pages\EditDataMahasiswa::route('/{record}/edit'),
        ];
    }
}