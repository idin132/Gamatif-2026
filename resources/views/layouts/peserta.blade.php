<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMATIF - Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        spice: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            900: '#78350f',
                        },
                        sand: '#18181b',
                        sandcard: '#27272a',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-sand text-zinc-100 min-h-screen font-sans selection:bg-spice-500 selection:text-black">

    <!-- Top Navbar -->
    <nav class="border-b border-zinc-800 bg-sand/80 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-spice-500 animate-pulse"></span>
                <a href="{{ route('peserta.dashboard') }}" class="font-bold tracking-widest text-spice-400 text-lg">GAMATIF 2026</a>
            </div>
            @auth('peserta')
            <div class="flex items-center gap-4">
                <span class="text-sm text-zinc-400 hidden sm:inline">{{ Auth::guard('peserta')->user()->nama_lengkap }}</span>
                <form method="POST" action="{{ route('peserta.logout') }}">
                    @csrf
                    <button type="submit" class="text-xs bg-zinc-800 hover:bg-zinc-700 text-spice-400 border border-zinc-700 px-3 py-1.5 rounded transition">Logout</button>
                </form>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="p-4 rounded-lg bg-emerald-950 border border-emerald-700 text-emerald-300 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 rounded-lg bg-rose-950 border border-rose-700 text-rose-300 text-sm">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

</body>
</html>