<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaBaruResource\Pages;
use App\Models\MahasiswaBaru;
use App\Mail\MabaAccNotification;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class MahasiswaBaruResource extends Resource
{
    protected static ?string $model = MahasiswaBaru::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Acc Maba / Data Maba';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->isPk()) {
            return $query->where('kelompok_id', $user->kelompok_id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi Mahasiswa')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nim')
                            ->label('NIM')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nomor_whatsapp')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Kelompok & Autentikasi')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('kelompok_id')
                            ->label('House / Kelompok')
                            ->relationship('kelompok', 'nama_kelompok')
                            ->disabled(fn() => auth()->user()?->isPk()),
                        Forms\Components\TextInput::make('password')
                            ->label('Password Akun Peserta')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('status')
                            ->label('Terverifikasi (ACC)')
                            ->default(false)
                            ->visible(fn() => auth()->user()?->isAdmin()),
                    ]),

                Forms\Components\Section::make('Berkas Pendaftaran')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('bukti_registrasi')
                            ->label('Bukti Registrasi')
                            ->directory('bukti_registrasi')
                            ->required(fn(string $context): bool => $context === 'create')
                            ->openable(),
                        Forms\Components\FileUpload::make('bukti_sosmed')
                            ->label('Bukti Follow Media Sosial')
                            ->multiple()
                            ->directory('bukti_sosmed')
                            ->required(fn(string $context): bool => $context === 'create')
                            ->openable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nim')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nama_lengkap')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')->badge()->color('warning')->placeholder('Belum Masuk House'),
                Tables\Columns\IconColumn::make('status')->boolean()->label('Status ACC'),
                Tables\Columns\TextColumn::make('nomor_whatsapp')->copyable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('status')->label('Status Verifikasi'),
                Tables\Filters\SelectFilter::make('kelompok_id')
                    ->relationship('kelompok', 'nama_kelompok')
                    ->visible(fn() => auth()->user()?->isAdmin()),
            ])
            ->actions([
                // Action::make('acc')
                //     ->label('ACC')
                //     ->icon('heroicon-o-check-badge')
                //     ->color('success')
                //     ->visible(fn(MahasiswaBaru $record) => !$record->status && auth()->user()?->isAdmin())
                //     ->requiresConfirmation()
                //     ->action(fn(MahasiswaBaru $record) => $record->update(['status' => 1])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('acc')
                    ->label('ACC')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => $record->status == 0)
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Mahasiswa Baru')
                    ->modalDescription('Apakah Anda yakin ingin menyetujui akun maba ini? Email notifikasi akan dikirim secara otomatis.')
                    ->action(function ($record) {
                        $record->update(['status' => 1]);

                        // Kirim email notifikasi
                        if (filter_var($record->email, FILTER_VALIDATE_EMAIL)) {
                            try {
                                Mail::to($record->email)->send(new MabaAccNotification($record));
                            } catch (\Exception $e) {
                                // Biarkan tetap sukses walau email offline/gagal
                            }
                        }

                        Notification::make()
                            ->title('Maba Berhasil di-ACC & Email Terkirim')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('acc_massal')
                        ->label('ACC Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn() => auth()->user()?->isAdmin())
                        ->action(fn(Collection $records) => $records->each->update(['status' => 1])),
                    Tables\Actions\DeleteBulkAction::make()->visible(fn() => auth()->user()?->isAdmin()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMahasiswaBarus::route('/'),
            'create' => Pages\CreateMahasiswaBaru::route('/create'),
            'edit' => Pages\EditMahasiswaBaru::route('/{record}/edit'),
        ];
    }
}