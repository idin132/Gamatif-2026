<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Actions\DeleteAction;
use Filament\Tables\Table;
use App\Models\AccpetDatamaba;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use App\Mail\MahasiswaBaruActivated;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AccpetDatamabaResource\Pages;
use App\Filament\Resources\AccpetDatamabaResource\RelationManagers;

class AccpetDatamabaResource extends Resource
{
    protected static ?string $model = AccpetDatamaba::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $pluralModelLabel = 'Acc Maba';
    protected static ?int $navigationSort = 1;
public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('nama_lengkap')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),

            TextInput::make('nim')
                ->label('NIM')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            Select::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required(),

            DatePicker::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->required(),

            Textarea::make('alamat')
                ->label('Alamat')
                ->rows(3),

            TextInput::make('nomor_whatsapp')
                ->label('Nomor WhatsApp')
                ->tel()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->unique(ignoreRecord: true)
                ->required(),

            FileUpload::make('bukti_sosmed')
                ->label('Bukti Sosmed')
                ->directory('bukti_sosmed')
                ->multiple()
                ->reorderable(),

            FileUpload::make('bukti_registrasi')
                ->label('Bukti Registrasi')
                ->directory('bukti_registrasi'),

            Select::make('kelompok_id')
                ->label('Kelompok')
                ->relationship('kelompok', 'nama_kelompok')
                ->searchable()
                ->nullable(),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                ->required(fn(string $context): bool => $context === 'create')
                ->dehydrated(fn($state) => filled($state))
                ->visible(fn(string $context): bool => $context !== 'view'),

            Toggle::make('status')
                ->label('Status')
                ->default(true),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                return $query->orderByRaw("
                CASE
                    WHEN status = 0 THEN 0
                    WHEN status IS NULL THEN 1
                    ELSE 2
                END
            ")->orderBy('nama_lengkap', 'asc'); // opsional, biar tetap rapi
            })

            ->columns([
                TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nomor_whatsapp')
                    ->label('No. WhatsApp'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                // tampilkan file bukti registrasi
                ImageColumn::make('bukti_registrasi')
                    ->label('Bukti Registrasi')
                    ->disk('public')
                    ->width(120)
                    ->height(70)
                    ->square()
                    ->url(fn($record) => Storage::disk('public')->url($record->foto))
                    ->extraImgAttributes(['loading' => 'lazy']),

                // Checkbox status aktif / tidak_aktif
                CheckboxColumn::make('status')
                    ->label('Status')
                    ->afterStateUpdated(function ($state, $record) {
                        if ($state) {
                            // Status changed to aktif, send email
                            Mail::to($record->email)->send(new MahasiswaBaruActivated($record->nama_lengkap));
                        }
                    })

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
            'index' => Pages\ListAccpetDatamabas::route('/'),
            // 'create' => Pages\CreateAccpetDatamaba::route('/create'),
            'edit' => Pages\EditAccpetDatamaba::route('/{record}/edit'),
        ];
    }
}
