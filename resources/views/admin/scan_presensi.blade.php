<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Presensi Maba - GAMATIF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="bg-zinc-950 text-zinc-100 min-h-screen p-4 flex flex-col items-center">

    <div class="max-w-md w-full space-y-4">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <div>
                <h1 class="font-black text-amber-400 text-lg">SCANNER PRESENSI</h1>
                <p class="text-xs text-zinc-400">Scan QR Mahasiswa Baru</p>
            </div>
            <a href="/admin" class="text-xs text-zinc-400 underline">Kembali ke Admin</a>
        </div>

        <!-- Pilih Hari / Jadwal Kegiatan -->
        <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-xl">
            <label class="block text-xs font-semibold text-amber-400 mb-1.5">Pilih Agenda Kegiatan Hari Ini:</label>
            <select id="select-jadwal" class="w-full bg-zinc-800 border border-zinc-700 text-zinc-100 text-sm rounded-lg p-2.5 focus:outline-none focus:border-amber-500">
                @foreach($jadwals as $j)
                    <option value="{{ $j->id }}">{{ $j->nama }} ({{ $j->tanggal->format('d M Y') }})</option>
                @endforeach
            </select>
        </div>

        <!-- Kamera Preview Box -->
        <div class="bg-zinc-900 border border-zinc-800 p-4 rounded-xl flex flex-col items-center">
            <div id="reader" class="w-full overflow-hidden rounded-lg"></div>
            <p class="text-[11px] text-zinc-500 mt-2">Arahkan kamera ke QR Code peserta.</p>
        </div>

        <!-- Log Hasil Terakhir -->
        <div id="scan-result" class="hidden p-4 rounded-xl border text-sm"></div>
    </div>

    <script>
        let isProcessing = false;

        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) return;
            isProcessing = true;

            const jadwalId = document.getElementById('select-jadwal').value;
            const resultBox = document.getElementById('scan-result');

            fetch("{{ route('admin.scan.proses') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    jadwal_kegiatan_id: jadwalId,
                    qr_data: decodedText
                })
            })
            .then(res => res.json())
            .then(data => {
                resultBox.classList.remove('hidden', 'bg-rose-950', 'border-rose-700', 'text-rose-300', 'bg-emerald-950', 'border-emerald-700', 'text-emerald-300');
                
                if (data.status === 'success') {
                    resultBox.classList.add('bg-emerald-950', 'border-emerald-700', 'text-emerald-300');
                    resultBox.innerHTML = `<strong>✓ BERHASIL!</strong><br>${data.message}`;
                } else {
                    resultBox.classList.add('bg-rose-950', 'border-rose-700', 'text-rose-300');
                    resultBox.innerHTML = `<strong>✕ GAGAL!</strong><br>${data.message}`;
                }

                // Jeda 2 detik sebelum kamera bisa men-scan peserta berikutnya
                setTimeout(() => {
                    isProcessing = false;
                }, 2000);
            })
            .catch(err => {
                console.error(err);
                isProcessing = false;
            });
        }

        // Jalankan Scanner Kamera
        const html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: { width: 250, height: 250 } }, false
        );
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>