@extends('layouts.peserta')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Kolom Kiri: Profil & Edit Profil & Media Sosial -->
        <div class="space-y-6">

            <!-- Status & Buku Panduan -->
            <div class="bg-sandcard border border-zinc-700 p-6 rounded-2xl shadow-xl">
                <h2 class="text-xs font-semibold tracking-wider text-spice-400 uppercase mb-4">Status Peserta</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-zinc-400">NIM</p>
                        <p class="font-mono text-spice-300 text-lg font-bold">{{ $peserta->nim }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-400">Status Verifikasi</p>
                        @if($peserta->status)
                            <span
                                class="inline-block mt-1 px-2.5 py-1 text-xs font-semibold rounded bg-emerald-900/60 border border-emerald-500 text-emerald-300">Terverifikasi
                                (ACC)</span>
                        @else
                            <span
                                class="inline-block mt-1 px-2.5 py-1 text-xs font-semibold rounded bg-amber-900/60 border border-amber-500 text-amber-300">Menunggu
                                ACC Admin</span>
                        @endif
                    </div>
                </div>

                @if($pengaturan?->buku_saku)
                    <div class="mt-6 pt-6 border-t border-zinc-700">
                        <a href="{{ asset('storage/' . $pengaturan->buku_saku) }}" target="_blank"
                            class="w-full flex items-center justify-center gap-2 bg-spice-500 hover:bg-spice-600 text-black font-semibold py-2.5 rounded-xl transition shadow-lg shadow-amber-500/20 text-sm">
                            Unduh Buku Panduan (PDF)
                        </a>
                    </div>
                @endif
            </div>

            <!-- Form Edit Profil -->
            <div class="bg-sandcard border border-zinc-700 p-6 rounded-2xl shadow-xl">
                <h2 class="text-xs font-semibold tracking-wider text-spice-400 uppercase mb-4">Edit Profil</h2>
                <form action="{{ route('peserta.update_profil') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $peserta->nama_lengkap) }}"
                            required
                            class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100 focus:outline-none focus:border-spice-500">
                    </div>
                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">No. WhatsApp</label>
                        <input type="text" name="nomor_whatsapp"
                            value="{{ old('nomor_whatsapp', $peserta->nomor_whatsapp) }}" required
                            class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100 focus:outline-none focus:border-spice-500">
                    </div>
                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Alamat</label>
                        <textarea name="alamat" rows="2" required
                            class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100 focus:outline-none focus:border-spice-500">{{ old('alamat', $peserta->alamat) }}</textarea>
                    </div>
                    <div class="pt-2 border-t border-zinc-800">
                        <label class="block text-xs text-zinc-400 mb-1">Ganti Password (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diganti"
                            class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100 focus:outline-none focus:border-spice-500">
                    </div>
                    <div>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru"
                            class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-100 focus:outline-none focus:border-spice-500">
                    </div>
                    <button type="submit"
                        class="w-full bg-zinc-800 hover:bg-zinc-700 border border-zinc-600 text-spice-400 font-semibold py-2 rounded-lg transition text-xs">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Link Sosial Media -->
            <div class="bg-sandcard border border-zinc-700 p-6 rounded-2xl">
                <h3 class="text-xs font-semibold tracking-wider text-spice-400 uppercase mb-4">Official Channels</h3>
                <div class="space-y-2">
                    @foreach($sosmed as $sm)
                        <a href="{{ $sm->url }}" target="_blank"
                            class="flex items-center justify-between p-2.5 rounded-lg bg-zinc-800/60 hover:bg-zinc-800 border border-zinc-700/50 text-sm text-zinc-300 transition">
                            <span>{{ $sm->nama }}</span>
                            <span class="text-spice-400">↗</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Kolom Tengah & Kanan: House, Pengumuman, Absensi Anggota, dan Jadwal -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Pilihan House & Link Direct WhatsApp -->
            <div class="bg-sandcard border border-zinc-700 p-6 rounded-2xl shadow-xl">
                <h2 class="text-xs font-semibold tracking-wider text-spice-400 uppercase mb-2">House Assignment</h2>

                <div id="house-result-container" class="{{ $peserta->kelompok ? '' : 'hidden' }}">
                    <div
                        class="p-5 bg-amber-950/20 border border-amber-500/40 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-xs text-amber-400 uppercase font-semibold">House Anda</p>
                            <h3 id="house-name" class="text-2xl font-black tracking-wide text-zinc-100">
                                {{ $peserta->kelompok?->nama_kelompok }}</h3>
                        </div>
                        <a id="house-wa-link" href="{{ $peserta->kelompok?->url_grub }}" target="_blank"
                            class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition {{ $peserta->kelompok?->url_grub ? '' : 'hidden' }}">
                            Direct ke WhatsApp Group House
                        </a>
                    </div>
                </div>

                @if(!$peserta->kelompok)
                    <div id="gacha-action-container">
                        <p class="text-xs text-zinc-400 mb-6">Penentuan House dilakukan secara acak oleh Sorting Protocol
                            Gamatif. Tekan tombol untuk mengundi House Anda.</p>

                        <!-- Display Animasi Gacha -->
                        <div
                            class="flex flex-col items-center justify-center py-8 px-4 bg-zinc-900/60 border border-zinc-800 rounded-2xl mb-6 text-center">
                            <div id="gacha-spinner"
                                class="text-3xl sm:text-4xl font-black tracking-widest text-zinc-600 uppercase transition-all duration-75">
                                ???
                            </div>
                            <p id="gacha-subtext" class="text-xs text-zinc-500 mt-2 font-mono">Siap melakukan inisialisasi
                                takdir</p>
                        </div>

                        <button id="btn-gacha" onclick="startGacha()"
                            class="w-full bg-spice-500 hover:bg-spice-600 text-black font-extrabold py-3.5 rounded-xl transition text-sm shadow-xl shadow-amber-500/20 uppercase tracking-wider">
                            Ambil Kelompok (Gacha)
                        </button>
                    </div>
                @endif
            </div>

            <!-- Rekap Absensi Anggota / Peserta -->
            <div class="bg-sandcard border border-zinc-700 p-6 rounded-2xl">
                <h2 class="text-xs font-semibold tracking-wider text-spice-400 uppercase mb-4">Rekap Absensi Saya</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-300">
                        <thead class="text-xs text-zinc-400 uppercase bg-zinc-800/60 border-b border-zinc-700">
                            <tr>
                                <th class="px-4 py-3">Kegiatan</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800">
                            @forelse($riwayatAbsensi as $abs)
                                <tr>
                                    <td class="px-4 py-3 font-medium">{{ $abs->jadwalKegiatan->nama }}</td>
                                    <td class="px-4 py-3 text-xs text-zinc-400">
                                        {{ $abs->jadwalKegiatan->tanggal->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2.5 py-1 text-xs rounded uppercase font-semibold
                                                        {{ $abs->status == 'hadir' ? 'bg-emerald-950 text-emerald-400 border border-emerald-700' : '' }}
                                                        {{ $abs->status == 'telat' ? 'bg-amber-950 text-amber-400 border border-amber-700' : '' }}
                                                        {{ in_array($abs->status, ['izin', 'sakit']) ? 'bg-blue-950 text-blue-400 border border-blue-700' : '' }}
                                                        {{ $abs->status == 'alpa' ? 'bg-rose-950 text-rose-400 border border-rose-700' : '' }}">
                                            {{ $abs->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-xs text-zinc-500">Belum ada catatan
                                        absensi yang diinput panitia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Jadwal Kegiatan -->
            <div class="bg-sandcard border border-zinc-700 p-6 rounded-2xl">
                <h2 class="text-xs font-semibold tracking-wider text-spice-400 uppercase mb-4">Jadwal Agenda Kegiatan</h2>
                <div class="space-y-3">
                    @forelse($jadwals as $jadwal)
                        <div class="flex items-center justify-between p-4 bg-zinc-800/40 border border-zinc-700/60 rounded-xl">
                            <div>
                                <h4 class="font-bold text-zinc-100">{{ $jadwal->nama }}</h4>
                                <p class="text-xs text-zinc-400">
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                            <span
                                class="text-xs font-mono bg-zinc-900 px-3 py-1.5 rounded-md border border-zinc-700 text-spice-300">
                                {{ substr($jadwal->waktu_mulai, 0, 5) }} - {{ substr($jadwal->waktu_selesai, 0, 5) }} WIB
                            </span>
                        </div>
                    @empty
                        <p class="text-zinc-500 text-sm">Belum ada agenda kegiatan.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
@endsection