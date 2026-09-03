<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="background-color: #121214; color: #e4e4e7; font-family: sans-serif; padding: 24px;">
    <div style="max-width: 500px; margin: auto; background-color: #1c1c20; padding: 32px; border-radius: 16px; border: 1px solid #3f3f46;">
        <h2 style="color: #fbbf24; margin-top: 0;">Selamat, {{ $maba->nama_lengkap }}!</h2>
        <p style="font-size: 14px; line-height: 1.6; color: #d4d4d8;">
            Berkas registrasi Anda telah disetujui (**ACC**) oleh panitia GAMATIF 2026.
        </p>
        <p style="font-size: 14px; line-height: 1.6; color: #d4d4d8;">
            Silakan masuk ke Portal Peserta untuk mengunduh <strong>QR Code Tiket Presensi</strong> Anda:
        </p>
        <div style="margin: 24px 0; text-align: center;">
            <a href="{{ route('peserta.login') }}" style="background-color: #f59e0b; color: #000; padding: 12px 24px; text-decoration: none; font-weight: bold; border-radius: 8px; font-size: 14px;">
                Masuk ke Portal Peserta
            </a>
        </div>
        <p style="font-size: 12px; color: #71717a; margin-bottom: 0;">
            Simpan QR Code tersebut di smartphone Anda untuk di-scan oleh panitia saat memasuki acara.
        </p>
    </div>
</body>
</html>