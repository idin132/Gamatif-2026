@extends('layouts.peserta')

@section('content')
<div class="max-w-2xl mx-auto bg-sandcard border border-zinc-700 p-8 rounded-2xl shadow-2xl mt-4">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-black tracking-wider text-spice-400">REGISTRASI PESERTA</h1>
        <p class="text-xs text-zinc-400 mt-1">Lengkapi data pribadi dan berkas registrasi Anda</p>
    </div>

    <form method="POST" action="{{ route('peserta.register.post') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1">NIM</label>
                <input type="text" name="nim" value="{{ old('nim') }}" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1">No. WhatsApp</label>
                <input type="text" name="nomor_whatsapp" value="{{ old('nomor_whatsapp') }}" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-zinc-300 mb-1">Alamat Lengkap</label>
            <textarea name="alamat" rows="2" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100">{{ old('alamat') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1">Password</label>
                <input type="password" name="password" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1">Bukti Registrasi (PDF/JPG)</label>
                <input type="file" name="bukti_registrasi" required class="w-full text-xs text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-zinc-800 file:text-spice-400">
            </div>
            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1">Bukti Sosmed (Bisa Multiple)</label>
                <input type="file" name="bukti_sosmed[]" multiple required class="w-full text-xs text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-zinc-800 file:text-spice-400">
            </div>
        </div>

        <button type="submit" class="w-full mt-4 bg-spice-500 hover:bg-spice-600 text-black font-bold py-2.5 rounded-lg transition text-sm">
            Daftar Sekarang
        </button>
    </form>
</div>
@endsection