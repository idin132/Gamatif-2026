<?php

namespace App\Filament\Widgets;

use App\Models\MahasiswaBaru;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMahasiswaTable extends BaseWidget
{
    protected static ?string $heading = 'Pendaftar Terbaru & Menunggu Verifikasi';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $user = auth()->user();

        return $table
            ->query(
                MahasiswaBaru::query()
                    ->when($user && $user->isPk(), fn ($q) => $q->where('kelompok_id', $user->kelompok_id))
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nim')->label('NIM')->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')->label('Nama Lengkap'),
                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')
                    ->label('House')
                    ->badge()
                    ->color('warning')
                    ->placeholder('Belum Memilih'),
                Tables\Columns\IconColumn::make('status')
                    ->label('Status ACC')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Daftar')
                    ->since(),
            ])
            ->actions([
                Action::make('acc_quick')
                    ->label('ACC')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (MahasiswaBaru $record) => !$record->status && auth()->user()?->isAdmin())
                    ->action(fn (MahasiswaBaru $record) => $record->update(['status' => 1])),
            ]);
    }
}