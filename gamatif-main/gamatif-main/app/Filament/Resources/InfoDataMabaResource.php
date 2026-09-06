<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\InfoDataMaba;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InfoDataMabaResource\Pages;
use App\Filament\Resources\InfoDataMabaResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use App\Exports\InfoDataMabaExport;
use App\Models\Kelompok;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select as FormsSelect;
use Filament\Tables\Actions\Action;

class InfoDataMabaResource extends Resource
{
    protected static ?string $model = InfoDataMaba::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'Absensi Mahasiswa';
    protected static ?int $navigationSort = 3;
    // Label dinamis per kelompok (opsional, bisa pakai Blade)
    protected static ?string $pluralModelLabel = 'Info DataMaba';


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
            TextColumn::make('nim')
                ->label('NIM')
                ->sortable()
                ->searchable(),

            TextColumn::make('nama_lengkap')
                ->label('Nama Lengkap')
                ->sortable()
                ->searchable(),

                TextColumn::make('nomor_whatsapp')
                ->label('Nomor WA')
                ->url(fn ($record) => 'https://wa.me/' . preg_replace('/^0/', '62', $record->nomor_whatsapp)) // ubah 08 jadi 628
                ->openUrlInNewTab()
                ->color('info')
                ->icon('heroicon-o-phone'),

        TextColumn::make('kelompok.nama_kelompok')
            ->label('Kelompok')
            ->sortable()
            ->searchable()
            ->getStateUsing(fn ($record) => $record->kelompok->nama_kelompok ?? 'Maba belum ambil kelompok')
            ->color(fn ($record) => $record->kelompok ? 'success' : 'danger'),


        ])
        ->headerActions([
                        Action::make('export_all')
                ->label('Export Semua')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    return Excel::download(new InfoDataMabaExport(null), 'info_data_maba_all.xlsx');
                }),

            // Export per kelompok
            Action::make('export_per_kelompok')
                ->label('Export per Kelompok')
                ->icon('heroicon-o-funnel')
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
                    $filename = 'info_data_maba_' . ($kelompok?->nama_kelompok ?? $kelompokId) . '.xlsx';

                    return Excel::download(new InfoDataMabaExport($kelompokId), $filename);
                }),
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
            'index' => Pages\ListInfoDataMabas::route('/'),
            // 'create' => Pages\CreateInfoDataMaba::route('/create'),
            // 'edit' => Pages\EditInfoDataMaba::route('/{record}/edit'),
        ];
    }
}
