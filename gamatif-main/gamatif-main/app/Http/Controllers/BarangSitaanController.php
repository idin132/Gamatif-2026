<?php

namespace App\Http\Controllers;
use App\Models\BarangSitaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BarangSitaanController extends Controller
{
 public function download($id): StreamedResponse
{
    $record = BarangSitaan::with('dataMahasiswa')->findOrFail($id);

    // Ambil path file di storage
    $filePath = $record->foto; // pastikan ini menyimpan path relatif
    $disk = Storage::disk('public');

    if (! $disk->exists($filePath)) {
        abort(404, 'File tidak ditemukan.');
    }

    // Nama file baru sesuai kelompok
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    $namaKelompok = $record->dataMahasiswa->kelompok ?? 'Unknown';
    $downloadName = 'Kelompok_' . $namaKelompok . '.' . $extension;

    return $disk->download($filePath, $downloadName);
}
}
