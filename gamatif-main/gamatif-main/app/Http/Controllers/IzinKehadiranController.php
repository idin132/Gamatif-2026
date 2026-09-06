<?php

namespace App\Http\Controllers;

use App\Models\IzinKehadiran;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IzinKehadiranController extends Controller
{
    public function download($id): StreamedResponse
    {
        $record = IzinKehadiran::with('dataMahasiswa')->findOrFail($id);

        // Pastikan path file sesuai dengan kolom di database
        $filePath = $record->foto;
        $disk = Storage::disk('public');

        if (! $disk->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Buat nama file sesuai dengan data mahasiswa nama kelompok keterangaan
       $extension = pathinfo($filePath, PATHINFO_EXTENSION);

// Ambil data
$keterangan   = $record->keterangan ?? 'Unknown';
$kelompok     = $record->dataMahasiswa->kelompok ?? 'Unknown';
$namaMahasiswa = $record->dataMahasiswa->nama ?? 'Unknown';

// Rapikan format nama file
$downloadName = sprintf(
    '%s_%s_%s.%s',
    $keterangan,
    $kelompok,
    $namaMahasiswa,
    $extension
);


        return $disk->download($filePath, $downloadName);
    }
}
