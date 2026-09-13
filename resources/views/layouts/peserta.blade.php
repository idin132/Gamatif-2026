<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GAMATIF 2026 - Portal Peserta')</title>

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        cinzel: ['Cinzel', 'serif'],
                        inter:  ['Inter', 'sans-serif'],
                    },
                    colors: {
                        gold: {
                            300: '#F5E6C8',
                            400: '#E8D49E',
                            500: '#C9A84C',
                            600: '#A67C2A',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0a0806; }

        /* ── Background ── */
        .page-bg {
            background-image:
                linear-gradient(to bottom, rgba(10,8,6,0.72) 0%, rgba(10,8,6,0.88) 100%),
                url('/images/BACKGROUND_WEB.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* ── Nav link ── */
        .nav-link {
            font-family: 'Cinzel', serif;
            font-size: 0.68rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(245,230,200,0.7);
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

        /* ── Glass button ── */
        .btn-glass {
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, rgba(201,168,76,0.18), rgba(201,168,76,0.06) 50%, rgba(201,168,76,0.14));
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(201,168,76,0.45);
            color: #F5E6C8;
            letter-spacing: 0.1em;
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

        /* ── Outline glass button ── */
        .btn-glass-outline {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.18);
            color: rgba(245,230,200,0.8);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.7rem;
            transition: all 0.3s;
        }
        .btn-glass-outline:hover {
            background: rgba(255,255,255,0.09);
            border-color: rgba(255,255,255,0.4);
            color: #fff;
        }

        /* ── Card glass ── */
        .card-glass {
            position: relative;
            background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
            backdrop-filter: blur(20px) saturate(150%);
            -webkit-backdrop-filter: blur(20px) saturate(150%);
            border: 1px solid rgba(201,168,76,0.2);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.05);
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .card-glass:hover {
            border-color: rgba(201,168,76,0.38);
            box-shadow: 0 12px 40px rgba(0,0,0,0.5), 0 0 18px rgba(201,168,76,0.07);
        }

        .mobile-card {
            width: 100%;
        }

        @media (max-width: 900px) {
            .mobile-card {
                width: calc(100% - 2rem);
                max-width: 28rem;
                margin-inline: auto;
            }

            .mobile-card .theme-action {
                width: 100%;
            }
        }

        /* ── Glass input ── */
        .input-glass {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(201,168,76,0.2);
            border-radius: 0.25rem;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            color: #e4e4e7;
            outline: none;
            transition: border-color 0.25s;
            backdrop-filter: blur(8px);
        }
        .input-glass::placeholder { color: rgba(161,161,170,0.5); }
        .input-glass:focus { border-color: rgba(201,168,76,0.55); }

        /* ── Section label ── */
        .section-label {
            font-family: 'Cinzel', serif;
            font-size: 0.6rem;
            letter-spacing: 0.38em;
            text-transform: uppercase;
            color: #C9A84C;
        }

        /* ── Divider gold ── */
        .divider-gold {
            height: 1px;
            background:
                radial-gradient(
                    ellipse at center,
                    rgba(245,230,200,0.95) 0%,
                    rgba(201,168,76,0.8) 18%,
                    rgba(201,168,76,0.45) 42%,
                    transparent 72%
                );
            box-shadow: 0 0 8px rgba(201,168,76,0.45);
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0a0806; }
        ::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.35); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(201,168,76,0.6); }

        /* ── Status badges ── */
        .badge-hadir  { background: rgba(6,78,59,0.5);  border: 1px solid #059669; color: #6ee7b7; }
        .badge-telat  { background: rgba(120,53,15,0.5); border: 1px solid #d97706; color: #fcd34d; }
        .badge-izin   { background: rgba(30,58,138,0.5); border: 1px solid #3b82f6; color: #93c5fd; }
        .badge-sakit  { background: rgba(30,58,138,0.5); border: 1px solid #3b82f6; color: #93c5fd; }
        .badge-alpa   { background: rgba(127,29,29,0.5); border: 1px solid #ef4444; color: #fca5a5; }

        /* ── Reveal on scroll ── */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ── Divider gold ── */
        .divider-gold {
            height: 1px;
            background:
                radial-gradient(
                    ellipse at center,
                    rgba(245,230,200,0.95) 0%,
                    rgba(201,168,76,0.8) 18%,
                    rgba(201,168,76,0.45) 42%,
                    transparent 72%
                );
            box-shadow: 0 0 8px rgba(201,168,76,0.45);
        }

        /* ── Glow pulse ── */
        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 0 16px rgba(201,168,76,0.2); }
            50%       { box-shadow: 0 0 32px rgba(201,168,76,0.45); }
        }
        .glow-pulse { animation: glowPulse 3s ease-in-out infinite; }

        .theme-action {
            display: block;
            width: 120px;
            padding: 8px 0;
            border-radius: 4px;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.25s;
        }
        .theme-action:hover {
            filter: brightness(1.15);
            box-shadow: 0 0 16px rgba(201,168,76,0.22);
        }
        .theme-action-dark {
            background: #A67C2A;
            color: #F5E6C8;
            border: 1px solid rgba(245,230,200,0.25);
        }
        .theme-action-gold {
            background: #C9A84C;
            color: #0a0806;
            border: 1px solid rgba(245,230,200,0.35);
        }
        .theme-action-soft {
            background: rgba(201,168,76,0.2);
            color: #F5E6C8;
            border: 1px solid rgba(201,168,76,0.5);
        }

        .schedule-card {
            background: #C9A84C;
            border: 1px solid rgba(245,230,200,0.45);
            color: #0a0806;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        }
    </style>

    @stack('head')
</head>

<body class="page-bg text-zinc-100 min-h-screen selection:bg-gold-500 selection:text-black">

    <!-- ── Navbar ── -->
    <header id="navbar" class="sticky top-0 z-50 border-b border-white/10 bg-black/50 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between" style="height:4rem">

            {{-- Logo kiri --}}
            <a href="{{ Auth::guard('peserta')->check() ? route('peserta.dashboard') : route('landing') }}" class="shrink-0">
                <img src="{{ asset('images/logo-gamatif.png') }}"
                     alt="GAMATIF 2026"
                     class="h-6 w-auto drop-shadow-[0_2px_8px_rgba(201,168,76,0.45)]">
            </a>

            {{-- Menu tengah --}}
            <nav class="hidden sm:flex items-center gap-8">
                <a href="/" class="nav-link {{ request()->is('/') ? 'text-gold-400' : '' }}">Beranda</a>
                @auth('peserta')
                    <a href="{{ route('peserta.dashboard') }}"
                       class="nav-link {{ request()->routeIs('peserta.dashboard') ? '!text-gold-400' : '' }}">Dashboard</a>
                    <a href="{{ route('menfess') }}" class="nav-link">Gamafess</a>
                @endauth
            </nav>

            {{-- Avatar dropdown kanan --}}
            @auth('peserta')
            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-full transition"
                        style="border: 1px solid rgba(201,168,76,0.4); background: rgba(201,168,76,0.1);">
                    {{-- Inisial avatar --}}
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-black shrink-0"
                          style="background: #C9A84C;">
                        {{ strtoupper(substr(Auth::guard('peserta')->user()->nama_lengkap, 0, 2)) }}
                    </span>
                    <span class="hidden sm:block text-xs font-cinzel text-gold-300 tracking-wide max-w-[100px] truncate">
                        {{ explode(' ', Auth::guard('peserta')->user()->nama_lengkap)[0] }}
                    </span>
                    <svg class="w-3 h-3 text-gold-400 transition-transform" :class="{ 'rotate-180': open }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Dropdown menu --}}
                <div x-show="open" x-transition
                     class="absolute right-0 mt-2 w-52 rounded-lg overflow-hidden z-50"
                     style="background: rgba(15,12,9,0.97); border: 1px solid rgba(201,168,76,0.25);
                            box-shadow: 0 16px 40px rgba(0,0,0,0.6);">

                    {{-- Header info --}}
                    <div class="px-4 py-3 border-b border-gold-500/15">
                        <p class="font-semibold text-white text-sm">{{ Auth::guard('peserta')->user()->nama_lengkap }}</p>
                        <p class="text-xs text-zinc-500 mt-0.5 truncate">NIM: {{ Auth::guard('peserta')->user()->nim }}</p>
                    </div>

                    {{-- Links --}}
                    <div class="py-1">
                        <a href="/" class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-300 hover:text-white hover:bg-white/5 transition">
                            Beranda
                        </a>
                        <a href="{{ route('peserta.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-300 hover:text-white hover:bg-white/5 transition">
                            Dashboard
                        </a>
                        <a href="{{ route('landing') }}#menfess" class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-300 hover:text-white hover:bg-white/5 transition">
                            Gamafess
                        </a>
                    </div>

                    <div class="border-t border-gold-500/15 py-1">
                        <a href="{{ route('peserta.profil') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-300 hover:text-white hover:bg-white/5 transition">
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('peserta.logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm text-rose-400 hover:text-rose-300 hover:bg-white/5 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth

        </div>
    </header>

    <!-- ── Flash messages ── -->
    @if(session('success') || session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            @if(session('success'))
                <div class="card-glass rounded-sm px-4 py-3 text-sm text-emerald-300 border-l-2 border-emerald-500 mb-3">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="card-glass rounded-sm px-4 py-3 text-sm text-rose-300 border-l-2 border-rose-500 mb-3">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    <!-- ── Content ── -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- ── Footer ── -->
    <footer class="border-t border-gold-500/10 bg-black/40 backdrop-blur mt-8">

        {{-- Kritik & Saran — hanya tampil saat sudah login --}}
        @auth('peserta')
        <div class="relative overflow-hidden"
             style="background-image: linear-gradient(to bottom, rgba(10,8,6,0.82) 0%, rgba(10,8,6,0.88) 100%), url('/images/BACKGROUND_WEB.png');
                    background-size: cover; background-position: center; background-attachment: fixed;
                    border-bottom: 1px solid rgba(201,168,76,0.12);">
            <div class="max-w-xl mx-auto px-6 py-14 text-center">
                <p class="font-cinzel text-[0.65rem] tracking-[0.45em] uppercase text-gold-500 mb-3">Suara Anda</p>
                <h2 class="font-cinzel text-2xl sm:text-3xl font-bold text-white mb-2">Kritik &amp; Saran</h2>
                <p class="text-zinc-400 text-sm mb-8">Beri masukan demi kelancaran kegiatan orientasi.</p>
                <div class="card-glass rounded-lg p-6 text-left">
                    <form action="{{ route('kirim_kritik_saran') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="font-cinzel text-[0.6rem] tracking-widest uppercase text-gold-500/80 mb-2 block">
                                Nama <span class="text-zinc-600 normal-case font-sans font-normal">(Opsional)</span>
                            </label>
                            <input type="text" name="nama" placeholder="Anonim"
                                   class="w-full bg-white/5 border border-gold-500/20 rounded-sm px-4 py-3
                                          text-sm text-zinc-200 placeholder-zinc-600
                                          focus:outline-none focus:border-gold-500/50 transition">
                        </div>
                        <div>
                            <label class="font-cinzel text-[0.6rem] tracking-widest uppercase text-gold-500/80 mb-2 block">Pesan Masukan</label>
                            <textarea name="pesan" rows="4" required placeholder="Tulis masukan Anda..."
                                      class="w-full bg-white/5 border border-gold-500/20 rounded-sm px-4 py-3
                                             text-sm text-zinc-200 placeholder-zinc-600
                                             focus:outline-none focus:border-gold-500/50 transition resize-none"></textarea>
                        </div>
                        <button type="submit" class="btn-glass w-full py-3 rounded-sm">Kirim Masukan</button>
                    </form>
                </div>
            </div>
        </div>
        @endauth

        {{-- Logo + copyright --}}
        <div class="py-6 text-center">
            <div class="flex items-center gap-6 justify-center mb-4">
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
            <p class="section-label text-zinc-600">Gamatif Expedition &copy; 2026</p>
        </div>

    </footer>

    <script>
        // Reveal on scroll
        const revealEls = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
        }, { threshold: 0.1 });
        revealEls.forEach(el => revealObserver.observe(el));
    </script>
    @if(session('kritik_saran_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @js(session('kritik_saran_success')),
                confirmButtonText: 'Oke',
                confirmButtonColor: '#C9A84C',
                background: '#17110b',
                color: '#F5E6C8'
            });
        </script>
    @endif
    @stack('scripts')
</body>
</html>
