<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamafess - {{ $pengaturan->nama_kegiatan ?? 'GAMATIF 2026' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/html-to-image@1.11.11/dist/html-to-image.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup {
            width: 280px !important;
            padding: 0.75rem !important;
            background: linear-gradient(135deg, rgba(255,255,255,0.12), rgba(255,255,255,0.04)) !important;
            backdrop-filter: blur(18px) saturate(150%) !important;
            -webkit-backdrop-filter: blur(18px) saturate(150%) !important;
            border: 1px solid rgba(201,168,76,0.45) !important;
            border-radius: 14px !important;
            box-shadow: 0 12px 40px rgba(0,0,0,0.55), inset 0 1px 0 rgba(255,255,255,0.12) !important;
        }
        .swal2-icon { transform: scale(0.7); margin: 0.25rem auto !important; }
        .swal2-title { font-size: 1.1rem !important; padding: 0.25rem 0 !important; }
        .swal2-html-container { font-size: 0.8rem !important; margin: 0.5rem 0 !important; }
        .swal2-confirm { font-size: 0.75rem !important; padding: 0.5rem 1rem !important; }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        cinzel: ['Cinzel', 'serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        gold: {
                            300: '#F5E6C8',
                            400: '#E8D49E',
                            500: '#C9A84C',
                            600: '#A67C2A',
                        }
                    },
                    keyframes: {
                        fadeUp: {
                            '0%':   { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.8s ease both',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0a0806; }

        .page-bg {
            background-image:
                linear-gradient(to bottom, rgba(10,8,6,0.75) 0%, rgba(10,8,6,0.92) 100%),
                url('{{ asset("images/BACKGROUND_WEB.png") }}');
            background-size: cover;
            background-position: center top;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .nav-link {
            font-family: 'Cinzel', serif;
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(245,230,200,0.75);
            transition: color 0.25s;
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -3px; left: 0;
            width: 0; height: 1px;
            background: #C9A84C;
            transition: width 0.3s;
        }
        .nav-link:hover { color: #F5E6C8; }
        .nav-link:hover::after { width: 100%; }
        .nav-link.active { color: #C9A84C; }
        .nav-link.active::after { width: 100%; }

        .btn-glass {
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, rgba(201,168,76,0.18), rgba(201,168,76,0.06) 50%, rgba(201,168,76,0.14));
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(201,168,76,0.45);
            color: #F5E6C8;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.7rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.08);
        }
        .btn-glass::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.07), transparent 60%);
            pointer-events: none;
        }
        .btn-glass:hover {
            background: linear-gradient(135deg, rgba(201,168,76,0.35), rgba(201,168,76,0.15) 50%, rgba(201,168,76,0.28));
            border-color: rgba(201,168,76,0.75);
            box-shadow: 0 8px 30px rgba(201,168,76,0.22), inset 0 1px 0 rgba(255,255,255,0.12);
            color: #fff;
        }

        .btn-glass-outline {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(245,230,200,0.85);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.7rem;
            transition: all 0.3s;
        }
        .btn-glass-outline:hover {
            background: rgba(255,255,255,0.09);
            border-color: rgba(255,255,255,0.45);
            color: #fff;
        }

        .card-glass {
            background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
            backdrop-filter: blur(20px) saturate(150%);
            -webkit-backdrop-filter: blur(20px) saturate(150%);
            border: 1px solid rgba(201,168,76,0.2);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.05);
        }

        .section-label {
            font-family: 'Cinzel', serif;
            font-size: 0.6rem;
            letter-spacing: 0.38em;
            text-transform: uppercase;
            color: #C9A84C;
        }

        .divider-gold {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,168,76,0.5) 30%, rgba(201,168,76,0.7) 50%, rgba(201,168,76,0.5) 70%, transparent);
            box-shadow: 0 0 8px rgba(201,168,76,0.45);
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0a0806; }
        ::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.4); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(201,168,76,0.7); }
    </style>
</head>

<body class="page-bg text-zinc-100">

    <!-- ── Navbar ── -->
    <header id="navbar" class="fixed top-0 inset-x-0 z-50 transition-all duration-500" style="background: rgba(10,8,6,0.88); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(201,168,76,0.15);">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-10 h-20 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('landing') }}" class="shrink-0">
                <img src="{{ asset('images/logo-gamatif.png') }}"
                     alt="GAMATIF 2026"
                     class="h-6 w-auto drop-shadow-[0_2px_8px_rgba(201,168,76,0.5)]">
            </a>

            <!-- Center nav -->
            <nav class="hidden md:flex items-center gap-10">
                <a href="{{ route('landing') }}" class="nav-link">Beranda</a>
                <a href="{{ route('landing') }}#about"  class="nav-link">Tentang</a>
                <a href="{{ route('landing') }}#agenda" class="nav-link">Jadwal</a>
                @auth('peserta')
                    <a href="{{ route('peserta.voting_ketua_angkatan') }}" class="nav-link">Voting</a>
                @endauth
                <a href="{{ route('menfess') }}" class="nav-link active">Gamafess</a>
            </nav>

            <!-- Right: auth -->
            @auth('peserta')
            <div class="relative hidden md:block" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-full transition"
                        style="border: 1px solid rgba(201,168,76,0.4); background: rgba(201,168,76,0.1);">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-black shrink-0"
                          style="background: #C9A84C;">
                        {{ strtoupper(substr(Auth::guard('peserta')->user()->nama_lengkap, 0, 2)) }}
                    </span>
                    <span class="text-xs font-cinzel text-gold-300 tracking-wide max-w-[100px] truncate">
                        {{ explode(' ', Auth::guard('peserta')->user()->nama_lengkap)[0] }}
                    </span>
                    <svg class="w-3 h-3 text-gold-400 transition-transform" :class="{ 'rotate-180': open }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition
                     class="absolute right-0 mt-2 w-52 rounded-lg overflow-hidden z-50"
                     style="background: rgba(15,12,9,0.97); border: 1px solid rgba(201,168,76,0.25); box-shadow: 0 16px 40px rgba(0,0,0,0.6);">
                    <div class="px-4 py-3 border-b border-gold-500/15">
                        <p class="font-semibold text-white text-sm">{{ Auth::guard('peserta')->user()->nama_lengkap }}</p>
                        <p class="text-xs text-zinc-500 mt-0.5">NIM: {{ Auth::guard('peserta')->user()->nim }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('peserta.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-zinc-300 hover:text-white hover:bg-white/5 transition">Dashboard</a>
                        <a href="{{ route('peserta.voting_ketua_angkatan') }}" class="flex items-center px-4 py-2.5 text-sm text-zinc-300 hover:text-white hover:bg-white/5 transition">Voting Ketua Angkatan</a>
                        <a href="{{ route('peserta.profil') }}" class="flex items-center px-4 py-2.5 text-sm text-zinc-300 hover:text-white hover:bg-white/5 transition">Profil Saya</a>
                    </div>
                    <div class="border-t border-gold-500/15 py-1">
                        <form method="POST" action="{{ route('peserta.logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-rose-400 hover:text-rose-300 hover:bg-white/5 transition">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('peserta.login') }}" class="btn-glass-outline px-5 py-2.5 rounded-sm">Masuk</a>
                <a href="{{ route('peserta.register') }}" class="btn-glass px-5 py-2.5 rounded-sm">Registrasi</a>
            </div>
            @endauth

            <!-- Mobile hamburger -->
            <button id="mobileMenuBtn" class="md:hidden text-gold-300 p-2" aria-label="Menu">
                <svg id="iconOpen"  class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="iconClose" class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-black/90 backdrop-blur-xl border-t border-gold-500/20 px-6 py-6 space-y-5">
            <a href="{{ route('landing') }}" class="nav-link block">Beranda</a>
            <a href="{{ route('landing') }}#about"  class="nav-link block">Tentang</a>
            <a href="{{ route('landing') }}#agenda" class="nav-link block">Jadwal</a>
            @auth('peserta')
                <a href="{{ route('peserta.voting_ketua_angkatan') }}" class="nav-link block">Voting</a>
            @endauth
            <a href="{{ route('menfess') }}" class="nav-link block active">Gamafess</a>
            <div class="pt-4 flex flex-col gap-3">
                @auth('peserta')
                    <a href="{{ route('peserta.dashboard') }}" class="btn-glass text-center px-5 py-3 rounded-sm">Dashboard</a>
                    <form method="POST" action="{{ route('peserta.logout') }}">
                        @csrf
                        <button type="submit" class="btn-glass-outline w-full text-center px-5 py-3 rounded-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('peserta.login') }}"    class="btn-glass-outline text-center px-5 py-3 rounded-sm">Masuk</a>
                    <a href="{{ route('peserta.register') }}" class="btn-glass text-center px-5 py-3 rounded-sm">Registrasi</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ── Main Content ── -->
    <main class="pt-32 pb-20 px-6 lg:px-10">
        <div class="max-w-screen-xl mx-auto">

            {{-- Header --}}
            <div class="text-center mb-12 animate-fade-up">
                <p class="font-cinzel text-[0.65rem] tracking-[0.45em] uppercase text-gold-500 mb-3">Gamatif Confess</p>
                <h1 class="font-cinzel text-4xl sm:text-5xl font-bold text-white mb-4">Gamafess</h1>
                <p class="text-zinc-400 text-sm max-w-sm mx-auto">Klik salah satu kartu untuk post di story Instagram!</p>

                <div class="mt-6">
                    <button onclick="document.getElementById('modalMenfess').classList.remove('hidden')"
                            class="btn-glass inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Menfess Baru
                    </button>
                </div>
            </div>

            {{-- Grid cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @php
                    $cardSkins = [
                        // Amber Dune
                        ['bg' => '#2C1F08', 'border' => '#6B4A1A', 'accent' => '#E8A838'],
                        // Burnt Sienna
                        ['bg' => '#2A1008', 'border' => '#7A3018', 'accent' => '#D4633A'],
                        // Desert Sage
                        ['bg' => '#0E1C10', 'border' => '#2E5C30', 'accent' => '#72A857'],
                        // Sandstone
                        ['bg' => '#221C0E', 'border' => '#5C5020', 'accent' => '#C8A84A'],
                        // Copper
                        ['bg' => '#241408', 'border' => '#6E3A18', 'accent' => '#C07840'],
                        // Oasis Teal
                        ['bg' => '#081C1A', 'border' => '#1E5C52', 'accent' => '#3EA898'],
                    ];
                @endphp

                @forelse($menfesses as $i => $mf)
                    @php $skin = $cardSkins[$i % count($cardSkins)]; @endphp
                    <div class="menfess-card group relative rounded-2xl p-6 cursor-pointer reveal
                                transition-all duration-300 hover:-translate-y-1 hover:scale-[1.02]"
                         style="background: {{ $skin['bg'] }};
                                border: 1px solid {{ $skin['border'] }};
                                box-shadow: 0 4px 20px rgba(0,0,0,0.5);
                                transition-delay: {{ ($i % 6) * 60 }}ms"
                         data-from="{{ $mf->from }}"
                         data-to="{{ $mf->to }}"
                         data-message="{{ $mf->message }}"
                         data-accent="{{ $skin['accent'] }}">

                        <div class="mb-4">
                            <span class="text-xs text-zinc-500">Untuk: </span>
                            <span class="text-sm font-bold" style="color: {{ $skin['accent'] }}">{{ $mf->to }}</span>
                        </div>

                        <p class="text-sm text-zinc-300 leading-relaxed mb-5 line-clamp-5">
                            "{{ $mf->message }}"
                        </p>

                        <p class="text-xs text-zinc-500 text-right italic">— {{ $mf->from }}</p>

                        {{-- Hover overlay --}}
                        <div class="absolute inset-0 rounded-2xl flex flex-col items-center justify-center gap-3
                                    bg-black/75 backdrop-blur-sm
                                    opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                             onclick="event.stopPropagation()">
                            <button type="button"
                                    onclick="shareCardToIG(this.closest('.menfess-card'))"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold"
                                    style="background: linear-gradient(135deg, #a855f7, #ec4899); color:#fff;">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                                Story-kan
                            </button>
                            <button type="button"
                                    onclick="(function(card){ populateExport(card.dataset.from, card.dataset.to, card.dataset.message, card.dataset.accent); downloadMenfessImg(card.dataset.to); })(this.closest('.menfess-card'))"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold border"
                                    style="background: rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.25); color:#e4e4e7;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Unduh
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-20">
                        <p class="text-zinc-600 text-sm font-cinzel tracking-widest uppercase">
                            Belum ada menfess. Jadilah yang pertama!
                        </p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    {{-- Hidden story export container --}}
    <div id="storyExportContainer"
         class="fixed top-0 left-0 overflow-hidden pointer-events-none"
         style="width:450px;height:800px;opacity:0;z-index:-10;">
        <div id="storyExportBg" class="w-full h-full flex items-center justify-center p-6"
             style="background: linear-gradient(to bottom, #0a0806, #1a1208, #0f0c09);">
            <div id="storyExportCard" class="w-full flex flex-col rounded-2xl p-8 text-center"
                 style="background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02));
                        border: 1px solid rgba(201,168,76,0.4);
                        box-shadow: 0 8px 32px rgba(0,0,0,0.6);">
                <div class="flex-grow">
                    <p style="color:rgba(161,161,170,0.7);font-size:14px;margin-bottom:6px;">Pesan untuk</p>
                    <h2 id="export-to" style="font-size:28px;font-weight:700;color:#E8D49E;margin:6px 0 16px;word-break:break-word;font-family:serif;"></h2>
                    <p id="export-message" style="font-size:18px;color:#e4e4e7;line-height:1.7;margin:16px 0 24px;word-break:break-word;font-style:italic;font-family:serif;"></p>
                    <p id="export-from" style="font-size:16px;color:rgba(161,161,170,0.7);font-weight:600;word-break:break-word;"></p>
                </div>
                <div style="margin-top:24px;padding-top:16px;border-top:1px solid rgba(201,168,76,0.25);">
                    <p style="font-family:serif;font-size:24px;color:#C9A84C;font-weight:700;letter-spacing:4px;">GAMATIF 2026</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal form buat menfess --}}
    <div id="modalMenfess"
         class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4"
         style="background: rgba(0,0,0,0.75); backdrop-filter: blur(8px);"
         onclick="if(event.target===this) this.classList.add('hidden')">
        <div class="w-full max-w-md card-glass rounded-2xl p-8 relative">
            <button onclick="document.getElementById('modalMenfess').classList.add('hidden')"
                    class="absolute top-4 right-4 text-zinc-500 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <p class="font-cinzel text-[0.62rem] tracking-[0.4em] uppercase text-gold-500 mb-2">Buat Menfess</p>
            <h3 class="font-cinzel text-2xl font-bold text-white mb-6">Tulis Pesanmu</h3>

            <form action="{{ route('kirim_menfess') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="font-cinzel text-[0.6rem] tracking-widest uppercase text-gold-500/80 mb-2 block">From</label>
                    <input type="text" name="from" required maxlength="100"
                           placeholder="Nama kamu (boleh samaran)"
                           class="w-full bg-white/5 border border-gold-500/20 rounded-sm px-4 py-2.5
                                  text-sm text-zinc-200 placeholder-zinc-600
                                  focus:outline-none focus:border-gold-500/50 transition">
                </div>
                <div>
                    <label class="font-cinzel text-[0.6rem] tracking-widest uppercase text-gold-500/80 mb-2 block">To</label>
                    <input type="text" name="to" required maxlength="100"
                           placeholder="Ditujukan ke siapa?"
                           class="w-full bg-white/5 border border-gold-500/20 rounded-sm px-4 py-2.5
                                  text-sm text-zinc-200 placeholder-zinc-600
                                  focus:outline-none focus:border-gold-500/50 transition">
                </div>
                <div>
                    <label class="font-cinzel text-[0.6rem] tracking-widest uppercase text-gold-500/80 mb-2 block">Pesan</label>
                    <textarea name="message" rows="4" required maxlength="500"
                              placeholder="Tulis pesanmu di sini..."
                              class="w-full bg-white/5 border border-gold-500/20 rounded-sm px-4 py-2.5
                                     text-sm text-zinc-200 placeholder-zinc-600
                                     focus:outline-none focus:border-gold-500/50 transition resize-none"></textarea>
                </div>
                <button type="submit" class="btn-glass w-full py-3 rounded-sm">
                    Kirim Menfess
                </button>
            </form>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="border-t border-gold-500/15 py-10 px-6 lg:px-10">
        <div class="max-w-screen-xl mx-auto flex flex-col items-center gap-6">
            <div class="flex items-center gap-6 justify-center">
                <img src="{{ asset('images/LOGO UNIKOM.png') }}" alt="UNIKOM" class="h-14 w-auto"
                     style="filter: drop-shadow(0 0 12px rgba(201,168,76,0.5));">
                <img src="{{ asset('images/LOGO HMIF.png') }}" alt="HMIF" class="h-14 w-auto"
                     style="filter: drop-shadow(0 0 12px rgba(201,168,76,0.5));">
                <img src="{{ asset('images/LOGO DHINAKARA.png') }}" alt="Dhinakara" class="h-14 w-auto"
                     style="filter: drop-shadow(0 0 12px rgba(201,168,76,0.5));">
            </div>
            <div class="flex flex-wrap justify-center gap-6">
                @foreach($sosmed as $sm)
                    <a href="{{ $sm->url }}" target="_blank"
                       class="font-cinzel text-[0.6rem] tracking-[0.3em] uppercase text-zinc-500 hover:text-gold-400 transition">
                        {{ $sm->nama }}
                    </a>
                @endforeach
            </div>
            <div class="divider-gold w-full max-w-3xl"></div>
            <p class="text-xs text-zinc-600 tracking-widest">Gamatif Expedition &copy; 2026. All rights reserved.</p>
        </div>
    </footer>

    <script>
        /* Mobile menu */
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu    = document.getElementById('mobileMenu');
        const iconOpen      = document.getElementById('iconOpen');
        const iconClose     = document.getElementById('iconClose');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });

        /* Scroll reveal */
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('visible'); revealObserver.unobserve(e.target); }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

        /* ── Menfess image functions ── */
        function populateExport(from, to, message, accent) {
            document.getElementById('export-to').textContent      = to;
            document.getElementById('export-from').textContent    = '\u2014 ' + from;
            document.getElementById('export-message').textContent = '\u201c' + message + '\u201d';
            document.getElementById('export-to').style.color      = accent || '#E8D49E';
            document.getElementById('storyExportCard').style.borderColor = (accent || '#C9A84C') + '66';
        }

        async function generateMenfessImage(outputType = 'png') {
            const node = document.getElementById('storyExportContainer');
            node.style.opacity = '1';
            node.style.zIndex  = '9999';
            await new Promise(r => setTimeout(r, 200));
            try {
                const options = { quality: 1.0, pixelRatio: 2, backgroundColor: '#0a0806' };
                const result  = outputType === 'blob'
                    ? await htmlToImage.toBlob(node, options)
                    : await htmlToImage.toPng(node, options);
                return result;
            } catch(err) {
                console.error('Gagal membuat gambar:', err);
                return null;
            } finally {
                node.style.opacity = '0';
                node.style.zIndex  = '-10';
            }
        }

        async function downloadMenfessImg(to) {
            const dataUrl = await generateMenfessImage('png');
            if (!dataUrl) { alert('Gagal membuat gambar.'); return; }
            const link    = document.createElement('a');
            link.href     = dataUrl;
            link.download = 'story-gamatif2026-untuk-' + to.replace(/\s/g, '-') + '.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        async function shareMenfessToStory(to) {
            const blob = await generateMenfessImage('blob');
            if (!blob) { alert('Gagal membuat gambar.'); return; }
            const fileName = 'story-gamatif2026-untuk-' + to.replace(/\s/g, '-') + '.png';
            const file     = new File([blob], fileName, { type: 'image/png' });
            if (navigator.canShare && navigator.canShare({ files: [file] })) {
                try {
                    await navigator.share({ files: [file], title: 'Menfess untuk ' + to, text: 'Lihat menfess ini dari GAMATIF 2026!' });
                } catch(err) { console.error('Gagal share:', err); }
            } else {
                alert('Fitur share tersedia di HP. Gambar akan diunduh sebagai gantinya.');
                downloadMenfessImg(to);
            }
        }

        function shareCardToIG(card) {
            populateExport(card.dataset.from, card.dataset.to, card.dataset.message, card.dataset.accent || '#E8D49E');
            shareMenfessToStory(card.dataset.to);
        }

        @if(session('menfess_success'))
            Swal.fire({
                icon: 'success',
                title: 'Menfess terkirim!',
                text: @js(session('menfess_success')),
                confirmButtonText: 'Oke',
                confirmButtonColor: '#C9A84C',
                background: '#17110b',
                color: '#F5E6C8'
            });
        @endif
    </script>

</body>
</html>
