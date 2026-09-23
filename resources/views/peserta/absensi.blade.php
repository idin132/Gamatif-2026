@extends('layouts.peserta')

@section('title', 'Absensi - Portal Peserta GAMATIF 2026')

@push('head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endpush

@section('content')

    {{-- ── Heading ── --}}
    <div class="mb-6 flex items-center gap-4 reveal">
        <a href="{{ route('peserta.dashboard') }}"
            class="flex items-center gap-1.5 text-xs text-zinc-400 hover:text-gold-400 transition font-cinzel tracking-wider uppercase">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <h2 class="text-xl sm:text-2xl font-semibold text-white">QR Absensi</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- ═══ QR Code ═══ --}}
        <div class="card-glass mobile-card rounded-lg p-8 flex flex-col items-center text-center reveal">

            @if($peserta->status == 1)
                <p class="text-sm text-gold-400 mb-6">Pindai kode QR ini untuk absensi</p>

                <div class="p-4 bg-white rounded-xl mb-6"
                    style="box-shadow: 0 0 30px rgba(201,168,76,0.2), 0 0 60px rgba(201,168,76,0.08);">
                    <div id="qrcode-box"></div>
                </div>

                <button type="button" onclick="downloadQrCode()"
                    class="btn-glass px-8 py-3 rounded-sm flex items-center justify-center gap-2 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download QR (PNG)
                </button>

                <p class="text-xs text-zinc-600 mt-4">NIM: {{ $peserta->nim }}</p>
            @else
                <div class="py-12">
                    <svg class="w-16 h-16 text-zinc-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <p class="text-zinc-500 text-sm font-cinzel tracking-widest uppercase">Akun Belum Diverifikasi</p>
                    <p class="text-zinc-600 text-xs mt-2">QR akan tersedia setelah akun diverifikasi oleh admin.</p>
                </div>
            @endif
        </div>

        {{-- ═══ Rekap Kehadiran ═══ --}}
        <div class="card-glass mobile-card rounded-lg p-6 reveal">
            <p class="section-label mb-1">📋 Rekap Kehadiran Anda</p>
            <div class="divider-gold my-4"></div>

            @if($riwayatAbsensi->isEmpty())
                <div class="py-10 text-center">
                    <p class="text-xs text-zinc-600 font-cinzel tracking-widest uppercase">Belum ada data kehadiran.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($riwayatAbsensi as $i => $abs)
                        <div class="flex items-center justify-between px-4 py-3 rounded-sm"
                            style="background: rgba(255,255,255,0.03); border: 1px solid rgba(201,168,76,0.1);">
                            <div>
                                <p class="text-sm font-medium text-zinc-200">{{ $abs->jadwalKegiatan->nama }}</p>
                                <p class="text-xs text-zinc-500 mt-0.5">
                                    {{ $abs->jadwalKegiatan->tanggal->format('d M Y') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs rounded-sm font-cinzel tracking-wider uppercase shrink-0 ml-3
                                                    {{ $abs->status == 'hadir' ? 'badge-hadir' : '' }}
                                                    {{ $abs->status == 'telat' ? 'badge-telat' : '' }}
                                                    {{ in_array($abs->status, ['izin', 'sakit']) ? 'badge-izin' : '' }}
                                                    {{ $abs->status == 'alpa' ? 'badge-alpa' : '' }}">
                                {{ $abs->status }}
                            </span>
                        </div>
                    @endforeach
                </div>

                {{-- Ringkasan --}}
                <div class="mt-5 pt-4 border-t border-gold-500/10">
                    @php
                        $total = $riwayatAbsensi->count();
                        $hadir = $riwayatAbsensi->whereIn('status', ['hadir', 'telat'])->count();
                        $izin = $riwayatAbsensi->whereIn('status', ['izin', 'sakit'])->count();
                        $alpa = $riwayatAbsensi->where('status', 'alpa')->count();
                    @endphp
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="p-3 rounded-sm"
                            style="background: rgba(6,78,59,0.2); border: 1px solid rgba(5,150,105,0.3);">
                            <p class="text-lg font-bold text-emerald-300">{{ $hadir }}</p>
                            <p class="text-[10px] text-emerald-500 font-cinzel tracking-widest uppercase mt-0.5">Hadir</p>
                        </div>
                        <div class="p-3 rounded-sm"
                            style="background: rgba(30,58,138,0.2); border: 1px solid rgba(59,130,246,0.3);">
                            <p class="text-lg font-bold text-blue-300">{{ $izin }}</p>
                            <p class="text-[10px] text-blue-400 font-cinzel tracking-widest uppercase mt-0.5">Izin/Sakit</p>
                        </div>
                        <div class="p-3 rounded-sm"
                            style="background: rgba(127,29,29,0.2); border: 1px solid rgba(239,68,68,0.3);">
                            <p class="text-lg font-bold text-rose-300">{{ $alpa }}</p>
                            <p class="text-[10px] text-rose-400 font-cinzel tracking-widest uppercase mt-0.5">Alpa</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        @if($peserta->status == 1)
            document.addEventListener("DOMContentLoaded", function () {
                const qrContainer = document.getElementById("qrcode-box");
                if (!qrContainer) return;

                // Masukkan data ID, NIM, kelompok_id, dan nama_kelompok ke payload QR
                const qrPayload = JSON.stringify({
                    id: {{ $peserta->id }},
                    nim: "{{ $peserta->nim }}",
                    kelompok_id: {{ $peserta->kelompok_id ?? 'null' }},
                    kelompok: "{{ $peserta->kelompok?->nama_kelompok ?? '-' }}",
                    type: "gamatif_maba"
                });

                window.qrCodeInstance = new QRCode(qrContainer, {
                    text: qrPayload,
                    width: 180,
                    height: 180,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            });

            function downloadQrCode() {
                const qrBox = document.getElementById('qrcode-box');

                // Cari elemen canvas atau img di dalam qrcode-box
                const sourceCanvas = qrBox.querySelector('canvas');
                const sourceImg = qrBox.querySelector('img');

                if (!sourceCanvas && !sourceImg) {
                    alert('QR Code belum siap untuk diunduh.');
                    return;
                }

                // Buat canvas baru untuk proses rendering background putih + margin
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Margin putih di sekeliling QR Code (Quiet Zone)
                const margin = 15;

                let qrWidth = 300;
                let qrHeight = 300;

                if (sourceCanvas) {
                    qrWidth = sourceCanvas.width;
                    qrHeight = sourceCanvas.height;
                } else if (sourceImg) {
                    qrWidth = sourceImg.naturalWidth || 300;
                    qrHeight = sourceImg.naturalHeight || 300;
                }

                // Set ukuran canvas baru = ukuran QR + margin kiri, kanan, atas, bawah
                canvas.width = qrWidth + (margin * 2);
                canvas.height = qrHeight + (margin * 2);

                // 1. Cat seluruh background canvas dengan warna PUTIH PADAT
                ctx.fillStyle = '#FFFFFF';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // 2. Gambar QR Code tepat di tengah-tengah background putih
                if (sourceCanvas) {
                    ctx.drawImage(sourceCanvas, margin, margin);
                    executeDownload(canvas);
                } else if (sourceImg) {
                    const img = new Image();
                    img.crossOrigin = 'anonymous';
                    img.onload = function () {
                        ctx.drawImage(img, margin, margin);
                        executeDownload(canvas);
                    };
                    img.src = sourceImg.src;
                }
            }

            // Helper untuk mentrigger download file PNG
            function executeDownload(canvas) {
                const link = document.createElement('a');
                link.download = 'QR-Presensi-{{ $peserta->nim }}.png';
                link.href = canvas.toDataURL('image/png');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        @endif
    </script>
@endpush