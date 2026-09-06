@extends('layouts.peserta')

@section('title', 'Masuk - Portal Peserta GAMATIF 2026')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-8">
    <div class="w-full max-w-xs sm:max-w-sm">

        <!-- header -->
        <div class="text-center mb-6">
            <p class="section-label mb-2">Portal Peserta</p>
            <h1 class="font-cinzel text-xl font-bold text-white tracking-wide">Masuk</h1>
            <p class="text-xs text-zinc-500 mt-1.5">Gunakan NIM dan password yang terdaftar</p>
        </div>

        <div class="card-glass mobile-card rounded-lg p-5 sm:p-6">

            @if($errors->any())
                <div class="mb-5 px-4 py-3 rounded-sm bg-rose-950/60 border border-rose-700/60 text-rose-300 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('peserta.login.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="section-label block mb-1.5">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim') }}" required
                           placeholder="Masukkan NIM Anda"
                           class="input-glass rounded-sm">
                </div>

                <div>
                    <label class="section-label block mb-1.5">Password</label>
                    <input type="password" name="password" required
                           placeholder="••••••••"
                           class="input-glass rounded-sm">
                </div>

                <div class="pt-1">
                    <button type="submit" class="btn-glass w-full py-2.5 rounded-sm">
                        Masuk ke Portal
                    </button>
                </div>
            </form>

            <div class="divider-gold my-4"></div>

            <p class="text-center text-xs text-zinc-500">
                Belum mendaftar?
                <a href="{{ route('peserta.register') }}"
                   class="text-gold-400 hover:text-gold-300 transition font-semibold">
                    Registrasi Akun Baru
                </a>
            </p>

        </div>

        <p class="text-center mt-6">
            <a href="{{ route('landing') }}"
               class="section-label text-zinc-300 hover:text-gold-400 transition">
                ← Kembali ke Beranda
            </a>
        </p>

    </div>
</div>
@endsection
