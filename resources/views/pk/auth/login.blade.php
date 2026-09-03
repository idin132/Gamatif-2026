<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login PK Portal - GAMATIF 2026</title>
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
<body class="bg-sand text-zinc-100 min-h-screen flex items-center justify-center p-4 selection:bg-spice-500 selection:text-black">

    <div class="w-full max-w-sm bg-sandcard border border-zinc-800 p-6 sm:p-8 rounded-2xl shadow-2xl space-y-6">
        
        <!-- Header -->
        <div class="text-center space-y-1">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-spice-500/10 border border-spice-500/20 text-spice-400 mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <span class="text-[10px] font-mono tracking-widest text-spice-400 uppercase font-bold block">HOUSE LEADER PORTAL</span>
            <h1 class="text-2xl font-black text-white tracking-wide">Login PK</h1>
            <p class="text-xs text-zinc-400">Masuk untuk mengelola presensi & barang maba</p>
        </div>

        <!-- Alert Error -->
        @if ($errors->any())
            <div class="p-3 bg-rose-950/80 border border-rose-800 rounded-xl text-rose-300 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form Login -->
        <form method="POST" action="{{ route('pk.login.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1.5">Email Terdaftar</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@gamatif.com"
                    class="w-full bg-zinc-900 border border-zinc-700 text-zinc-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-spice-500 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-zinc-300 mb-1.5">Password</label>
                <input type="password" name="password" required
                    placeholder="••••••••"
                    class="w-full bg-zinc-900 border border-zinc-700 text-zinc-100 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-spice-500 transition">
            </div>

            <div class="flex items-center justify-between text-xs text-zinc-400">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="rounded bg-zinc-900 border-zinc-700 text-spice-500 focus:ring-0">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit"
                class="w-full bg-spice-500 hover:bg-spice-600 text-black font-extrabold py-3 rounded-xl transition text-sm shadow-lg shadow-amber-500/20 active:scale-[0.99]">
                Masuk ke Panel PK
            </button>
        </form>

        <div class="text-center pt-2 border-t border-zinc-800">
            <a href="{{ route('landing') }}" class="text-[11px] text-zinc-500 hover:text-zinc-300 transition">← Kembali ke Halaman Utama</a>
        </div>
    </div>

</body>
</html>