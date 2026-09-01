@extends('layouts.peserta')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- Kolom Kiri: Profil & Status Verifikasi -->
    <div class="space-y-6">
        <div class="bg-sandcard border border-zinc-700 p-6 rounded-2xl shadow-xl">
            <h2 class="text-xs font-semibold tracking-wider text-spice-400 uppercase mb-4">Profil Mahasiswa</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-zinc-400">Nama Lengkap</p>
                    <p class="font-medium text-lg">{{ $peserta->nama_lengkap }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-400">NIM</p>
                    <p class="font-mono text-spice-300">{{ $peserta->nim }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-400">Status Pendaftaran</p>
                    @if($peserta->status)
                        <span class="inline-block mt-1 px-2.5 py-1 text-xs rounded bg-emerald-900/60 border border-emerald-500 text-emerald-300">Terverifikasi (ACC)</span>
                    @else
                        <span class="inline-block mt-1 px-2.5 py-1 text-xs rounded bg-amber-900/60 border border-amber-500 text-amber-300">Menunggu ACC Admin</span>
                    @endif
                </div>
            </div>

            @if($pengaturan?->buku_saku)
            <div class="mt-6 pt-6 border-t border-zinc-700">
                <a href="{{ asset('storage/' . $pengaturan->buku_saku) }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-spice-500 hover:bg-spice-600 text-black font-semibold py-2.5 rounded-xl transition shadow-lg shadow-amber-500/20 text-sm">
                    Unduh Buku Panduan
                </a>
            </div>
            @endif
        </div>

        <!-- Media Sosial & Kontak -->
        <div class="bg-sandcard border border-zinc-700 p-6 rounded-2xl">
            <h3 class="text-xs font-semibold tracking-wider text-spice-400 uppercase mb-4">Official Channels</h3>
            <div class="space-y-2">
                @foreach($sosmed as $sm)
                    <a href="{{ $sm->url }}" target="_blank" class="flex items-center justify-between p-2.5 rounded-lg bg-zinc-800/60 hover:bg-zinc-800 border border-zinc-700/50 text-sm text-zinc-300 transition">
                        <span>{{ $sm->nama }}</span>
                        <span class="text-spice-400">↗</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Kolom Tengah & Kanan: House (Kelompok) & Jadwal -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Pilihan House / Kelompok -->
        <div class="bg-sandcard border border-zinc-700 p-6 rounded-2xl">
            <h2 class="text-xs font-semibold tracking-wider text-spice-400 uppercase mb-4">House Assignment</h2>
            
            @if($peserta->kelompok)
                <div class="p-5 bg-amber-950/20 border border-amber-500/40 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <p class="text-xs text-amber-400 uppercase font-semibold">House Anda</p>
                        <h3 class="text-2xl font-black tracking-wide text-zinc-100">{{ $peserta->kelompok->nama_kelompok }}</h3>
                    </div>
                    @if($peserta->kelompok->url_grub)
                        <a href="{{ $peserta->kelompok->url_grub }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                            Masuk WhatsApp Group House
                        </a>
                    @endif
                </div>
            @else
                <p class="text-sm text-zinc-400 mb-4">Silakan pilih House / Kelompok yang tersedia:</p>
                <form action="{{ route('peserta.pilih_kelompok') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                        @foreach($kelompoks as $kelompok)
                            <label class="relative flex flex-col p-4 border border-zinc-700 rounded-xl bg-zinc-800/40 hover:border-spice-500 cursor-pointer">
                                <input type="radio" name="kelompok_id" value="{{ $kelompok->id }}" class="absolute top-4 right-4 text-spice-500 focus:ring-spice-400" required>
                                <span class="font-bold text-lg text-zinc-200">{{ $kelompok->nama_kelompok }}</span>
                                <span class="text-xs text-zinc-400 mt-1">Total: {{ $kelompok->mahasiswa_barus_count }} Pasukan</span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="bg-spice-500 hover:bg-spice-600 text-black font-bold px-6 py-2.5 rounded-xl transition text-sm">
                        Konfirmasi Pilihan House
                    </button>
                </form>
            @endif
        </div>

        <!-- Jadwal Kegiatan -->
        <div class="bg-sandcard border border-zinc-700 p-6 rounded-2xl">
            <h2 class="text-xs font-semibold tracking-wider text-spice-400 uppercase mb-4">Jadwal Agenda</h2>
            <div class="space-y-3">
                @forelse($jadwals as $jadwal)
                    <div class="flex items-center justify-between p-4 bg-zinc-800/40 border border-zinc-700/60 rounded-xl">
                        <div>
                            <h4 class="font-bold text-zinc-100">{{ $jadwal->nama }}</h4>
                            <p class="text-xs text-zinc-400">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <span class="text-xs font-mono bg-zinc-900 px-3 py-1.5 rounded-md border border-zinc-700 text-spice-300">
                            {{ substr($jadwal->waktu_mulai, 0, 5) }} - {{ substr($jadwal->waktu_selesai, 0, 5) }} WIB
                        </span>
                    </div>
                @empty
                    <p class="text-zinc-500 text-sm">Belum ada agenda yang dijadwalkan.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection