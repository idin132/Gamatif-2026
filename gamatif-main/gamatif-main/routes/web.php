<?php

use App\Models\BarangSitaan;
use App\Models\IzinKehadiran;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\BarangSitaanController;
use App\Http\Controllers\IzinKehadiranController;
use App\Exports\DataMahasiswaExport;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    // $web_setting = app(SettingController::class)->title();
    return view('welcome');
});
// Fallback route untuk SPA - menangani semua route Vue Router
Route::fallback(function () {
    return view('welcome');
});


Route::get('/izin/{id}/download', [IzinKehadiranController::class, 'download'])
    ->name('izin.download');


Route::get('/izin/{record}/view', function (IzinKehadiran $record) {
    return Storage::disk('public')->response($record->foto); // tampil di tab baru
})->name('izin.view');

Route::get('/BarangSitaan/{id}/download', [BarangSitaanController::class, 'download'])
    ->name('BarangSitaan.download');

// Route::get('/BarangSitaan/{record}/download', function (BarangSitaan $record) {
//     abort_unless($record->foto, 404);
//     return Storage::disk('public')->download($record->foto, basename($record->foto));
// })->name('BarangSitaan.download');

Route::get('/BarangSitaan/{record}/view', function (BarangSitaan $record) {
    return Storage::disk('public')->response($record->foto); // tampil di tab baru
})->name('BarangSitaan.view');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/import', [ImportController::class, 'showForm'])->name('import.form');
    Route::post('/import', [ImportController::class, 'import'])->name('import.data');
});


Route::get('/export-mahasiswa', function () {
    return Excel::download(new DataMahasiswaExport, 'data_mahasiswa.xlsx');
});

Route::get('/belum-aktif', function () {
    return view('mahasiswa.belum-aktif');
})->name('akun.belum-aktif');
