<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pengaturan->nama_kegiatan ?? 'GAMATIF 2026' }} - Arrakis Expedition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        spice: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                        sand: '#121214',
                        sandcard: '#1c1c20',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-sand text-zinc-100 font-sans selection:bg-spice-500 selection:text-black">

    <!-- Top Navbar -->
    <header class="border-b border-zinc-800 bg-sand/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-spice-500 animate-pulse"></span>
                <span class="font-extrabold tracking-widest text-spice-400 text-xl">{{ $pengaturan->nama_kegiatan ?? 'GAMATIF' }}</span>
            </div>
            
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-zinc-400">
                <a href="#about" class="hover:text-spice-400 transition">Tentang</a>
                <a href="#agenda" class="hover:text-spice-400 transition">Jadwal</a>
                <a href="#calon" class="hover:text-spice-400 transition">Ketua Angkatan</a>
                <a href="#menfess" class="hover:text-spice-400 transition">Menfess</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth('peserta')
                    <a href="{{ route('peserta.dashboard') }}" class="bg-spice-500 hover:bg-spice-600 text-black text-xs font-bold px-4 py-2.5 rounded-lg transition">Portal Peserta</a>
                @else
                    <a href="{{ route('peserta.login') }}" class="text-xs font-semibold text-zinc-300 hover:text-white px-3 py-2">Masuk</a>
                    <a href="{{ route('peserta.register') }}" class="bg-spice-500 hover:bg-spice-600 text-black text-xs font-bold px-4 py-2.5 rounded-lg transition shadow-lg shadow-amber-500/20">Registrasi</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center border-b border-zinc-800/60">
        <span class="text-xs font-mono font-semibold tracking-widest text-spice-400 uppercase bg-spice-500/10 border border-spice-500/30 px-3.5 py-1.5 rounded-full">
            Informatics Expedition 2026
        </span>
        <h1 class="mt-6 text-4xl sm:text-6xl font-black tracking-tight text-zinc-100 max-w-4xl mx-auto uppercase">
            Selamat Datang di <span class="text-spice-400">GAMATIF 2026</span>
        </h1>
        <p class="mt-4 text-zinc-400 max-w-2xl mx-auto text-base sm:text-lg">
            Sambut perjalanan orientasi mahasiswa baru. Tentukan House Anda, pelajari buku panduan, dan pantau seluruh agenda kegiatan.
        </p>
        
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('peserta.register') }}" class="bg-spice-500 hover:bg-spice-600 text-black font-extrabold px-8 py-3.5 rounded-xl transition text-sm shadow-xl shadow-amber-500/20">
                Daftar Sebagai Mahasiswa Baru
            </a>
            @if($pengaturan?->buku_saku)
                <a href="{{ asset('storage/' . $pengaturan->buku_saku) }}" target="_blank" class="bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 text-zinc-200 font-semibold px-6 py-3.5 rounded-xl transition text-sm">
                    Unduh Buku Panduan (PDF)
                </a>
            @endif
        </div>
    </section>

    <!-- Agenda / Jadwal Section -->
    <section id="agenda" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-b border-zinc-800/60">
        <div class="text-center mb-12">
            <h2 class="text-xs font-mono font-bold tracking-widest text-spice-400 uppercase">Rundown Acara</h2>
            <h3 class="text-3xl font-extrabold text-zinc-100 mt-2">Jadwal Agenda Kegiatan</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($jadwals as $jadwal)
                <div class="bg-sandcard border border-zinc-800 p-6 rounded-2xl hover:border-spice-500/40 transition">
                    <span class="text-xs font-mono text-spice-400 bg-spice-500/10 px-2.5 py-1 rounded border border-spice-500/20">
                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}
                    </span>
                    <h4 class="text-xl font-bold text-zinc-100 mt-4">{{ $jadwal->nama }}</h4>
                    <p class="text-sm text-zinc-400 mt-2 font-mono">
                        {{ substr($jadwal->waktu_mulai, 0, 5) }} - {{ substr($jadwal->waktu_selesai, 0, 5) }} WIB
                    </p>
                </div>
            @empty
                <p class="text-center col-span-3 text-zinc-500 text-sm">Belum ada agenda yang dirilis.</p>
            @endforelse
        </div>
    </section>

    <!-- Calon Ketua Angkatan -->
    @if($calonKetua->count() > 0)
    <section id="calon" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-b border-zinc-800/60">
        <div class="text-center mb-12">
            <h2 class="text-xs font-mono font-bold tracking-widest text-spice-400 uppercase">Kandidat</h2>
            <h3 class="text-3xl font-extrabold text-zinc-100 mt-2">Calon Ketua Angkatan</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($calonKetua as $calon)
                <div class="bg-sandcard border border-zinc-800 p-6 rounded-2xl flex flex-col items-center text-center">
                    <img src="{{ asset('storage/' . $calon->foto) }}" alt="{{ $calon->nama }}" class="w-28 h-28 rounded-full object-cover border-2 border-spice-400 mb-4">
                    <h4 class="text-lg font-bold text-zinc-100">{{ $calon->nama }}</h4>
                    <p class="text-xs font-mono text-spice-400 mb-4">{{ $calon->nim }} • {{ $calon->kelas }}</p>
                    <div class="w-full text-left bg-zinc-900/60 p-4 rounded-xl border border-zinc-800 text-xs space-y-2">
                        <p><strong class="text-zinc-300">Visi:</strong> <span class="text-zinc-400">{{ $calon->visi }}</span></p>
                        <p><strong class="text-zinc-300">Misi:</strong> <span class="text-zinc-400">{{ $calon->misi }}</span></p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Menfess & Kritik Saran -->
    <section id="menfess" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Menfess Feed -->
        <div>
            <h3 class="text-2xl font-extrabold text-zinc-100 mb-6">Menfess Terkini</h3>
            <div class="space-y-4">
                @forelse($menfesses as $mf)
                    <div class="bg-sandcard border border-zinc-800 p-5 rounded-xl">
                        <div class="flex items-center justify-between text-xs text-spice-400 mb-2 font-mono">
                            <span>From: {{ $mf->from }}</span>
                            <span>To: {{ $mf->to }}</span>
                        </div>
                        <p class="text-sm text-zinc-300">{{ $mf->message }}</p>
                    </div>
                @empty
                    <p class="text-zinc-500 text-sm">Belum ada menfess.</p>
                @endforelse
            </div>
        </div>

        <!-- Form Kritik & Saran -->
        <div class="bg-sandcard border border-zinc-800 p-8 rounded-2xl">
            <h3 class="text-2xl font-extrabold text-zinc-100 mb-2">Kritik & Saran</h3>
            <p class="text-xs text-zinc-400 mb-6">Beri masukan Anda demi kelancaran kegiatan orientasi ini.</p>
            
            <form action="{{ route('kirim_kritik_saran') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-1">Nama (Opsional / Anonim)</label>
                    <input type="text" name="nama" class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2.5 text-sm text-zinc-100 focus:outline-none focus:border-spice-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-1">Pesan Masukan</label>
                    <textarea name="pesan" rows="4" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2.5 text-sm text-zinc-100 focus:outline-none focus:border-spice-500"></textarea>
                </div>
                <button type="submit" class="w-full bg-spice-500 hover:bg-spice-600 text-black font-bold py-2.5 rounded-lg transition text-sm">
                    Kirim Kritik & Saran
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-zinc-800 bg-zinc-950 py-12 px-4 text-center">
        <div class="max-w-7xl mx-auto space-y-4">
            <p class="text-sm font-semibold text-zinc-300">{{ $pengaturan->nama_kegiatan ?? 'GAMATIF 2026' }}</p>
            <div class="flex justify-center gap-6 text-xs text-zinc-400">
                @foreach($sosmed as $sm)
                    <a href="{{ $sm->url }}" target="_blank" class="hover:text-spice-400 transition">{{ $sm->nama }}</a>
                @endforeach
            </div>
            <p class="text-xs text-zinc-600">Arrakis Expedition &copy; 2026. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>