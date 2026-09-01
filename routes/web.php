<?php

use App\Http\Controllers\Auth\PesertaAuthController;
use App\Http\Controllers\Peserta\DashboardController;
use Illuminate\Support\Facades\Route;

// 1. Landing Page Utama
Route::get('/', [DashboardController::class, 'landingPage'])->name('landing');
Route::post('/kirim-kritik-saran', [DashboardController::class, 'kirimKritikSaran'])->name('kirim_kritik_saran');

// 2. Auth Peserta (Guest)
Route::middleware('guest:peserta')->prefix('portal')->name('peserta.')->group(function () {
    Route::get('/login', [PesertaAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [PesertaAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [PesertaAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [PesertaAuthController::class, 'register'])->name('register.post');
});

// 3. Portal Dashboard Peserta (Auth)
Route::middleware('auth:peserta')->prefix('portal')->name('peserta.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/update-profil', [DashboardController::class, 'updateProfil'])->name('update_profil'); // <-- Baru
    Route::post('/pilih-kelompok', [DashboardController::class, 'pilihKelompok'])->name('pilih_kelompok');
    Route::post('/ajukan-izin', [DashboardController::class, 'ajukanIzin'])->name('ajukan_izin');
    Route::post('/kirim-menfess', [DashboardController::class, 'kirimMenfess'])->name('kirim_menfess');
    Route::post('/logout', [PesertaAuthController::class, 'logout'])->name('logout');
});

Route::redirect('/login-admin', '/admin/login')->name('login');