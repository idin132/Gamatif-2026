<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SosialMediaController;
use App\Http\Controllers\Api\JadwalKegiatanController;
use App\Http\Controllers\Api\MahasiswaBaruAuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\KelompokGeneratorController;
use App\Http\Controllers\Api\PengaturanWebController;
use App\Http\Controllers\Api\KritikSaranController;
use App\Http\Controllers\Api\MenfessController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pengaturan-web', [PengaturanWebController::class, 'index']);
Route::get('/sosial-media', [SosialMediaController::class, 'index']);
Route::get('/jadwal-kegiatan', [JadwalKegiatanController::class, 'index']);
Route::post('/kritik-saran', [KritikSaranController::class, 'store']);


Route::post('/register', [MahasiswaBaruAuthController::class, 'register']);
Route::post('/login', [MahasiswaBaruAuthController::class, 'login']);

Route::get('/menfess', [MenfessController::class, 'index']);
Route::get('/menfess/{id}', [MenfessController::class, 'show']);
Route::post('/menfess', [MenfessController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [MahasiswaBaruAuthController::class, 'logout']);
    Route::get('/me', [MahasiswaBaruAuthController::class, 'me']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::get('/absensi', [ProfileController::class, 'getAbsensi']);

    Route::get('/kelompok/status', [KelompokGeneratorController::class, 'getStatus']);
    Route::post('/kelompok/generate', [KelompokGeneratorController::class, 'generate']);
});
