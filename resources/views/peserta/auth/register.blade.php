@extends('layouts.peserta')

@section('title', 'Registrasi - GAMATIF 2026')

@section('content')
<div class="py-8">
    <div class="max-w-xs sm:max-w-sm mx-auto">

        <!-- header -->
        <div class="text-center mb-6">
            <p class="section-label mb-2">Pendaftaran Peserta</p>
            <h1 class="font-cinzel text-xl font-bold text-white tracking-wide">Registrasi</h1>
            <p class="text-xs text-zinc-500 mt-1.5">Lengkapi data pribadi dan berkas registrasi Anda</p>
        </div>

        <div class="card-glass mobile-card rounded-lg p-5 sm:p-6">

            @if($errors->any())
                <div class="mb-4 px-4 py-3 rounded-sm bg-rose-950/60 border border-rose-700/60 text-rose-300 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('peserta.register.post') }}"
                  enctype="multipart/form-data" class="space-y-3">
                @csrf

                <div>
                    <label class="section-label block mb-1.5">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim') }}" required
                           placeholder="Nomor Induk Mahasiswa"
                           class="input-glass rounded-sm">
                </div>
                <div>
                    <label class="section-label block mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                           placeholder="Nama sesuai KTP"
                           class="input-glass rounded-sm">
                </div>
                <div>
                    <label class="section-label block mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="email@example.com"
                           class="input-glass rounded-sm">
                </div>
                <div>
                    <label class="section-label block mb-1.5">No. WhatsApp</label>
                    <input type="text" name="nomor_whatsapp" value="{{ old('nomor_whatsapp') }}" required
                           placeholder="08xxxxxxxxxx"
                           class="input-glass rounded-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="section-label block mb-1.5">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required class="input-glass rounded-sm">
                            <option value="L" class="bg-zinc-900">Laki-laki</option>
                            <option value="P" class="bg-zinc-900">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="section-label block mb-1.5">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" required
                               class="input-glass rounded-sm">
                    </div>
                </div>
                <div>
                    <label class="section-label block mb-1.5">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" required
                              placeholder="Jalan, RT/RW, Kelurahan, Kota..."
                              class="input-glass rounded-sm resize-none">{{ old('alamat') }}</textarea>
                </div>
                <div>
                    <label class="section-label block mb-1.5">Password</label>
                    <input type="password" name="password" required
                           placeholder="••••••••"
                           class="input-glass rounded-sm">
                </div>
                <div>
                    <label class="section-label block mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           placeholder="••••••••"
                           class="input-glass rounded-sm">
                </div>

                <div class="pt-2 border-t border-gold-500/10 space-y-3">
                    <div>
                        <label class="section-label block mb-1.5">Bukti Registrasi <span class="text-zinc-600 normal-case">(PDF/JPG)</span></label>
                        <input type="file" name="bukti_registrasi" required
                               class="w-full text-xs text-zinc-400
                                      file:mr-3 file:py-1.5 file:px-3 file:rounded-sm file:border-0
                                      file:text-xs file:font-semibold file:tracking-widest file:uppercase
                                      file:bg-gold-500/15 file:text-gold-400
                                      hover:file:bg-gold-500/25 transition">
                    </div>
                    <div>
                        <label class="section-label block mb-1.5">Bukti Sosmed <span class="text-zinc-600 normal-case">(Bisa Multiple)</span></label>
                        <input type="file" name="bukti_sosmed[]" multiple required
                               class="w-full text-xs text-zinc-400
                                      file:mr-3 file:py-1.5 file:px-3 file:rounded-sm file:border-0
                                      file:text-xs file:font-semibold file:tracking-widest file:uppercase
                                      file:bg-gold-500/15 file:text-gold-400
                                      hover:file:bg-gold-500/25 transition">
                    </div>
                </div>

                <div class="pt-1">
                    <button type="submit" class="btn-glass w-full py-2.5 rounded-sm">
                        Daftar Sekarang
                    </button>
                </div>

            </form>

            <div class="divider-gold my-4"></div>

            <p class="text-center text-xs text-zinc-500">
                Sudah punya akun?
                <a href="{{ route('peserta.login') }}"
                   class="text-gold-400 hover:text-gold-300 transition font-semibold">
                    Masuk ke Portal
                </a>
            </p>

        </div>

    </div>
</div>
@endsection
