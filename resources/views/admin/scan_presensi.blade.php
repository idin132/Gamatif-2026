<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Presensi - GAMATIF 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
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
                linear-gradient(to bottom, rgba(10,8,6,0.80) 0%, rgba(10,8,6,0.95) 100%),
                url('/images/BACKGROUND_WEB.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .card-glass {
            background: linear-gradient(135deg, rgba(255,255,255,0.07), rgba(255,255,255,0.02));
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
        .input-glass {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(201,168,76,0.22);
            border-radius: 0.25rem;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            color: #e4e4e7;
            outline: none;
            transition: border-color 0.25s;
        }
        .input-glass:focus { border-color: rgba(201,168,76,0.55); }
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
<body class="page-bg text-zinc-100 min-h-screen p-4 flex flex-col items-center">

    <div class="max-w-md w-full space-y-5 py-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="/images/logo-gamatif.png" alt="GAMATIF"
                     class="h-9 w-auto drop-shadow-[0_2px_8px_rgba(201,168,76,0.4)]">
                <div>
                    <p class="section-label">Panitia</p>
                    <h1 class="font-cinzel text-lg font-bold text-white">Scanner Presensi</h1>
                </div>
            </div>
            <a href="/admin"
               class="text-xs font-cinzel tracking-widest uppercase text-zinc-500 hover:text-gold-400 transition">
                ← Admin
            </a>
        </div>

        <div class="divider-gold"></div>

        <!-- Pilih jadwal -->
        <div class="card-glass p-5 rounded-lg space-y-2">
            <label class="section-label block">Agenda Kegiatan Hari Ini</label>
            <select id="select-jadwal" class="input-glass rounded-sm">
                @foreach($jadwals as $j)
                    <option value="{{ $j->id }}">
                        {{ $j->nama }} ({{ $j->tanggal->format('d M Y') }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Camera box -->
        <div class="card-glass p-5 rounded-lg flex flex-col items-center space-y-3">
            <p class="section-label">Kamera QR Scanner</p>
            <div id="reader" class="w-full overflow-hidden rounded-md"></div>
            <p class="text-[11px] text-zinc-500 text-center">
                Arahkan kamera ke QR Code peserta untuk scan presensi.
            </p>
        </div>

        <!-- Hasil scan -->
        <div id="scan-result" class="hidden p-4 rounded-sm border text-sm font-medium"></div>

    </div>

    <script>
        let isProcessing = false;

        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) return;
            isProcessing = true;

            const jadwalId  = document.getElementById('select-jadwal').value;
            const resultBox = document.getElementById('scan-result');

            fetch("{{ route('admin.scan.proses') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ jadwal_kegiatan_id: jadwalId, qr_data: decodedText })
            })
            .then(res => res.json())
            .then(data => {
                resultBox.className = 'p-4 rounded-sm border text-sm font-medium';

                if (data.status === 'success') {
                    resultBox.classList.add(
                        'bg-emerald-950/60', 'border-emerald-600/50', 'text-emerald-300'
                    );
                    resultBox.innerHTML = `<strong>✓ BERHASIL</strong><br><span class="text-xs font-normal">${data.message}</span>`;
                } else {
                    resultBox.classList.add(
                        'bg-rose-950/60', 'border-rose-700/50', 'text-rose-300'
                    );
                    resultBox.innerHTML = `<strong>✕ GAGAL</strong><br><span class="text-xs font-normal">${data.message}</span>`;
                }

                setTimeout(() => { isProcessing = false; }, 2000);
            })
            .catch(err => {
                console.error(err);
                isProcessing = false;
            });
        }

        const html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: { width: 250, height: 250 } }, false
        );
        html5QrcodeScanner.render(onScanSuccess);
    </script>

</body>
</html>
