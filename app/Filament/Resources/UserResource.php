<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'kelola-akun-pk';

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Akun PK / House Leader';

    protected static ?int $navigationSort = 5;

    // Hanya admin yang bisa melihat menu ini
    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    // Filter agar tabel hanya menampilkan user dengan role 'pk'
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'pk');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun PK')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap PK')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email Login')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('kelompok_id')
                            ->label('House / Kelompok yang Dipimpin')
                            ->relationship('kelompok', 'nama_kelompok')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Pilih kelompok yang menjadi tanggung jawab PK ini.'),

                        Forms\Components\Hidden::make('role')
                            ->default('pk'),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->helperText(fn (string $context) => $context === 'edit' ? 'Kosongkan jika tidak ingin mengganti password.' : null),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama PK')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')
                    ->label('House / Kelompok')
                    ->badge()
                    ->color('warning')
                    ->sortable()
                    ->placeholder('Belum Ditugaskan'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelompok_id')
                    ->label('Filter Berdasarkan House')
                    ->relationship('kelompok', 'nama_kelompok'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}