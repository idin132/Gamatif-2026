<?php

namespace App\Filament\Resources\MahasiswaBaruResource\Pages;

use App\Filament\Resources\MahasiswaBaruResource;
use App\Models\Kelompok;
use App\Models\MahasiswaBaru;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListMahasiswaBarus extends ListRecords
{
    protected static string $resource = MahasiswaBaruResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\Action::make('export_excel')
                ->label('Export Data Maba')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->modalHeading('Export Data Mahasiswa Baru')
                ->modalDescription('Pilih kelompok/house yang ingin diekspor atau pilih semua kelompok.')
                ->modalSubmitActionLabel('Unduh File')
                ->form([
                    Forms\Components\Select::make('kelompok_id')
                        ->label('Filter Kelompok / House')
                        ->placeholder('Semua Kelompok')
                        ->options(Kelompok::pluck('nama_kelompok', 'id'))
                        ->searchable(),
                ])
                ->action(function (array $data): StreamedResponse {
                    $selectedKelompokId = $data['kelompok_id'] ?? null;

                    // Nama file dinamis sesuai filter
                    $namaFile = 'Data-Maba-GAMATIF-Semua-Kelompok-' . date('Y-m-d') . '.csv';
                    if ($selectedKelompokId) {
                        $namaKelompok = Kelompok::find($selectedKelompokId)?->nama_kelompok ?? 'Kelompok';
                        $namaFile = 'Data-Maba-GAMATIF-' . str_replace(' ', '-', $namaKelompok) . '-' . date('Y-m-d') . '.csv';
                    }

                    return response()->streamDownload(function () use ($selectedKelompokId) {
                        $handle = fopen('php://output', 'w');

                        // Tambahkan BOM agar UTF-8 terbaca rapi di Microsoft Excel
                        fputs($handle, "\xEF\xBB\xBF");

                        // Header kolom
                        fputcsv($handle, [
                            'NIM',
                            'Nama Lengkap',
                            'Jenis Kelamin',
                            'Tanggal Lahir',
                            'Email',
                            'Nomor WhatsApp',
                            'Alamat Lengkap',
                            'House / Kelompok',
                            'Status Verifikasi (ACC)',
                            'Waktu Mendaftar',
                        ]);

                        // Query dengan filter kelompok jika dipilih
                        $query = MahasiswaBaru::with('kelompok');
                        if ($selectedKelompokId) {
                            $query->where('kelompok_id', $selectedKelompokId);
                        }

                        $query->chunk(200, function ($mabas) use ($handle) {
                            foreach ($mabas as $maba) {
                                $rawAlamat = $maba->alamat_lengkap ?? $maba->alamat ?? '-';
                                $alamatClean = preg_replace('/\s+/', ' ', trim($rawAlamat));

                                fputcsv($handle, [
                                    "'" . $maba->nim,
                                    $maba->nama_lengkap,
                                    $maba->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                                    $maba->tanggal_lahir ? date('d-m-Y', strtotime($maba->tanggal_lahir)) : '-',
                                    $maba->email,
                                    "'" . $maba->nomor_whatsapp,
                                    $alamatClean,
                                    $maba->kelompok?->nama_kelompok ?? 'Belum ada',
                                    $maba->status == 1 ? 'Sudah di-ACC' : 'Menunggu ACC',
                                    $maba->created_at ? $maba->created_at->format('d-m-Y H:i') : '-',
                                ]);
                            }
                        });

                        fclose($handle);
                    }, $namaFile, [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                    ]);
                }),

            Actions\CreateAction::make()
                ->label('New mahasiswa baru'),
        ];
    }
}