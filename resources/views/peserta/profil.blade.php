@extends('layouts.peserta')

@section('title', 'Profil Saya - Portal Peserta GAMATIF 2026')

@section('content')

{{-- ── Page heading ── --}}
<div class="mb-6 reveal">
    <h2 class="text-xl sm:text-2xl font-semibold text-white flex items-center gap-2">
        🧑 Profil Saya
    </h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    {{-- ═══ Data Diri ═══ --}}
    <div class="card-glass mobile-card rounded-lg p-6 reveal">
        <p class="section-label mb-1">📋 Data Diri</p>
        <div class="divider-gold my-4"></div>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-sm bg-emerald-950/60 border border-emerald-700/50 text-emerald-300 text-xs">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 px-4 py-3 rounded-sm bg-rose-950/60 border border-rose-700/50 text-rose-300 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('peserta.update_profil') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs text-zinc-400 mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama_lengkap"
                       value="{{ old('nama_lengkap', $peserta->nama_lengkap) }}" required
                       class="input-glass rounded-sm">
            </div>

            <div>
                <label class="block text-xs text-zinc-400 mb-1.5">NIM</label>
                <input type="text" value="{{ $peserta->nim }}" disabled
                       class="w-full rounded-sm px-4 py-3 text-sm text-zinc-500 cursor-not-allowed"
                       style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
            </div>

            <div>
                <label class="block text-xs text-zinc-400 mb-1.5">Jenis Kelamin</label>
                <input type="text" value="{{ $peserta->jenis_kelamin ?? '-' }}" disabled
                       class="w-full rounded-sm px-4 py-3 text-sm text-zinc-500 cursor-not-allowed"
                       style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
            </div>

            <div>
                <label class="block text-xs text-zinc-400 mb-1.5">Alamat</label>
                <textarea name="alamat" rows="3" required
                          class="input-glass rounded-sm resize-none">{{ old('alamat', $peserta->alamat) }}</textarea>
            </div>

            <div>
                <label class="block text-xs text-zinc-400 mb-1.5">No. WhatsApp</label>
                <input type="text" name="nomor_whatsapp"
                       value="{{ old('nomor_whatsapp', $peserta->nomor_whatsapp) }}" required
                       class="input-glass rounded-sm">
            </div>

            <div>
                <label class="block text-xs text-zinc-400 mb-1.5">Email</label>
                <input type="text" value="{{ $peserta->email ?? '-' }}" disabled
                       class="w-full rounded-sm px-4 py-3 text-sm text-zinc-500 cursor-not-allowed"
                       style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
            </div>

            {{-- Status --}}
            <div class="flex items-center gap-2 pt-1">
                @if($peserta->status)
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 inline-block"></span>
                    <span class="text-xs text-emerald-300">Aktif</span>
                @else
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block animate-pulse"></span>
                    <span class="text-xs text-amber-300">Menunggu Aktivasi</span>
                @endif
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-glass px-6 py-2.5 rounded-sm text-xs">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    {{-- ═══ Ganti Password ═══ --}}
    <div class="card-glass mobile-card rounded-lg p-6 reveal">
        <p class="section-label mb-1">🔒 Ganti Password</p>
        <div class="divider-gold my-4"></div>

        <form action="{{ route('peserta.update_profil') }}" method="POST" class="space-y-4">
            @csrf
            {{-- Kirim ulang data profil yang diperlukan agar validasi tidak gagal --}}
            <input type="hidden" name="nama_lengkap" value="{{ $peserta->nama_lengkap }}">
            <input type="hidden" name="nomor_whatsapp" value="{{ $peserta->nomor_whatsapp }}">
            <input type="hidden" name="alamat" value="{{ $peserta->alamat }}">

            <div>
                <label class="block text-xs text-zinc-400 mb-1.5">Password Lama</label>
                <input type="password" name="password_lama" placeholder="Masukkan password lama"
                       class="input-glass rounded-sm">
            </div>

            <div>
                <label class="block text-xs text-zinc-400 mb-1.5">Password Baru</label>
                <p class="text-[10px] text-zinc-600 mb-1.5">Harus kombinasi huruf dan angka. Contoh: gamatif2025</p>
                <input type="password" name="password" placeholder="Password baru"
                       class="input-glass rounded-sm">
            </div>

            <div>
                <label class="block text-xs text-zinc-400 mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                       class="input-glass rounded-sm">
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-glass px-6 py-2.5 rounded-sm text-xs"
                        style="background: linear-gradient(135deg, rgba(201,168,76,0.25), rgba(201,168,76,0.1));">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
