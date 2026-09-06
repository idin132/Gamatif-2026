@extends('layouts.peserta')

@section('title', 'Dashboard - Portal Peserta GAMATIF 2026')

@section('content')

{{-- ── Greeting ── --}}
<div class="mb-6 reveal">
    <h2 class="text-2xl sm:text-3xl font-bold text-white">
        Selamat Datang, <span class="text-gold-400">{{ $peserta->nama_lengkap }}</span> 🎉
    </h2>
</div>

{{-- ═══════════════════════════════════════════
     ROW 1: Profil | Aksi/House | Jadwal
     (tampil di semua kondisi)
═══════════════════════════════════════════ --}}
<div class="grid grid-cols-1 md:grid-cols-[1fr_auto_1.6fr] gap-4 mb-4 items-stretch">

    {{-- Card Profil --}}
    <div class="card-glass mobile-card rounded-lg p-6 text-center reveal flex flex-col justify-between">
        <div>
            <div class="w-16 h-16 rounded-full mx-auto mb-3 flex items-center justify-center text-xl font-bold text-black"
                 style="background: #C9A84C; box-shadow: 0 0 20px rgba(201,168,76,0.4);">
                {{ strtoupper(substr($peserta->nama_lengkap, 0, 2)) }}
            </div>
            <h3 class="font-semibold text-white text-base">{{ $peserta->nama_lengkap }}</h3>
            <p class="text-xs text-zinc-500 mt-0.5">NIM: {{ $peserta->nim }}</p>
            @if($peserta->kelompok)
                <p class="text-xs text-zinc-400 mt-1">Kelompok: <span class="text-gold-400 font-semibold">{{ $peserta->kelompok->nama_kelompok }}</span></p>
            @else
                <div class="mt-2">
                    @if($peserta->status)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-cinzel tracking-widest uppercase rounded-full
                                     bg-emerald-900/50 border border-emerald-600/50 text-emerald-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-cinzel tracking-widest uppercase rounded-full
                                     bg-amber-900/50 border border-amber-600/50 text-amber-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 inline-block animate-pulse"></span>Menunggu ACC
                        </span>
                    @endif
                </div>
            @endif
        </div>
        <div class="mt-4">
            <a href="{{ route('peserta.profil') }}"
               class="inline-block px-5 py-2 rounded-sm text-xs font-cinzel tracking-widest uppercase transition"
               style="background: rgba(201,168,76,0.2); border: 1px solid rgba(201,168,76,0.5); color: #E8D49E;">
                Lihat Profil
            </a>
        </div>
    </div>

    {{-- Card Tengah: kondisi berbeda --}}
    <div class="card-glass mobile-card rounded-lg p-6 flex flex-col justify-center items-center gap-3 reveal">

        @if($peserta->kelompok)
            {{-- Sudah punya kelompok: tombol aksi lengkap --}}
            @if($peserta->kelompok->url_grub)
                <a href="{{ $peserta->kelompok->url_grub }}" target="_blank"
                   class="theme-action theme-action-dark">
                    Gabung Grup
                </a>
            @endif
            <a href="{{ $pengaturan?->buku_saku ? asset('storage/' . $pengaturan->buku_saku) : '#' }}" target="_blank"
               class="theme-action theme-action-gold">
                Buku Panduan
            </a>
            <a href="{{ route('peserta.absensi') }}"
               class="theme-action theme-action-soft">
                Absen
            </a>

        @elseif($peserta->status)
            {{-- Sudah ACC tapi belum pilih house: tombol buka modal --}}
            <p class="font-cinzel text-[0.6rem] tracking-widest uppercase text-gold-500 mb-1">House Assignment</p>
            <div class="divider-gold w-full mb-3"></div>
            <div class="text-center px-2 mb-3">
                <svg class="w-8 h-8 mx-auto mb-2 text-gold-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <p class="text-xs text-zinc-500 leading-relaxed">Takdirmu telah menunggu.<br>Siap untuk diungkap?</p>
            </div>
            <button onclick="openHouseModal()"
                    class="theme-action theme-action-gold cursor-pointer">
                Pilih House
            </button>

        @else
            {{-- Menunggu ACC: card kosong dengan info --}}
            <div class="text-center px-2">
                <svg class="w-10 h-10 mx-auto mb-3 text-amber-500/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs text-zinc-500 leading-relaxed">Menunggu konfirmasi admin.<br>Tombol aksi akan muncul setelah akun disetujui.</p>
            </div>

        @endif
    </div>

    {{-- Jadwal Kegiatan --}}
    <div class="schedule-card mobile-card rounded-lg p-6 reveal">
        <p class="font-bold text-[#0a0806] mb-4">📅 Jadwal Kegiatan</p>
        <div class="space-y-3">
            @forelse($jadwals as $jadwal)
                <div class="border-b border-black/20 pb-2 last:border-0 last:pb-0">
                    <p class="text-sm font-semibold text-[#0a0806]">{{ $jadwal->nama }}</p>
                    <p class="text-xs text-black/65 mt-0.5">
                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d') }}
                        | {{ substr($jadwal->waktu_mulai,0,5) }} - {{ substr($jadwal->waktu_selesai,0,5) }}
                    </p>
                </div>
            @empty
                <p class="text-xs text-black/60 font-cinzel tracking-widest uppercase text-center py-2">Belum ada agenda.</p>
            @endforelse
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════
     ROW 2: Pengumuman | Jangan Lupa Follow
     (tampil di semua kondisi)
═══════════════════════════════════════════ --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

    {{-- Pengumuman --}}
    <div class="card-glass rounded-lg p-6 reveal">
        <p class="font-bold text-white mb-4">📣 Pengumuman</p>
        <div class="flex items-center gap-2">
            <span class="w-1 h-4 rounded-full shrink-0" style="background: #C9A84C;"></span>
            <p class="text-sm text-zinc-400">Coming Soon ✨</p>
        </div>
    </div>

    {{-- Jangan Lupa Follow --}}
    <div class="card-glass rounded-lg p-6 reveal">
        <p class="font-bold text-white mb-4">📱 Jangan Lupa Follow Yaa!!</p>
        <div class="space-y-2">
            @foreach($sosmed as $sm)
                <a href="{{ $sm->url }}" target="_blank"
                   class="flex items-center gap-2 px-3 py-2.5 rounded-sm transition group"
                   style="background: rgba(255,255,255,0.03); border-left: 3px solid rgba(201,168,76,0.5);">
                    <span class="text-sm text-zinc-300 group-hover:text-white transition">{{ $sm->nama }}</span>
                </a>
            @endforeach
        </div>
    </div>

</div>

@endsection

@push('scripts')
<style>
/* ═══════════════════════════════════════════════════════
   HOUSE MODAL — GAMATIF EKSPEDISI 2026
   Sinematik / Ekspedisi Gurun / Dark Gold aesthetic
═══════════════════════════════════════════════════════ */

/* ── Overlay ── */
#hm-overlay {
    position: fixed; inset: 0; z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    background: rgba(4, 3, 2, 0.92);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    opacity: 0; pointer-events: none;
    transition: opacity 0.5s ease;
}
#hm-overlay.hm-open { opacity: 1; pointer-events: all; }

/* ── Modal shell ── */
#hm-modal {
    position: relative;
    width: 100%; max-width: 460px;
    min-height: 340px;
    background: linear-gradient(165deg,
        rgba(20, 15, 8, 0.98) 0%,
        rgba(12, 9, 5, 0.99) 100%);
    border: 1px solid rgba(201,168,76,0.3);
    border-radius: 0.875rem;
    box-shadow:
        0 0 0 1px rgba(201,168,76,0.06),
        0 0 60px rgba(201,168,76,0.10),
        0 32px 80px rgba(0,0,0,0.8);
    padding: 2.25rem 2rem 2.5rem;
    text-align: center;
    overflow: hidden;
    transform: translateY(28px) scale(0.96);
    transition: transform 0.5s cubic-bezier(0.16,1,0.3,1);
}
#hm-overlay.hm-open #hm-modal { transform: translateY(0) scale(1); }

/* ── Particle canvas (behind everything) ── */
#hm-canvas {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    pointer-events: none; border-radius: inherit;
    opacity: 0.55;
}

/* ── Sigil / emblem background ── */
#hm-sigil {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 220px; height: 220px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.8s ease;
}
#hm-sigil svg { width: 100%; height: 100%; }

/* ── Radial glow (result phase) ── */
#hm-radial {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 0; height: 0;
    border-radius: 50%;
    background: radial-gradient(circle,
        rgba(201,168,76,0.18) 0%,
        rgba(201,168,76,0.05) 50%,
        transparent 70%);
    pointer-events: none;
    transition: width 1.2s ease, height 1.2s ease, opacity 1s ease;
    opacity: 0;
}
#hm-radial.active {
    width: 500px; height: 500px; opacity: 1;
}

/* ── Gold divider ── */
.hm-divider {
    height: 1px; margin: 1.1rem auto;
    background: linear-gradient(90deg,
        transparent, rgba(201,168,76,0.45) 25%,
        rgba(201,168,76,0.75) 50%,
        rgba(201,168,76,0.45) 75%, transparent);
}

/* ── Close btn ── */
#hm-close {
    position: absolute; top: 0.9rem; right: 0.9rem;
    width: 28px; height: 28px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    border: 1px solid rgba(201,168,76,0.28);
    background: rgba(201,168,76,0.07);
    color: rgba(201,168,76,0.65);
    cursor: pointer; font-size: 13px;
    transition: all 0.2s; z-index: 10;
}
#hm-close:hover { background: rgba(201,168,76,0.16); color: #E8D49E; }
#hm-close.hidden { display: none; }

/* ── Phases wrapper ── */
.hm-phase { position: relative; z-index: 2; }

/* ── Phase label (top classified text) ── */
.hm-label {
    font-family: 'Cinzel', serif;
    font-size: 0.52rem;
    letter-spacing: 0.45em;
    text-transform: uppercase;
    color: rgba(201,168,76,0.6);
    margin-bottom: 0.4rem;
}

/* ── System info row ── */
.hm-sysline {
    font-family: 'Courier New', monospace;
    font-size: 0.62rem;
    letter-spacing: 0.08em;
    color: rgba(201,168,76,0.4);
    line-height: 1.7;
}
.hm-sysline span { color: rgba(201,168,76,0.7); }

/* ── Main title ── */
.hm-title {
    font-family: 'Cinzel', serif;
    font-size: clamp(1.5rem, 5vw, 2.1rem);
    font-weight: 900;
    text-transform: uppercase;
    color: #fff;
    letter-spacing: -0.01em;
    line-height: 1.1;
    margin: 0.5rem 0 0.3rem;
    text-shadow: 0 0 40px rgba(201,168,76,0.2);
}
.hm-title-gold { color: #C9A84C; }

/* ── Subtitle ── */
.hm-sub {
    font-size: 0.75rem;
    letter-spacing: 0.15em;
    color: rgba(245,230,200,0.45);
    text-transform: uppercase;
}

/* ── Primary action button ── */
.hm-btn {
    display: inline-block;
    position: relative; overflow: hidden;
    background: linear-gradient(135deg,
        rgba(201,168,76,0.20) 0%,
        rgba(201,168,76,0.07) 50%,
        rgba(201,168,76,0.16) 100%);
    border: 1px solid rgba(201,168,76,0.5);
    color: #F5E6C8;
    font-family: 'Cinzel', serif;
    font-size: 0.65rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    font-weight: 700;
    padding: 0.75rem 2.2rem;
    border-radius: 0.2rem;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 18px rgba(0,0,0,0.35),
                inset 0 1px 0 rgba(255,255,255,0.07);
    margin-top: 0.5rem;
}
.hm-btn::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.06), transparent 60%);
    pointer-events: none;
}
.hm-btn:hover:not(:disabled) {
    background: linear-gradient(135deg,
        rgba(201,168,76,0.38), rgba(201,168,76,0.14) 50%,
        rgba(201,168,76,0.30));
    border-color: rgba(201,168,76,0.85);
    color: #fff;
    box-shadow: 0 8px 28px rgba(201,168,76,0.20),
                inset 0 1px 0 rgba(255,255,255,0.10);
}
.hm-btn:disabled { opacity: 0.35; cursor: not-allowed; }

/* ── Scan phase: progress bar ── */
.hm-prog-track {
    width: 100%; height: 2px;
    background: rgba(201,168,76,0.10);
    border-radius: 2px; overflow: hidden;
    margin: 1rem 0 0.5rem;
}
.hm-prog-fill {
    height: 100%; width: 0%;
    background: linear-gradient(90deg, #7A5820, #C9A84C, #F0DC9C, #C9A84C);
    background-size: 200% 100%;
    border-radius: 2px;
    transition: width 0.5s ease;
    box-shadow: 0 0 10px rgba(201,168,76,0.7);
    animation: progShimmer 1.5s linear infinite;
}
@keyframes progShimmer {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ── Scan lines ── */
.hm-scan-line {
    display: flex; align-items: center; justify-content: space-between;
    font-family: 'Courier New', monospace;
    font-size: 0.65rem; letter-spacing: 0.06em;
    padding: 0.25rem 0;
    color: rgba(201,168,76,0.28);
    transition: color 0.3s;
    border-bottom: 1px solid rgba(201,168,76,0.05);
}
.hm-scan-line .hm-scan-key { color: inherit; }
.hm-scan-line .hm-scan-val { color: rgba(201,168,76,0.25); font-style: italic; }
.hm-scan-line.active { color: rgba(201,168,76,0.9); }
.hm-scan-line.active .hm-scan-val { color: rgba(201,168,76,0.75); font-style: normal; }
.hm-scan-line.done { color: rgba(201,168,76,0.55); }
.hm-scan-line.done .hm-scan-val { color: rgba(150,220,150,0.7); }

/* ── Radar ring ── */
#hm-radar {
    position: absolute;
    width: 140px; height: 140px;
    border-radius: 50%;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none; z-index: 0;
    opacity: 0; transition: opacity 0.4s;
}
#hm-radar.active { opacity: 1; }
#hm-radar::before, #hm-radar::after {
    content: '';
    position: absolute; inset: 0; border-radius: 50%;
    border: 1px solid rgba(201,168,76,0.18);
    animation: radarPing 2s ease-out infinite;
}
#hm-radar::after { animation-delay: 1s; }
@keyframes radarPing {
    0%   { transform: scale(0.5); opacity: 0.7; }
    100% { transform: scale(2.5); opacity: 0; }
}

/* ── Result: house name reveal ── */
@keyframes houseReveal {
    0%   { opacity:0; transform: scale(0.75) translateY(14px); filter: blur(6px); }
    60%  { opacity:1; transform: scale(1.05) translateY(-3px); filter: blur(0); }
    100% { opacity:1; transform: scale(1) translateY(0); }
}
.hm-house-name {
    font-family: 'Cinzel', serif;
    font-size: clamp(1.8rem, 7vw, 2.8rem);
    font-weight: 900;
    text-transform: uppercase;
    color: #C9A84C;
    letter-spacing: 0.18em;
    line-height: 1;
    animation: houseReveal 0.9s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes goldPulse {
    0%,100% { text-shadow: 0 0 14px rgba(201,168,76,0.35), 0 2px 8px rgba(0,0,0,0.6); }
    50%      { text-shadow: 0 0 30px rgba(201,168,76,0.75), 0 0 60px rgba(201,168,76,0.22), 0 2px 8px rgba(0,0,0,0.6); }
}
.hm-house-name { animation: houseReveal 0.9s cubic-bezier(0.16,1,0.3,1) both, goldPulse 2.8s 0.9s ease-in-out infinite; }

/* ── Journey text ── */
@keyframes fadeSlideUp {
    0%   { opacity:0; transform: translateY(10px); }
    100% { opacity:1; transform: translateY(0); }
}
.hm-journey { animation: fadeSlideUp 0.7s 0.4s ease both; }

/* ── Phase fade transition ── */
.hm-phase {
    animation: fadePh 0.35s ease both;
}
@keyframes fadePh {
    from { opacity:0; transform: translateY(8px); }
    to   { opacity:1; transform: translateY(0); }
}
</style>

{{-- ══════════════════════════════════════════════════
     MODAL PEMILIHAN HOUSE — SINEMATIK
══════════════════════════════════════════════════ --}}
<div id="hm-overlay" role="dialog" aria-modal="true" aria-labelledby="hm-main-title">

    <div id="hm-modal">

        {{-- Particle canvas --}}
        <canvas id="hm-canvas"></canvas>

        {{-- Sigil --}}
        <div id="hm-sigil">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="90" stroke="rgba(201,168,76,0.12)" stroke-width="1"/>
                <circle cx="100" cy="100" r="70" stroke="rgba(201,168,76,0.10)" stroke-width="1"/>
                <circle cx="100" cy="100" r="50" stroke="rgba(201,168,76,0.08)" stroke-width="0.5"/>
                <polygon points="100,18 116,68 168,68 126,98 142,148 100,118 58,148 74,98 32,68 84,68"
                         fill="none" stroke="rgba(201,168,76,0.15)" stroke-width="1"/>
                <line x1="100" y1="10" x2="100" y2="190" stroke="rgba(201,168,76,0.07)" stroke-width="0.5"/>
                <line x1="10"  y1="100" x2="190" y2="100" stroke="rgba(201,168,76,0.07)" stroke-width="0.5"/>
                <line x1="29"  y1="29" x2="171" y2="171" stroke="rgba(201,168,76,0.05)" stroke-width="0.5"/>
                <line x1="171" y1="29" x2="29"  y2="171" stroke="rgba(201,168,76,0.05)" stroke-width="0.5"/>
                <circle cx="100" cy="100" r="6" fill="rgba(201,168,76,0.25)"/>
            </svg>
        </div>

        {{-- Radar ring (scan phase) --}}
        <div id="hm-radar"></div>

        {{-- Radial glow (result phase) --}}
        <div id="hm-radial"></div>

        {{-- Close --}}
        <button id="hm-close" onclick="hmClose()" aria-label="Tutup modal">✕</button>

        {{-- ─── FASE 1: PANGGILAN ─── --}}
        <div id="hm-p1" class="hm-phase">
            <p class="hm-label">GAMATIF // EKSPEDISI 2026</p>
            <div class="hm-sysline mt-1 mb-3">
                <div>ID PESERTA: <span>{{ $peserta->nim }}</span></div>
                <div>STATUS: <span style="color: rgba(150,220,150,0.75);">TERVERIFIKASI</span></div>
            </div>
            <div class="hm-divider"></div>
            <h2 id="hm-main-title" class="hm-title">
                PANGGILAN TELAH<br><span class="hm-title-gold">DIMULAI</span>
            </h2>
            <div class="hm-divider"></div>
            <p class="hm-sub mb-6">House-mu telah menanti.</p>
            <button class="hm-btn" onclick="hmBegin()">UNGKAP HOUSE-MU</button>
        </div>

        {{-- ─── FASE 2: PENENTUAN ─── --}}
        <div id="hm-p2" class="hm-phase" style="display:none;">
            <p class="hm-label mb-4">PENENTUAN SEDANG BERLANGSUNG</p>
            <div class="hm-prog-track">
                <div class="hm-prog-fill" id="hm-prog"></div>
            </div>
            <div class="mt-3 space-y-0.5" id="hm-steps">
                <div class="hm-scan-line" id="hs1">
                    <span class="hm-scan-key">IDENTITAS</span>
                    <span class="hm-scan-val" id="hs1v">........</span>
                </div>
                <div class="hm-scan-line" id="hs2">
                    <span class="hm-scan-key">PROFIL</span>
                    <span class="hm-scan-val" id="hs2v">........</span>
                </div>
                <div class="hm-scan-line" id="hs3">
                    <span class="hm-scan-key">PENENTUAN</span>
                    <span class="hm-scan-val" id="hs3v">........</span>
                </div>
            </div>
        </div>

        {{-- ─── FASE 3: PENGUNGKAPAN ─── --}}
        <div id="hm-p3" class="hm-phase" style="display:none;">
            <p class="hm-label" style="color: rgba(150,220,150,0.7);">PENENTUAN HOUSE SELESAI</p>
            <div class="hm-divider"></div>
            <p class="hm-sub mb-3">Kamu telah ditempatkan di</p>
            <div id="hm-house-name" class="hm-house-name mb-3"></div>
            <div class="hm-divider"></div>
            <p class="hm-sub hm-journey mt-2 mb-5"
               style="color:rgba(201,168,76,0.5); font-size:0.6rem;">
                PERJALANANMU DIMULAI DI SINI
            </p>
            <button class="hm-btn" onclick="hmEnter()">MASUK KE HOUSE</button>
        </div>

        {{-- ─── FASE ERROR ─── --}}
        <div id="hm-pe" class="hm-phase" style="display:none;">
            <p class="hm-label" style="color: rgba(220,80,80,0.75);">PENENTUAN GAGAL</p>
            <div class="hm-divider"></div>
            <p id="hm-err-msg" class="text-sm mb-5" style="color:rgba(245,230,200,0.5);">Terjadi kesalahan.</p>
            <button class="hm-btn" onclick="hmReset()">COBA LAGI</button>
        </div>

    </div>
</div>

<script>
/* ═══════════════════════════════════════════════════
   SISTEM PARTIKEL — debu emas / pasir
═══════════════════════════════════════════════════ */
(function() {
    const canvas  = document.getElementById('hm-canvas');
    const ctx     = canvas.getContext('2d');
    let particles = [];
    let rafId     = null;
    let running   = false;

    function resize() {
        const modal = document.getElementById('hm-modal');
        canvas.width  = modal.offsetWidth;
        canvas.height = modal.offsetHeight;
    }

    function spawnParticle() {
        return {
            x: Math.random() * canvas.width,
            y: canvas.height + Math.random() * 20,
            vx: (Math.random() - 0.5) * 0.4,
            vy: -(0.25 + Math.random() * 0.55),
            r: 0.6 + Math.random() * 1.2,
            a: 0,
            maxA: 0.3 + Math.random() * 0.35,
            life: 0,
            maxLife: 120 + Math.random() * 160,
        };
    }

    function draw() {
        if (!running) return;
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // spawn
        if (particles.length < 55 && Math.random() < 0.4) {
            particles.push(spawnParticle());
        }

        particles.forEach((p, i) => {
            p.life++;
            p.x += p.vx; p.y += p.vy;
            // fade in / fade out
            const half = p.maxLife / 2;
            p.a = p.life < half
                ? (p.life / half) * p.maxA
                : ((p.maxLife - p.life) / half) * p.maxA;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(201,168,76,${p.a})`;
            ctx.fill();
        });

        particles = particles.filter(p => p.life < p.maxLife);
        rafId = requestAnimationFrame(draw);
    }

    window.hmParticlesStart = function() {
        if (running) return;
        running = true;
        resize();
        draw();
    };
    window.hmParticlesStop = function() {
        running = false;
        if (rafId) cancelAnimationFrame(rafId);
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles = [];
    };
    window.addEventListener('resize', resize);
})();

/* ═══════════════════════════════════════════════════
   LOGIKA MODAL
═══════════════════════════════════════════════════ */
let hmCanClose = true;
let hmRequested = false;

function hmShowPhase(id) {
    ['hm-p1','hm-p2','hm-p3','hm-pe'].forEach(p => {
        const el = document.getElementById(p);
        el.style.display = 'none';
    });
    const target = document.getElementById(id);
    target.style.display = 'block';
    // re-trigger animation
    target.classList.remove('hm-phase');
    void target.offsetWidth;
    target.classList.add('hm-phase');
}

function hmOpen() {
    hmReset();
    document.getElementById('hm-overlay').classList.add('hm-open');
    document.body.style.overflow = 'hidden';
    hmParticlesStart();
}

function hmClose() {
    if (!hmCanClose) return;
    document.getElementById('hm-overlay').classList.remove('hm-open');
    document.body.style.overflow = '';
    hmParticlesStop();
    // reset sigil/radar/radial
    document.getElementById('hm-sigil').style.opacity = '0';
    document.getElementById('hm-radar').classList.remove('active');
    document.getElementById('hm-radial').classList.remove('active');
}

function hmReset() {
    hmCanClose = true;
    document.getElementById('hm-close').classList.remove('hidden');
    document.getElementById('hm-prog').style.width = '0%';
    document.getElementById('hm-sigil').style.opacity = '0';
    document.getElementById('hm-radar').classList.remove('active');
    document.getElementById('hm-radial').classList.remove('active');
    ['hs1','hs2','hs3'].forEach(id => {
        document.getElementById(id).className = 'hm-scan-line';
    });
    document.getElementById('hs1v').innerText = '........';
    document.getElementById('hs2v').innerText = '........';
    document.getElementById('hs3v').innerText = '........';
    hmShowPhase('hm-p1');
}

function hmBegin() {
    if (hmRequested) return;  // prevent double-tap
    hmRequested = true;
    hmCanClose = false;
    document.getElementById('hm-close').classList.add('hidden');

    hmShowPhase('hm-p2');

    const prog = document.getElementById('hm-prog');

    // Activate radar
    setTimeout(() => document.getElementById('hm-radar').classList.add('active'), 100);

    // Show sigil faintly
    setTimeout(() => document.getElementById('hm-sigil').style.opacity = '0.35', 200);

    // Step 1 — IDENTITAS
    setTimeout(() => {
        document.getElementById('hs1').classList.add('active');
        prog.style.width = '28%';
    }, 300);
    setTimeout(() => {
        document.getElementById('hs1').classList.replace('active','done');
        document.getElementById('hs1v').innerText = 'TERVERIFIKASI ✓';
        prog.style.width = '55%';
        document.getElementById('hs2').classList.add('active');
    }, 900);

    // Step 2 — PROFIL
    setTimeout(() => {
        document.getElementById('hs2').classList.replace('active','done');
        document.getElementById('hs2v').innerText = 'SESUAI ✓';
        prog.style.width = '78%';
        document.getElementById('hs3').classList.add('active');
    }, 1550);

    // Step 3 — PENENTUAN + fire fetch
    setTimeout(() => {
        prog.style.width = '92%';

        fetch("{{ route('peserta.gacha_kelompok') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                // Complete progress
                document.getElementById('hs3').classList.replace('active','done');
                document.getElementById('hs3v').innerText = 'SELESAI ✓';
                prog.style.width = '100%';

                // Brief pause then reveal
                setTimeout(() => hmReveal(data.kelompok.nama), 600);
            } else {
                hmFail(data.message || 'Terjadi kesalahan.');
            }
        })
        .catch(() => hmFail('Koneksi gagal. Coba lagi.'));

    }, 2000);
}

function hmReveal(houseName) {
    // Hide radar, show radial glow
    document.getElementById('hm-radar').classList.remove('active');
    document.getElementById('hm-sigil').style.opacity = '0.6';

    // Flash the modal slightly darker before reveal
    const modal = document.getElementById('hm-modal');
    modal.style.transition = 'background 0.35s ease';
    modal.style.background = 'rgba(4,3,2,0.99)';

    setTimeout(() => {
        modal.style.background = '';
        modal.style.transition = '';

        // Show phase 3
        document.getElementById('hm-house-name').innerText = houseName;
        hmShowPhase('hm-p3');

        // Trigger radial glow
        setTimeout(() => document.getElementById('hm-radial').classList.add('active'), 100);

        // Show close again
        document.getElementById('hm-close').classList.remove('hidden');
        hmCanClose = true;
    }, 380);
}

function hmFail(msg) {
    hmRequested = false;
    hmCanClose = true;
    document.getElementById('hm-close').classList.remove('hidden');
    document.getElementById('hm-radar').classList.remove('active');
    document.getElementById('hm-err-msg').innerText = msg;
    hmShowPhase('hm-pe');
}

function hmEnter() {
    hmClose();
    location.reload();
}

// Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') hmClose();
});

// Click outside
document.getElementById('hm-overlay').addEventListener('click', e => {
    if (e.target === document.getElementById('hm-overlay')) hmClose();
});

// Expose open function for the button
window.openHouseModal = hmOpen;
</script>
@endpush
