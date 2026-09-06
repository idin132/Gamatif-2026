<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login PK - GAMATIF 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        gold: { 300:'#F5E6C8', 400:'#E8D49E', 500:'#C9A84C', 600:'#A67C2A' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .page-bg {
            background-image:
                linear-gradient(135deg, rgba(10,8,6,0.82) 0%, rgba(10,8,6,0.92) 100%),
                url('/images/BACKGROUND_WEB.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .card-glass {
            background: linear-gradient(135deg, rgba(255,255,255,0.07), rgba(255,255,255,0.02));
            backdrop-filter: blur(24px) saturate(160%);
            -webkit-backdrop-filter: blur(24px) saturate(160%);
            border: 1px solid rgba(201,168,76,0.22);
            box-shadow: 0 8px 40px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.06);
        }
        .btn-glass {
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, rgba(201,168,76,0.2), rgba(201,168,76,0.07) 50%, rgba(201,168,76,0.16));
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(201,168,76,0.5);
            color: #F5E6C8;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 0.72rem;
            transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.08);
        }
        .btn-glass::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.08), transparent 60%);
            pointer-events: none;
        }
        .btn-glass:hover {
            background: linear-gradient(135deg, rgba(201,168,76,0.38), rgba(201,168,76,0.16) 50%, rgba(201,168,76,0.3));
            border-color: rgba(201,168,76,0.8);
            box-shadow: 0 8px 30px rgba(201,168,76,0.25), inset 0 1px 0 rgba(255,255,255,0.12);
            color: #fff;
        }
        .input-glass {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(201,168,76,0.2);
            border-radius: 0.25rem;
            padding: 0.7rem 1rem;
            font-size: 0.875rem;
            color: #e4e4e7;
            outline: none;
            transition: border-color 0.25s;
            backdrop-filter: blur(8px);
        }
        .input-glass::placeholder { color: rgba(161,161,170,0.45); }
        .input-glass:focus { border-color: rgba(201,168,76,0.55); }
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
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0a0806; }
        ::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.35); border-radius: 3px; }
    </style>
</head>
<body class="page-bg text-zinc-100 min-h-screen flex items-center justify-center p-4 selection:bg-yellow-600 selection:text-black">

    <div class="w-full max-w-xs space-y-5">

        <!-- Logo + maskot + title -->
        <div class="text-center space-y-2">
            <img src="/images/logo-gamatif.png" alt="GAMATIF 2026"
                 class="h-7 w-auto mx-auto drop-shadow-[0_2px_10px_rgba(201,168,76,0.5)]">

            <img src="/images/maskot.png" alt="Maskot GAMATIF"
                 class="h-36 w-auto mx-auto"
                 style="filter: drop-shadow(0 0 20px rgba(232,212,158,0.25)) drop-shadow(0 8px 24px rgba(0,0,0,0.5));">

            <p class="section-label">House Leader Portal</p>
            <h1 class="font-cinzel text-xl font-bold text-white tracking-wide">Login PK</h1>
            <p class="text-xs text-zinc-500">Kelola presensi & barang bawaan maba</p>
        </div>

        <!-- Card -->
        <div class="card-glass rounded-lg p-5 space-y-4">

            @if($errors->any())
                <div class="px-4 py-3 rounded-sm bg-rose-950/60 border border-rose-700/60 text-rose-300 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('pk.login.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="section-label block mb-2">Email Terdaftar</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           required autofocus placeholder="nama@gamatif.com"
                           class="input-glass">
                </div>

                <div>
                    <label class="section-label block mb-2">Password</label>
                    <input type="password" name="password" required
                           placeholder="••••••••"
                           class="input-glass">
                </div>

                <div class="flex items-center gap-2 text-xs text-zinc-400">
                    <input type="checkbox" name="remember"
                           class="rounded-sm bg-zinc-900 border-zinc-700 accent-yellow-500">
                    <span>Ingat saya</span>
                </div>

                <button type="submit" class="btn-glass w-full py-3 rounded-sm mt-1">
                    Masuk ke Panel PK
                </button>
            </form>

            <div class="divider-gold"></div>

            <p class="text-center">
                <a href="{{ route('landing') }}" class="section-label text-white hover:text-gold-500 transition">
                    ← Kembali ke Beranda
                </a>
            </p>

        </div>

    </div>

</body>
</html>
