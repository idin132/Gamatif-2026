<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PK Portal - {{ $kelompok->nama_kelompok ?? 'House' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        cinzel: ['Cinzel', 'serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        gold: { 300: '#F5E6C8', 400: '#E8D49E', 500: '#C9A84C', 600: '#A67C2A' }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0a0806;
        }

        .page-bg {
            background-image:
                linear-gradient(to bottom, rgba(10, 8, 6, 0.78) 0%, rgba(10, 8, 6, 0.92) 100%),
                url('/images/BACKGROUND_WEB.png');
            background-size: cover;
            background-position: center top;
            background-attachment: fixed;
        }

        /* ── Topbar ── */
        .topbar {
            background: rgba(10, 8, 6, 0.85);
            backdrop-filter: blur(20px) saturate(160%);
            -webkit-backdrop-filter: blur(20px) saturate(160%);
            border-bottom: 1px solid rgba(201, 168, 76, 0.18);
        }

        /* ── Card glass ── */
        .card-glass {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
            backdrop-filter: blur(20px) saturate(150%);
            -webkit-backdrop-filter: blur(20px) saturate(150%);
            border: 1px solid rgba(201, 168, 76, 0.18);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.04);
            transition: border-color 0.3s;
        }

        .pk-main [class*="text-zinc-"],
        .pk-main [class*="text-gold-500/70"] {
            color: #fff !important;
        }

        @media (max-width: 640px) {
            .pk-main {
                padding-inline: 0.75rem;
                padding-top: 0.75rem;
                gap: 0.65rem;
            }

            .pk-main .card-glass {
                padding: 0.75rem;
                border-radius: 0.5rem;
            }

            .pk-main .space-y-4> :not([hidden])~ :not([hidden]) {
                margin-top: 0.75rem;
            }

            .pk-main .space-y-3> :not([hidden])~ :not([hidden]) {
                margin-top: 0.6rem;
            }

            .pk-main .grid.grid-cols-5 {
                gap: 0.35rem;
            }

            .pk-main .barang-btn {
                height: 2.25rem;
            }
        }

        /* ── Section label ── */
        .section-label {
            font-family: 'Cinzel', serif;
            font-size: 0.58rem;
            letter-spacing: 0.38em;
            text-transform: uppercase;
            color: #C9A84C;
        }

        /* ── Day tab active ── */
        .day-tab-active {
            background: linear-gradient(135deg, rgba(201, 168, 76, 0.28), rgba(201, 168, 76, 0.12));
            border: 1px solid rgba(201, 168, 76, 0.5);
            color: #F5E6C8;
            font-family: 'Cinzel', serif;
            font-weight: 700;
        }

        .day-tab-inactive {
            color: rgba(161, 161, 170, 0.65);
            border: 1px solid transparent;
        }

        /* ── Barang button ── */
        .barang-active {
            background: rgba(6, 95, 70, 0.7) !important;
            border-color: #10b981 !important;
            color: #a7f3d0 !important;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.25);
        }

        .barang-inactive {
            background: rgba(255, 255, 255, 0.04) !important;
            border-color: rgba(201, 168, 76, 0.15) !important;
            color: rgba(161, 161, 170, 0.5) !important;
        }

        /* ── Input ── */
        .input-glass {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-radius: 0.25rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            color: #e4e4e7;
            outline: none;
            transition: border-color 0.25s;
        }

        .input-glass:focus {
            border-color: rgba(201, 168, 76, 0.5);
        }

        .input-glass::placeholder {
            color: rgba(161, 161, 170, 0.4);
        }

        /* ── Bottom nav ── */
        .bottom-nav {
            background: rgba(10, 8, 6, 0.92);
            backdrop-filter: blur(20px) saturate(160%);
            -webkit-backdrop-filter: blur(20px) saturate(160%);
            border-top: 1px solid rgba(201, 168, 76, 0.15);
        }

        /* ── Btn glass small ── */
        .btn-glass-sm {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(201, 168, 76, 0.18), rgba(201, 168, 76, 0.06) 50%, rgba(201, 168, 76, 0.14));
            backdrop-filter: blur(12px);
            border: 1px solid rgba(201, 168, 76, 0.4);
            color: #F5E6C8;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: all 0.25s;
        }

        .btn-glass-sm:hover {
            border-color: rgba(201, 168, 76, 0.75);
            background: linear-gradient(135deg, rgba(201, 168, 76, 0.32), rgba(201, 168, 76, 0.14));
            color: #fff;
        }

        /* ── Flash alert ── */
        .alert-success {
            background: rgba(6, 78, 59, 0.45);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #6ee7b7;
            border-radius: 0.25rem;
            padding: 0.625rem 1rem;
            font-size: 0.75rem;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0806;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(201, 168, 76, 0.3);
            border-radius: 2px;
        }
    </style>
</head>

<body class="page-bg text-zinc-100 font-inter pb-24 select-none min-h-screen"
    x-data="{ activeTab: 'bawaan', activeDay: 'day_1' }">

    <!-- ══ Top Bar ══ -->
    <div class="topbar sticky top-0 z-40 px-4 py-2 flex items-center justify-between">
        <img src="/images/logo-gamatif.png" alt="GAMATIF"
            class="h-5 w-auto drop-shadow-[0_1px_5px_rgba(201,168,76,0.4)]">

        {{-- Profile chip with dropdown --}}
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" class="flex items-center gap-1.5 px-2 py-1 rounded-full transition"
                style="border: 1px solid rgba(201,168,76,0.35); background: rgba(201,168,76,0.08);">
                {{-- Avatar inisial --}}
                <span
                    class="w-6 h-6 rounded-full flex items-center justify-center text-[0.55rem] font-black text-black shrink-0"
                    style="background: #C9A84C;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </span>
                {{-- Nama --}}
                <span class="font-cinzel text-[0.62rem] tracking-wide text-gold-300 max-w-[80px] truncate">
                    {{ explode(' ', $user->name)[0] }}
                </span>
                {{-- Chevron --}}
                <svg class="w-2.5 h-2.5 text-gold-500/60 transition-transform shrink-0"
                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Dropdown --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                x-transition:enter-end="opacity-1 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-1 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-1.5 w-36 rounded-lg overflow-hidden z-50" style="background: rgba(12,9,6,0.97);
                        border: 1px solid rgba(201,168,76,0.22);
                        box-shadow: 0 12px 32px rgba(0,0,0,0.6);">
                {{-- Header chip info --}}
                <div class="px-3 py-2 border-b" style="border-color: rgba(201,168,76,0.12);">
                    <p class="font-cinzel font-bold text-white text-[0.68rem] truncate">{{ $user->name }}</p>
                    <p class="text-[0.55rem] tracking-widest uppercase mt-0.5" style="color: rgba(201,168,76,0.5);">
                        House Leader</p>
                </div>
                {{-- Logout --}}
                <div class="py-1">
                    <form action="{{ route('pk.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-3 py-2 text-[0.7rem] text-rose-400 hover:text-rose-300 hover:bg-white/5 transition flex items-center gap-2">
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ Flash ══ -->
    @if(session('success'))
        <div class="px-4 mt-3">
            <div class="alert-success">{{ session('success') }}</div>
        </div>
    @endif

    <!-- ══ Main Content ══ -->
    <main class="pk-main px-4 pt-4 pb-2 space-y-3">

        {{-- Sub-header: nama house --}}
        <div class="mb-0.5">
            <span class="section-label block mb-0.5">House Leader Panel</span>
            <h1 class="font-cinzel text-lg font-black text-white leading-tight">
                House <span class="text-gold-400">{{ $kelompok->nama_kelompok ?? '-' }}</span>
            </h1>
        </div>

        <!-- ─ TAB 1: BARANG BAWAAN ─ -->
        <div x-show="activeTab === 'bawaan'" class="space-y-4">

            <!-- Day selector -->
            <div class="grid grid-cols-3 gap-1.5 p-1 card-glass rounded-lg">
                <button @click="activeDay = 'day_1'"
                    :class="activeDay === 'day_1' ? 'day-tab-active' : 'day-tab-inactive'"
                    class="py-1.5 text-[0.65rem] rounded-md transition font-cinzel tracking-widest text-center">
                    Day 1
                </button>
                <button @click="activeDay = 'day_2'"
                    :class="activeDay === 'day_2' ? 'day-tab-active' : 'day-tab-inactive'"
                    class="py-1.5 text-[0.65rem] rounded-md transition font-cinzel tracking-widest text-center">
                    Day 2
                </button>
                <button @click="activeDay = 'day_3'"
                    :class="activeDay === 'day_3' ? 'day-tab-active' : 'day-tab-inactive'"
                    class="py-1.5 text-[0.65rem] rounded-md transition font-cinzel tracking-widest text-center">
                    Day 3
                </button>
            </div>

            <!-- Keterangan barang -->
            <div class="card-glass px-3.5 py-3 rounded-lg text-xs space-y-1">
                <p class="section-label mb-1.5">Keterangan Barang Bawaan</p>

                <div x-show="activeDay === 'day_1'" class="space-y-0.5 text-zinc-400">
                    @forelse($masterBarang['day_1'] ?? [] as $idx => $nama)
                        <p><span class="font-mono text-gold-500 font-bold">B{{ $idx + 1 }}:</span> {{ $nama }}</p>
                    @empty
                        <p class="text-zinc-600 italic text-[11px]">Belum ada data barang Day 1.</p>
                    @endforelse
                </div>
                <div x-show="activeDay === 'day_2'" class="space-y-0.5 text-zinc-400">
                    @forelse($masterBarang['day_2'] ?? [] as $idx => $nama)
                        <p><span class="font-mono text-gold-500 font-bold">B{{ $idx + 1 }}:</span> {{ $nama }}</p>
                    @empty
                        <p class="text-zinc-600 italic text-[11px]">Belum ada data barang Day 2.</p>
                    @endforelse
                </div>
                <div x-show="activeDay === 'day_3'" class="space-y-0.5 text-zinc-400">
                    @forelse($masterBarang['day_3'] ?? [] as $idx => $nama)
                        <p><span class="font-mono text-gold-500 font-bold">B{{ $idx + 1 }}:</span> {{ $nama }}</p>
                    @empty
                        <p class="text-zinc-600 italic text-[11px]">Belum ada data barang Day 3.</p>
                    @endforelse
                </div>
            </div>

            <p class="text-[10px] text-zinc-500 -mt-1 px-0.5">Tap B1–B5 untuk toggle status bawa. <span
                    class="text-emerald-500/70">Hijau = Bawa.</span></p>

            <!-- Mahasiswa cards -->
            <div class="space-y-3">
                @forelse($dataMahasiswas as $row)
                    <div id="card-maba-{{ $row->id }}" class="card-glass p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <h3 class="font-cinzel font-bold text-sm text-white">{{ $row->nama }}</h3>
                                <span class="text-xs font-mono text-gold-500/70">{{ $row->nim }}</span>
                            </div>
                            <button type="button" onclick="checkAllBarang({{ $row->id }})"
                                class="btn-glass-sm px-3 py-1.5 rounded-sm flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Semua
                            </button>
                        </div>

                        <div class="grid grid-cols-5 gap-2">
                            @for($i = 0; $i < 5; $i++)
                                @php
                                    $colDay1 = $barangColumns['day_1'][$i];
                                    $colDay2 = $barangColumns['day_2'][$i];
                                    $colDay3 = $barangColumns['day_3'][$i];
                                @endphp
                                <button type="button"
                                    @click="toggleBarang({{ $row->id }}, activeDay === 'day_1' ? '{{ $colDay1 }}' : (activeDay === 'day_2' ? '{{ $colDay2 }}' : '{{ $colDay3 }}'), $event)"
                                    class="barang-btn h-11 rounded-md flex flex-col items-center justify-center font-cinzel font-bold text-xs border transition"
                                    :class="$el.dataset[activeDay] === '1' ? 'barang-active' : 'barang-inactive'"
                                    data-day_1="{{ $row->$colDay1 }}" data-day_2="{{ $row->$colDay2 }}"
                                    data-day_3="{{ $row->$colDay3 }}">
                                    B{{ $i + 1 }}
                                </button>
                            @endfor
                        </div>
                    </div>
                @empty
                    <div class="card-glass rounded-lg py-6 px-4 text-center" style="border-color:rgba(201,168,76,0.08);">
                        <svg class="w-7 h-7 mx-auto mb-2 text-gold-500/20" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="section-label text-zinc-600 mb-0.5">Belum ada anggota</p>
                        <p class="text-[10px] text-zinc-600">Belum ada anggota yang terdaftar di kelompok ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ─ TAB 2: ABSENSI ─ -->
        <div x-show="activeTab === 'absensi'" class="space-y-4">

            @php
                $jadwalDay1 = $jadwals[0] ?? null;
                $jadwalDay2 = $jadwals[1] ?? null;
                $jadwalDay3 = $jadwals[2] ?? null;

                $badgeClasses = [
                    'hadir' => 'bg-emerald-950/80 border-emerald-600/50 text-emerald-300',
                    'telat' => 'bg-amber-950/80 border-amber-600/50 text-amber-300',
                    'izin' => 'bg-blue-950/80 border-blue-600/50 text-blue-300',
                    'sakit' => 'bg-purple-950/80 border-purple-600/50 text-purple-300',
                    'alpa' => 'bg-rose-950/80 border-rose-600/50 text-rose-300',
                ];
            @endphp

            <!-- ── DAY SELECTOR ── -->
            <div class="grid grid-cols-3 gap-1.5 p-1 card-glass rounded-lg">
                <!-- Day 1 -->
                <button @click="activeDay = 'day_1'" :class="activeDay === 'day_1'
                ? 'day-tab-active'
                : 'day-tab-inactive'"
                    class="py-1.5 text-[0.65rem] rounded-md transition font-cinzel tracking-widest text-center">
                    Day 1
                </button>
                <!-- Day 2 -->
                <button @click="activeDay = 'day_2'" :class="activeDay === 'day_2'
                ? 'day-tab-active'
                : 'day-tab-inactive'"
                    class="py-1.5 text-[0.65rem] rounded-md transition font-cinzel tracking-widest text-center">
                    Day 2
                </button>
                <!-- Day 3 -->
                <button @click="activeDay = 'day_3'" :class="activeDay === 'day_3'
                ? 'day-tab-active'
                : 'day-tab-inactive'"
                    class="py-1.5 text-[0.65rem] rounded-md transition font-cinzel tracking-widest text-center">
                    Day 3
                </button>
            </div>

            <!-- ── INFO ── -->
            <!-- <div class="flex items-center justify-between px-1">
                <p class="text-[10px] text-zinc-600">
                    Status kehadiran tercatat melalui sistem absensi.
                </p>
                <span class="text-[9px] text-zinc-700 font-cinzel tracking-wider uppercase">
                    Read Only
                </span>
            </div> -->

            <!-- ── LIST MAHASISWA ── -->
            <div class="space-y-3">
                @forelse($mabas as $maba)
                    @php
                        $statusDay1 = $maba->absensis
                            ->firstWhere('jadwal_kegiatan_id', $jadwalDay1?->id)
                                ?->status ?? 'Belum Absen / Tanpa Keterangan';

                        $statusDay2 = $maba->absensis
                            ->firstWhere('jadwal_kegiatan_id', $jadwalDay2?->id)
                                ?->status ?? 'Belum Absen / Tanpa Keterangan';

                        $statusDay3 = $maba->absensis
                            ->firstWhere('jadwal_kegiatan_id', $jadwalDay3?->id)
                                ?->status ?? 'Belum Absen / Tanpa Keterangan';
                    @endphp

                    <!-- ── MAHASISWA CARD ── -->
                    <div class="card-glass p-3.5 rounded-lg flex items-center justify-between">
                        <!-- Informasi Mahasiswa -->
                        <div class="min-w-0">
                            <h4 class="font-cinzel font-bold text-xs text-white truncate">
                                {{ $maba->nama_lengkap }}
                            </h4>
                            <span class="text-[10px] font-mono text-gold-500/70">
                                {{ $maba->nim }}
                            </span>
                        </div>

                        <!-- ── STATUS ABSENSI ── -->
                        <div class="ml-3 shrink-0">

                            <!-- DAY 1 -->
                            <div x-show="activeDay === 'day_1'">
                                <span class="inline-flex items-center justify-center min-w-[70px] px-2.5 py-1 rounded-md border text-[10px] font-cinzel font-semibold uppercase tracking-wider
                                {{ $badgeClasses[$statusDay1] ?? $badgeClasses['alpa'] }}">
                                    {{ ucfirst($statusDay1) }}
                                </span>
                            </div>

                            <!-- DAY 2 -->
                            <div x-show="activeDay === 'day_2'">
                                <span class="inline-flex items-center justify-center min-w-[70px] px-2.5 py-1 rounded-md border text-[10px] font-cinzel font-semibold uppercase tracking-wider
                                {{ $badgeClasses[$statusDay2] ?? $badgeClasses['alpa'] }}">
                                    {{ ucfirst($statusDay2) }}
                                </span>
                            </div>

                            <!-- DAY 3 -->
                            <div x-show="activeDay === 'day_3'">
                                <span class="inline-flex items-center justify-center min-w-[70px] px-2.5 py-1 rounded-md border text-[10px] font-cinzel font-semibold uppercase tracking-wider
                                {{ $badgeClasses[$statusDay3] ?? $badgeClasses['alpa'] }}">
                                    {{ ucfirst($statusDay3) }}
                                </span>
                            </div>
                        </div>
                    </div>

                @empty

                    <!-- ── EMPTY STATE ── -->
                    <div class="card-glass rounded-lg py-6 px-4 text-center" style="border-color:rgba(201,168,76,0.08);">

                        <svg class="w-7 h-7 mx-auto mb-2 text-gold-500/20" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <p class="section-label text-zinc-600 mb-0.5">
                            Belum ada anggota
                        </p>
                        <p class="text-[10px] text-zinc-600">
                            Belum ada anggota yang terdaftar di kelompok ini.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ─ TAB 3: IZIN ─ -->
        <div x-show="activeTab === 'izin'" class="space-y-4">
            <div class="card-glass p-5 rounded-lg">
                <p class="section-label mb-4">Input Surat Izin / Sakit</p>
                <form action="{{ route('pk.store_izin') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-3">
                    @csrf

                    <div>
                        <label class="section-label block mb-1.5">Pilih Mahasiswa</label>
                        <select name="mahasiswa_baru_id" required class="input-glass">
                            @foreach($mabas as $m)
                                <option value="{{ $m->id }}">{{ $m->nim }} - {{ $m->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="section-label block mb-1.5">Agenda Kegiatan</label>
                        <select name="jadwal_kegiatan_id" required class="input-glass">
                            @foreach($jadwals as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }} ({{ $j->tanggal->format('d M') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="section-label block mb-1.5">Keterangan</label>
                            <select name="keterangan" required class="input-glass">
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                            </select>
                        </div>
                        <div>
                            <label class="section-label block mb-1.5">Foto Surat</label>
                            <input type="file" name="foto" accept="image/*" capture="environment" class="w-full text-xs text-zinc-400
                                          file:py-1.5 file:px-3 file:rounded-sm file:border-0
                                          file:bg-gold-500/15 file:text-gold-400 file:text-xs
                                          hover:file:bg-gold-500/25 transition">
                        </div>
                    </div>

                    <div>
                        <label class="section-label block mb-1.5">Catatan / Alasan</label>
                        <textarea name="catatan" rows="2" required placeholder="Alasan sakit/izin..."
                            class="input-glass resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-sm text-xs font-cinzel tracking-widest uppercase
                                   bg-gradient-to-r from-gold-500/20 to-gold-500/10
                                   border border-gold-500/40 text-gold-300
                                   hover:from-gold-500/35 hover:to-gold-500/20 hover:border-gold-500/7 hover:text-white
                                   transition backdrop-blur-md">
                        Simpan Surat Izin
                    </button>
                </form>
            </div>
        </div>

        <!-- ─ TAB 4: ANGGOTA ─ -->
        <div x-show="activeTab === 'maba'" class="space-y-3">
            @forelse($mabas as $maba)
                <div class="card-glass p-3.5 rounded-lg flex items-center justify-between">
                    <div>
                        <h4 class="font-cinzel font-bold text-xs text-white">{{ $maba->nama_lengkap }}</h4>
                        <p class="text-[10px] font-mono text-gold-500/70">
                            {{ $maba->nim }} · {{ $maba->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $maba->nomor_whatsapp) }}" target="_blank" class="px-3 py-1.5 rounded-sm text-xs font-cinzel tracking-wider uppercase
                                              bg-emerald-900/40 border border-emerald-600/50 text-emerald-400
                                              hover:bg-emerald-800/50 hover:border-emerald-500 transition">
                        WA
                    </a>
                </div>
            @empty
                <div class="card-glass rounded-lg py-6 px-4 text-center" style="border-color:rgba(201,168,76,0.08);">
                    <svg class="w-7 h-7 mx-auto mb-2 text-gold-500/20" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="section-label text-zinc-600 mb-0.5">Belum ada anggota</p>
                    <p class="text-[10px] text-zinc-600">Belum ada anggota yang terdaftar di kelompok ini.</p>
                </div>
            @endforelse
        </div>

    </main>

    <!-- ══ Bottom Navigation ══ -->
    <nav class="bottom-nav fixed bottom-0 left-0 right-0 flex justify-around py-2 z-50">

        <button @click="activeTab = 'bawaan'" :class="activeTab === 'bawaan' ? 'text-gold-400' : 'text-zinc-600'"
            class="relative flex flex-col items-center text-[10px] gap-1 font-cinzel tracking-wider uppercase transition pt-1">
            <span x-show="activeTab === 'bawaan'"
                class="absolute top-0 left-1/2 -translate-x-1/2 w-5 h-0.5 rounded-b bg-gold-500"
                style="box-shadow:0 0 6px rgba(201,168,76,0.6);"></span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Bawaan
        </button>

        <button @click="activeTab = 'absensi'" :class="activeTab === 'absensi' ? 'text-gold-400' : 'text-zinc-600'"
            class="relative flex flex-col items-center text-[10px] gap-1 font-cinzel tracking-wider uppercase transition pt-1">
            <span x-show="activeTab === 'absensi'"
                class="absolute top-0 left-1/2 -translate-x-1/2 w-5 h-0.5 rounded-b bg-gold-500"
                style="box-shadow:0 0 6px rgba(201,168,76,0.6);"></span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Absensi
        </button>

        <button @click="activeTab = 'izin'" :class="activeTab === 'izin' ? 'text-gold-400' : 'text-zinc-600'"
            class="relative flex flex-col items-center text-[10px] gap-1 font-cinzel tracking-wider uppercase transition pt-1">
            <span x-show="activeTab === 'izin'"
                class="absolute top-0 left-1/2 -translate-x-1/2 w-5 h-0.5 rounded-b bg-gold-500"
                style="box-shadow:0 0 6px rgba(201,168,76,0.6);"></span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Izin
        </button>

        <button @click="activeTab = 'maba'" :class="activeTab === 'maba' ? 'text-gold-400' : 'text-zinc-600'"
            class="relative flex flex-col items-center text-[10px] gap-1 font-cinzel tracking-wider uppercase transition pt-1">
            <span x-show="activeTab === 'maba'"
                class="absolute top-0 left-1/2 -translate-x-1/2 w-5 h-0.5 rounded-b bg-gold-500"
                style="box-shadow:0 0 6px rgba(201,168,76,0.6);"></span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Anggota
        </button>

    </nav>

    <!-- ══ Scripts ══ -->
    <script>
        function toggleBarang(id, field, event) {
            const btn = event.currentTarget;
            const currentDay = Alpine.$data(document.querySelector('body')).activeDay;

            fetch("{{ route('pk.toggle_barang') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ id: id, field: field })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        btn.dataset[currentDay] = data.new_value;
                        if (data.new_value === '1' || data.new_value === 1) {
                            btn.classList.remove('barang-inactive');
                            btn.classList.add('barang-active');
                        } else {
                            btn.classList.remove('barang-active');
                            btn.classList.add('barang-inactive');
                        }
                    }
                })
                .catch(err => console.error(err));
        }

        function simpanAbsensi(mabaId, jadwalId, status) {
            fetch("{{ route('pk.update_kehadiran') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": getCsrfToken()
                },
                body: JSON.stringify({
                    mahasiswa_baru_id: mabaId,
                    jadwal_kegiatan_id: jadwalId,
                    status: status
                })
            })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) throw new Error(data.message || 'Gagal menyimpan status');
                    return data;
                })
                .catch(err => {
                    alert("Gagal update absensi: " + err.message);
                });
        }

        function checkAllBarang(id) {
            const currentDay = Alpine.$data(document.querySelector('body')).activeDay;
            const card = document.getElementById(`card-maba-${id}`);

            fetch("{{ route('pk.check_all_barang') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ id: id, day: currentDay })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        card.querySelectorAll('.barang-btn').forEach(btn => {
                            btn.dataset[currentDay] = '1';
                            btn.classList.remove('barang-inactive');
                            btn.classList.add('barang-active');
                        });
                    }
                })
                .catch(err => console.error(err));
        }
    </script>

</body>

</html>