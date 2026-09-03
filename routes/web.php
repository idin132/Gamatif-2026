<?php

use App\Http\Controllers\Auth\PesertaAuthController;
use App\Http\Controllers\Peserta\DashboardController;
use App\Http\Controllers\Pk\PkPortalController;
use App\Http\Controllers\Admin\ScanPresensiController;
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
    Route::post('/gacha-kelompok', [DashboardController::class, 'gachaKelompok'])->name('gacha_kelompok');
});

// Rute Mobile Portal PK
Route::middleware(['auth'])->prefix('pk')->name('pk.')->group(function () {
    Route::get('/dashboard', [PkPortalController::class, 'index'])->name('dashboard');
    Route::post('/toggle-barang', [PkPortalController::class, 'toggleBarang'])->name('toggle_barang');
    Route::post('/update-kehadiran', [PkPortalController::class, 'updateKehadiran'])->name('update_kehadiran');
    Route::post('/store-izin', [PkPortalController::class, 'storeIzin'])->name('store_izin');
    Route::post('/check-all-barang', [PkPortalController::class, 'checkAllBarang'])->name('check_all_barang');
});

// 1. Guest PK (Halaman & Proses Login)
Route::middleware('guest')->prefix('pk')->name('pk.')->group(function () {
    Route::get('/login', [PkPortalController::class, 'showLogin'])->name('login');
    Route::post('/login', [PkPortalController::class, 'login'])->name('login.post');
});

// 2. Auth PK (Portal Mobile Lapangan)
Route::middleware(['auth'])->prefix('pk')->name('pk.')->group(function () {
    Route::get('/dashboard', [PkPortalController::class, 'index'])->name('dashboard');
    Route::post('/toggle-barang', [PkPortalController::class, 'toggleBarang'])->name('toggle_barang');
    Route::post('/check-all-barang', [PkPortalController::class, 'checkAllBarang'])->name('check_all_barang');
    Route::post('/update-kehadiran', [PkPortalController::class, 'updateKehadiran'])->name('update_kehadiran');
    Route::post('/store-izin', [PkPortalController::class, 'storeIzin'])->name('store_izin');
    Route::post('/logout', [PkPortalController::class, 'logout'])->name('logout');
});

Route::middleware(['auth'])->prefix('admin-scan')->group(function () {
    Route::get('/', [ScanPresensiController::class, 'index'])->name('admin.scan');
    Route::post('/proses', [ScanPresensiController::class, 'prosesScan'])->name('admin.scan.proses');
});

Route::redirect('/login-admin', '/admin/login')->name('login');