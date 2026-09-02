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
                            400: '#E8D7A0',
                            500: '#D8C47A',
                            600: '#B89F52',
                            900: '#5C5130',
                        },

                        sand: '#ACAC81',
                        sandcard: '#FFFFFF1A',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-sand text-white min-h-screen font-sans selection:bg-[#E8D7A0] selection:text-[#38382F]">

    <!-- Top Navbar -->
    <nav class="border-b border-white/10 bg-black/40 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

            <!-- Logo GAMATIF -->
            <div class="flex items-center">
                <a href="{{ route('peserta.dashboard') }}" class="flex items-center">
                    <img src="{{ asset('images/logo-gamatif.png') }}"
                         alt="GAMATIF 2026"
                         class="h-9 sm:h-10 w-auto">
                </a>
            </div>

            @auth('peserta')
                <div class="flex items-center gap-4">

                    <!-- Nama Peserta -->
                    <span class="text-sm text-white hidden sm:inline">
                        {{ Auth::guard('peserta')->user()->nama_lengkap }}
                    </span>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('peserta.logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="bg-[#4A4032]/80 hover:bg-[#3B3328]/90 backdrop-blur-md border border-[#6B674D]/70 text-[#F5F0D8] font-extrabold px-5 py-2.5 rounded-xl transition text-sm shadow-xl shadow-black/20 hover:shadow-[#E8D7A0]/50">
                            Logout
                        </button>
                    </form>

                </div>
            @endauth

        </div>
    </nav>


    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 mt-4">

        @if(session('success'))
            <div class="p-4 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm shadow-[0_4px_12px_rgba(0,0,0,0.12)]">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm shadow-[0_4px_12px_rgba(0,0,0,0.12)]">
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