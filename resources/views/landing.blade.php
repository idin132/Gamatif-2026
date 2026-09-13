<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pengaturan->nama_kegiatan ?? 'GAMATIF 2026' }} - Gamatif Expedition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    <script src="https://unpkg.com/html-to-image@1.11.11/dist/html-to-image.js"></script>
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
                            '0%':   { opacity: '0', transform: 'translateY(40px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%':   { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        floatSlow: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%':      { transform: 'translateY(-18px)' },
                        },
                        slideFade: {
                            '0%':   { opacity: '0', transform: 'translateX(-30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        glow: {
                            '0%, 100%': { 'box-shadow': '0 0 20px rgba(201,168,76,0.3)' },
                            '50%':      { 'box-shadow': '0 0 40px rgba(201,168,76,0.7)' },
                        },
                        sandDrift: {
                            '0%':   { backgroundPosition: '0% 50%' },
                            '50%':  { backgroundPosition: '100% 50%' },
                            '100%': { backgroundPosition: '0% 50%' },
                        },
                    },
                    animation: {
                        'fade-up':    'fadeUp 0.9s ease both',
                        'fade-up-d1': 'fadeUp 0.9s 0.2s ease both',
                        'fade-up-d2': 'fadeUp 0.9s 0.4s ease both',
                        'fade-up-d3': 'fadeUp 0.9s 0.6s ease both',
                        'fade-in':    'fadeIn 1.2s ease both',
                        'float':      'floatSlow 6s ease-in-out infinite',
                        'float-d':    'floatSlow 6s 1.5s ease-in-out infinite',
                        'slide-fade': 'slideFade 1s 0.3s ease both',
                        'glow':       'glow 3s ease-in-out infinite',
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

        /* ─── Glass Button ─────────────────────────────────────────── */
        .btn-glass {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg,
                rgba(201,168,76,0.18) 0%,
                rgba(201,168,76,0.06) 50%,
                rgba(201,168,76,0.14) 100%);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(201,168,76,0.45);
            color: #F5E6C8;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.7rem;
            transition: all 0.3s ease;
            box-shadow:
                0 4px 15px rgba(0,0,0,0.3),
                inset 0 1px 0 rgba(255,255,255,0.1);
        }
        .btn-glass::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                rgba(255,255,255,0.08) 0%,
                transparent 60%);
            pointer-events: none;
        }
        .btn-glass:hover {
            background: linear-gradient(135deg,
                rgba(201,168,76,0.35) 0%,
                rgba(201,168,76,0.15) 50%,
                rgba(201,168,76,0.28) 100%);
            border-color: rgba(201,168,76,0.8);
            box-shadow:
                0 8px 30px rgba(201,168,76,0.25),
                0 0 0 1px rgba(201,168,76,0.3),
                inset 0 1px 0 rgba(255,255,255,0.15);
            color: #fff;
        }

        /* ─── Glass Button Secondary (outline only) ─────────────────── */
        .btn-glass-outline {
            position: relative;
            overflow: hidden;
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(245,230,200,0.85);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.7rem;
            transition: all 0.3s ease;
        }
        .btn-glass-outline:hover {
            background: rgba(255,255,255,0.10);
            border-color: rgba(255,255,255,0.45);
            color: #fff;
        }

        /* ─── Nav link ──────────────────────────────────────────────── */
        .nav-link {
            font-family: 'Cinzel', serif;
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(245,230,200,0.75);
            transition: color 0.25s ease;
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -3px; left: 0;
            width: 0; height: 1px;
            background: #C9A84C;
            transition: width 0.3s ease;
        }
        .nav-link:hover { color: #F5E6C8; }
        .nav-link:hover::after { width: 100%; }

        /* ─── Hero BG ───────────────────────────────────────────────── */
        .hero-bg {
            background-image:
                linear-gradient(to bottom,
                    rgba(10,8,6,0.35) 0%,
                    rgba(10,8,6,0.15) 40%,
                    rgba(10,8,6,0.75) 85%,
                    rgba(10,8,6,1)    100%),
                url('{{ asset("images/BACKGROUND_WEB.png") }}');
            background-size: cover;
            background-position: center top;
            background-attachment: fixed;
        }

        /* ─── Section divider glow line ─────────────────────────────── */
        .divider-gold {
            height: 1px;
            background: linear-gradient(90deg,
                transparent 0%,
                rgba(201,168,76,0.4) 30%,
                rgba(201,168,76,0.7) 50%,
                rgba(201,168,76,0.4) 70%,
                transparent 100%);
            box-shadow: 0 0 8px rgba(201,168,76,0.45);
        }

        /* ─── Card glass ────────────────────────────────────────────── */
        .card-glass {
            background: linear-gradient(135deg,
                rgba(255,255,255,0.06) 0%,
                rgba(255,255,255,0.02) 100%);
            backdrop-filter: blur(20px) saturate(160%);
            -webkit-backdrop-filter: blur(20px) saturate(160%);
            border: 1px solid rgba(201,168,76,0.2);
            box-shadow:
                0 8px 32px rgba(0,0,0,0.4),
                inset 0 1px 0 rgba(255,255,255,0.06);
        }
        .card-glass:hover {
            border-color: rgba(201,168,76,0.4);
            box-shadow:
                0 12px 40px rgba(0,0,0,0.5),
                0 0 20px rgba(201,168,76,0.08),
                inset 0 1px 0 rgba(255,255,255,0.08);
        }

        /* ─── Scroll reveal ─────────────────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ─── Sand particle overlay ─────────────────────────────────── */
        .sand-overlay {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 200px;
            pointer-events: none;
        }

        /* ─── Custom scrollbar ──────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0a0806; }
        ::-webkit-scrollbar-thumb {
            background: rgba(201,168,76,0.4);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover { background: rgba(201,168,76,0.7); }
    </style>
</head>
<body class="text-zinc-100 selection:bg-gold-500 selection:text-black">

    <!-- ══════════════════════════════════════════════════════════════
         TOP NAVBAR  –  Dune-style: logo left · nav center · CTA right
    ══════════════════════════════════════════════════════════════════ -->
    <header id="navbar"
            class="fixed top-0 inset-x-0 z-50 transition-all duration-500"
            style="background: transparent;">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-10 h-20 flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="shrink-0">
                <img src="{{ asset('images/logo-gamatif.png') }}"
                     alt="GAMATIF 2026"
                     class="h-6 w-auto drop-shadow-[0_2px_8px_rgba(201,168,76,0.5)]">
            </a>

            <!-- Center nav links (Dune style) -->
            <nav class="hidden md:flex items-center gap-10">
                <a href="#beranda" class="nav-link">Beranda</a>
                <a href="#about"  class="nav-link">Tentang</a>
                <a href="#agenda" class="nav-link">Jadwal</a>
                <a href="{{ route('menfess') }}" class="nav-link">Gamafess</a>
            </nav>

            <!-- Right CTA -->
            @auth('peserta')
            {{-- Sudah login: avatar dropdown --}}
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
                     style="background: rgba(15,12,9,0.97); border: 1px solid rgba(201,168,76,0.25);
                            box-shadow: 0 16px 40px rgba(0,0,0,0.6);">
                    <div class="px-4 py-3 border-b border-gold-500/15">
                        <p class="font-semibold text-white text-sm">{{ Auth::guard('peserta')->user()->nama_lengkap }}</p>
                        <p class="text-xs text-zinc-500 mt-0.5">NIM: {{ Auth::guard('peserta')->user()->nim }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('peserta.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-zinc-300 hover:text-white hover:bg-white/5 transition">Dashboard</a>
                        <a href="{{ route('peserta.profil') }}" class="flex items-center px-4 py-2.5 text-sm text-zinc-300 hover:text-white hover:bg-white/5 transition">Profil Saya</a>
                    </div>
                    <div class="border-t border-gold-500/15 py-1">
                        <form method="POST" action="{{ route('peserta.logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-rose-400 hover:text-rose-300 hover:bg-white/5 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            {{-- Belum login: tombol Masuk & Registrasi --}}
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('peserta.login') }}"
                   class="btn-glass-outline px-5 py-2.5 rounded-sm">
                    Masuk
                </a>
                <a href="{{ route('peserta.register') }}"
                   class="btn-glass px-5 py-2.5 rounded-sm">
                    Registrasi
                </a>
            </div>
            @endauth

            <!-- Mobile hamburger -->
            <button id="mobileMenuBtn"
                    class="md:hidden text-gold-300 p-2"
                    aria-label="Menu">
                <svg id="iconOpen"  class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg id="iconClose" class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div id="mobileMenu"
             class="hidden md:hidden bg-black/90 backdrop-blur-xl border-t border-gold-500/20 px-6 py-6 space-y-5">
            <a href="#beranda"  class="nav-link block">Beranda</a>
            <a href="#about"   class="nav-link block">Tentang</a>
            <a href="#agenda"  class="nav-link block">Jadwal</a>
            <a href="{{ route('menfess') }}" class="nav-link block">Gamafess</a>
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

    <!-- ══════════════════════════════════════════════════════════════
         HERO SECTION – grid 2 kolom: teks kiri · maskot kanan
         (layout mengikuti LandingSection.vue dari gamatif-main)
    ══════════════════════════════════════════════════════════════════ -->
    <section id="beranda" class="hero-bg relative min-h-screen overflow-hidden">

        <!-- noise grain overlay -->
        <div class="sand-overlay absolute inset-0 z-0"></div>

        <!-- Grid container: teks kiri, maskot kanan -->
        <div class="relative z-10 max-w-screen-xl mx-auto px-6 lg:px-10
                    pt-32 sm:pt-36 pb-24
                    grid grid-cols-1 md:grid-cols-2 items-center gap-10 min-h-screen">

            <!-- Kiri: teks -->
            <div class="text-center md:text-left">
                <p class="animate-fade-up font-cinzel text-[0.55rem] sm:text-[0.65rem] tracking-[0.45em] uppercase
                           text-gold-400 mb-5 drop-shadow-[0_2px_6px_rgba(0,0,0,0.8)]">
                    Informatics Expedition 2026
                </p>

                <h1 class="animate-fade-up-d1 font-cinzel font-black uppercase
                            text-[clamp(0.95rem,4.8vw,3.5rem)]
                            text-white leading-tight tracking-tight
                            drop-shadow-[0_6px_20px_rgba(0,0,0,0.7)]">
                    Selamat Datang<br>
                    <span class="text-gold-400 drop-shadow-[0_4px_24px_rgba(201,168,76,0.6)]">
                        di Teknik Informatika
                    </span>
                </h1>

                <p class="animate-fade-up-d2 mt-6 text-xs sm:text-base text-white/90
                           max-w-lg leading-relaxed font-light tracking-wide
                           mx-auto md:mx-0">
                    Sambut perjalanan orientasi mahasiswa baru. Tentukan House&nbsp;Anda,
                    pelajari buku panduan, dan pantau seluruh agenda&nbsp;kegiatan.
                </p>

                <div class="animate-fade-up-d3 mt-10 flex flex-wrap items-center gap-3 sm:gap-4
                             justify-center md:justify-start">
                    <a href="#about"
                       class="btn-glass px-6 sm:px-8 py-3 sm:py-3.5 rounded-sm inline-flex items-center gap-2 text-xs sm:text-sm">
                        Mulai Jelajahi
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                    @if($pengaturan?->buku_saku)
                        <a href="{{ asset('storage/' . $pengaturan->buku_saku) }}" target="_blank"
                           class="btn-glass-outline px-6 sm:px-8 py-3 sm:py-3.5 rounded-sm text-xs sm:text-sm">
                            Unduh Buku Panduan
                        </a>
                    @endif
                </div>
            </div>

            <!-- Kanan: maskot -->
            <div class="flex justify-center md:justify-end">
                <img src="{{ asset('images/maskot.png') }}"
                     alt="Maskot GAMATIF 2026"
                     class="relative h-auto max-h-60 sm:max-h-96 w-auto object-contain animate-float"
                     style="filter: drop-shadow(0 0 40px rgba(232,212,158,0.3)) drop-shadow(0 20px 60px rgba(232,212,158,0.15));">
            </div>

        </div>

        <!-- bottom fade to body -->
        <div class="absolute bottom-0 inset-x-0 h-24 bg-gradient-to-t from-[#0a0806] to-transparent z-20 pointer-events-none"></div>
    </section>

    <!-- ══════════════════════════════════════════════════════════════
         TENTANG / ABOUT SECTION
         (layout: text center + 3 cards — mengikuti AboutSection.vue)
    ══════════════════════════════════════════════════════════════════ -->
    <section id="about" class="py-20 sm:py-28 px-6 lg:px-10">
        <div class="max-w-screen-xl mx-auto">

            <!-- Header center -->
            <div class="max-w-4xl mx-auto text-center mb-8 md:mb-14 reveal">
                <h2 class="font-cinzel text-2xl md:text-3xl lg:text-4xl font-extrabold tracking-tight text-white mb-3 md:mb-4">
                    Tentang GAMATIF 2026
                </h2>
                <p class="text-sm md:text-lg text-zinc-400">
                    Sebuah wadah untuk menyambut, merangkul, dan menginspirasi
                    generasi baru pemimpin teknologi di Teknik Informatika.
                </p>
            </div>

            <!-- 3 Cards grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8 text-left">

                <!-- Card 1: Kebersamaan -->
                <div class="card-glass p-4 md:p-6 rounded-lg reveal group transition-transform hover:scale-105"
                     style="transition-delay: 0ms">
                    <div class="flex items-center justify-center h-9 w-9 md:h-12 md:w-12 rounded-md
                                bg-gold-500/15 border border-gold-500/30 text-gold-400 mb-3 md:mb-4
                                group-hover:shadow-[0_0_15px_3px_rgba(201,168,76,0.35)] transition">
                        <svg class="h-4 w-4 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-cinzel text-base md:text-xl font-bold text-white mb-1.5 md:mb-2">Kebersamaan</h3>
                    <p class="text-sm md:text-base text-zinc-400 leading-relaxed">
                        Membangun solidaritas dan jaringan sosial antar mahasiswa baru, rekan mahasiswa antar angkatan,
                        dan dosen serta civitas akademik untuk menciptakan lingkungan kampus yang nyaman dan suportif.
                    </p>
                </div>

                <!-- Card 2: Kepemimpinan -->
                <div class="card-glass p-4 md:p-6 rounded-lg reveal group transition-transform hover:scale-105"
                     style="transition-delay: 80ms">
                    <div class="flex items-center justify-center h-9 w-9 md:h-12 md:w-12 rounded-md
                                bg-gold-500/15 border border-gold-500/30 text-gold-400 mb-3 md:mb-4
                                group-hover:shadow-[0_0_15px_3px_rgba(201,168,76,0.35)] transition">
                        <svg class="h-4 w-4 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="font-cinzel text-base md:text-xl font-bold text-white mb-1.5 md:mb-2">Kepemimpinan</h3>
                    <p class="text-sm md:text-base text-zinc-400 leading-relaxed">
                        Mendorong kemampuan komunikasi, kerja sama, dan pengambilan keputusan melalui aktivitas
                        kelompok yang melatih strategi, problem-solving, dan jiwa kepemimpinan.
                    </p>
                </div>

                <!-- Card 3: Pengembangan Diri -->
                <div class="card-glass p-4 md:p-6 rounded-lg reveal group transition-transform hover:scale-105"
                     style="transition-delay: 160ms">
                    <div class="flex items-center justify-center h-9 w-9 md:h-12 md:w-12 rounded-md
                                bg-gold-500/15 border border-gold-500/30 text-gold-400 mb-3 md:mb-4
                                group-hover:shadow-[0_0_15px_3px_rgba(201,168,76,0.35)] transition">
                        <svg class="h-4 w-4 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-cinzel text-base md:text-xl font-bold text-white mb-1.5 md:mb-2">Pengembangan Diri</h3>
                    <p class="text-sm md:text-base text-zinc-400 leading-relaxed">
                        Memberikan ruang eksplorasi potensi, mengenalkan budaya akademik dan organisasi,
                        serta menanamkan nilai kemandirian dan tanggung jawab untuk menghadapi dunia perkuliahan.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- ══════════════════════════════════════════════════════════════
         AGENDA / JADWAL
    ══════════════════════════════════════════════════════════════════ -->
    <section id="agenda" class="py-24 px-6 lg:px-10">
        <div class="max-w-screen-xl mx-auto">

            <div class="text-center mb-16 reveal">
                <p class="font-cinzel text-[0.65rem] tracking-[0.45em] uppercase text-gold-500 mb-3">
                    Rundown Acara
                </p>
                <h2 class="font-cinzel text-3xl sm:text-4xl font-bold text-white">
                    Jadwal Agenda Kegiatan
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($jadwals as $i => $jadwal)
                    <div class="card-glass rounded-lg p-7 transition-all duration-300 reveal group"
                         style="transition-delay: {{ $i * 80 }}ms">

                        <div class="flex items-center justify-between mb-5">
                            <span class="font-cinzel text-[0.6rem] tracking-[0.3em] uppercase
                                         text-gold-500 bg-gold-500/10 border border-gold-500/20
                                         px-3 py-1.5 rounded-sm">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}
                            </span>
                            <span class="w-2 h-2 rounded-full bg-gold-500 opacity-60 group-hover:opacity-100 transition"></span>
                        </div>

                        <h4 class="font-cinzel text-lg font-semibold text-white mb-2 leading-snug">
                            {{ $jadwal->nama }}
                        </h4>

                        <p class="text-xs tracking-widest text-gold-400/70 font-mono mt-3">
                            {{ substr($jadwal->waktu_mulai, 0, 5) }} – {{ substr($jadwal->waktu_selesai, 0, 5) }} WIB
                        </p>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-zinc-500 text-sm tracking-widest uppercase font-cinzel">
                        Belum ada agenda yang dirilis.
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ══════════════════════════════════════════════════════════════
         CALON KETUA ANGKATAN
    ══════════════════════════════════════════════════════════════════ -->
    @if($calonKetua->count() > 0)
    <section id="calon" class="py-24 px-6 lg:px-10">
        <div class="max-w-screen-xl mx-auto">

            <div class="divider-gold mb-20 mx-auto max-w-3xl reveal"></div>

            <div class="text-center mb-16 reveal">
                <p class="font-cinzel text-[0.65rem] tracking-[0.45em] uppercase text-gold-500 mb-3">
                    Kandidat
                </p>
                <h2 class="font-cinzel text-3xl sm:text-4xl font-bold text-white">
                    Calon Ketua Angkatan
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($calonKetua as $i => $calon)
                    <div class="card-glass rounded-lg p-8 flex flex-col items-center text-center
                                transition-all duration-300 reveal"
                         style="transition-delay: {{ $i * 100 }}ms">

                        <div class="relative mb-6">
                            <div class="absolute inset-0 rounded-full bg-gold-500/20 blur-xl animate-glow"></div>
                            <img src="{{ asset('storage/' . $calon->foto) }}"
                                 alt="{{ $calon->nama }}"
                                 class="relative w-28 h-28 rounded-full object-cover
                                        border-2 border-gold-500/60
                                        shadow-[0_0_30px_rgba(201,168,76,0.3)]">
                        </div>

                        <h4 class="font-cinzel text-lg font-semibold text-white">{{ $calon->nama }}</h4>
                        <p class="font-mono text-xs text-gold-400 mt-1 mb-5">
                            {{ $calon->nim }} · {{ $calon->kelas }}
                        </p>

                        <div class="w-full bg-black/30 border border-gold-500/15 p-5 rounded-sm text-left text-xs space-y-3">
                            <p>
                                <span class="font-cinzel text-[0.65rem] tracking-widest uppercase text-gold-500">Visi</span><br>
                                <span class="text-zinc-400 mt-1 block leading-relaxed">{{ $calon->visi }}</span>
                            </p>
                            <div class="h-px bg-gold-500/10"></div>
                            <p>
                                <span class="font-cinzel text-[0.65rem] tracking-widest uppercase text-gold-500">Misi</span><br>
                                <span class="text-zinc-400 mt-1 block leading-relaxed">{{ $calon->misi }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="divider-gold mt-20 mx-auto max-w-3xl reveal"></div>
        </div>
    </section>
    @endif
    <!-- ══════════════════════════════════════════════════════════════
         KRITIK & SARAN SECTION
    ══════════════════════════════════════════════════════════════════ -->
    <section id="kontak" class="relative pt-20 sm:pt-24 mt-4 py-20 px-6 lg:px-10
                                 rounded-t-[3rem] sm:rounded-t-[5rem]"
             style="background-image: linear-gradient(to bottom, rgba(10,8,6,0.82) 0%, rgba(10,8,6,0.88) 100%), url('{{ asset('images/BACKGROUND_WEB.png') }}'); background-size: cover; background-position: center center; background-attachment: fixed;
                    border-top:1px solid rgba(201,168,76,0.12);">
        <div class="max-w-screen-xl mx-auto">

            <div class="max-w-xl mx-auto reveal">
                <div class="text-center mb-8">
                    <p class="font-cinzel text-[0.65rem] tracking-[0.45em] uppercase text-gold-500 mb-3">Suara Anda</p>
                    <h2 class="font-cinzel text-3xl sm:text-4xl font-bold text-white">Kritik &amp; Saran</h2>
                    <p class="mt-3 text-zinc-400 text-sm">Beri masukan demi kelancaran kegiatan orientasi.</p>
                </div>

                <div class="card-glass rounded-lg p-8">
                    <form action="{{ route('kirim_kritik_saran') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="font-cinzel text-[0.6rem] tracking-widest uppercase text-gold-500/80 mb-2 block">
                                Nama <span class="text-zinc-600 normal-case font-sans font-normal">(Opsional)</span>
                            </label>
                            <input type="text" name="nama" placeholder="Anonim"
                                   class="w-full bg-white/5 border border-gold-500/20 rounded-sm px-4 py-3
                                          text-sm text-zinc-200 placeholder-zinc-600
                                          focus:outline-none focus:border-gold-500/50 transition backdrop-blur-sm">
                        </div>
                        <div>
                            <label class="font-cinzel text-[0.6rem] tracking-widest uppercase text-gold-500/80 mb-2 block">
                                Pesan Masukan
                            </label>
                            <textarea name="pesan" rows="5" required
                                      placeholder="Tulis masukan Anda..."
                                      class="w-full bg-white/5 border border-gold-500/20 rounded-sm px-4 py-3
                                             text-sm text-zinc-200 placeholder-zinc-600
                                             focus:outline-none focus:border-gold-500/50 transition resize-none backdrop-blur-sm"></textarea>
                        </div>
                        <button type="submit" class="btn-glass w-full py-3.5 rounded-sm">
                            Kirim Masukan
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <footer class="border-t border-gold-500/15 mt-16 pt-10 px-0">
            <div class="max-w-screen-xl mx-auto">
                <div class="flex flex-col items-center gap-6">
                    <div class="flex items-center gap-6 justify-center">
                        <img src="{{ asset('images/LOGO UNIKOM.png') }}" alt="UNIKOM"
                             class="h-14 w-auto"
                             style="filter: drop-shadow(0 0 12px rgba(201,168,76,0.5));">
                        <img src="{{ asset('images/LOGO HMIF.png') }}" alt="HMIF"
                             class="h-14 w-auto"
                             style="filter: drop-shadow(0 0 12px rgba(201,168,76,0.5));">
                        <img src="{{ asset('images/LOGO DHINAKARA.png') }}" alt="Dhinakara"
                             class="h-14 w-auto"
                             style="filter: drop-shadow(0 0 12px rgba(201,168,76,0.5));">
                    </div>
                    <div class="flex flex-wrap justify-center gap-6">
                        @foreach($sosmed as $sm)
                            <a href="{{ $sm->url }}" target="_blank"
                               class="font-cinzel text-[0.6rem] tracking-[0.3em] uppercase
                                      text-zinc-500 hover:text-gold-400 transition">
                                {{ $sm->nama }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="divider-gold my-6"></div>
                <p class="text-xs text-zinc-600 text-center tracking-widest">
                    Gamatif Expedition &copy; 2026. All rights reserved.
                </p>
            </div>
        </footer>

    </section>

    <!-- ══════════════════════════════════════════════════════════════
         SCRIPTS
    ══════════════════════════════════════════════════════════════════ -->
    <script>
        /* ── Navbar scroll ── */
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 60) {
                navbar.style.background    = 'rgba(10,8,6,0.88)';
                navbar.style.backdropFilter = 'blur(20px) saturate(180%)';
                navbar.style.borderBottom  = '1px solid rgba(201,168,76,0.15)';
            } else {
                navbar.style.background    = 'transparent';
                navbar.style.backdropFilter = 'none';
                navbar.style.borderBottom  = 'none';
            }
        }, { passive: true });

        /* ── Mobile menu ── */
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu    = document.getElementById('mobileMenu');
        const iconOpen      = document.getElementById('iconOpen');
        const iconClose     = document.getElementById('iconClose');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });
        mobileMenu.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            });
        });

        /* ── Scroll reveal ── */
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    revealObserver.unobserve(e.target);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
        function wrapText(ctx, text, maxWidth)  { /* unused */ }

        @if(session('kritik_saran_success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @js(session('kritik_saran_success')),
                confirmButtonText: 'Oke',
                confirmButtonColor: '#C9A84C',
                background: '#17110b',
                color: '#F5E6C8'
            });
        @endif
    </script>

</body>
</html>