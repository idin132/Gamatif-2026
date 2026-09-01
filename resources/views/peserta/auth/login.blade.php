@extends('layouts.peserta')

@section('content')
<div class="max-w-md mx-auto bg-sandcard border border-zinc-700 p-8 rounded-2xl shadow-2xl mt-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-black tracking-wider text-spice-400">PORTAL PESERTA</h1>
        <p class="text-xs text-zinc-400 mt-1">Masuk dengan NIM dan password yang terdaftar</p>
    </div>

    <form method="POST" action="{{ route('peserta.login.post') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-zinc-300 mb-1">NIM</label>
            <input type="text" name="nim" value="{{ old('nim') }}" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2.5 text-sm text-zinc-100 focus:outline-none focus:border-spice-500">
            @error('nim') <span class="text-xs text-rose-400 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-zinc-300 mb-1">Password</label>
            <input type="password" name="password" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2.5 text-sm text-zinc-100 focus:outline-none focus:border-spice-500">
        </div>

        <button type="submit" class="w-full bg-spice-500 hover:bg-spice-600 text-black font-bold py-2.5 rounded-lg transition text-sm shadow-lg shadow-amber-500/20">
            Masuk ke Portal
        </button>
    </form>

    <p class="text-center text-xs text-zinc-400 mt-6">
        Belum mendaftar? <a href="{{ route('peserta.register') }}" class="text-spice-400 hover:underline">Registrasi Akun Baru</a>
    </p>
</div>
@endsection