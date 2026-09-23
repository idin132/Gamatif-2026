<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Diverifikasi</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #0d0c0a; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #f4f4f5;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
        style="background-color: #0d0c0a; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%"
                    style="max-width: 540px; background-color: #171512; border: 1px solid #3d3423; border-radius: 14px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.6);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 32px 24px 16px; border-bottom: 1px solid #292318;">
                            <span
                                style="font-size: 11px; letter-spacing: 0.25em; text-transform: uppercase; color: #c9a84c; font-weight: bold; display: block; margin-bottom: 6px;">GAMATIF
                                2026</span>
                            <h1 style="margin: 0; font-size: 22px; color: #ffffff; font-weight: 700;">Akun Telah
                                Terverifikasi</h1>
                        </td>
                    </tr>

                    <!-- Konten Utama -->
                    <tr>
                        <td style="padding: 28px 24px;">
                            <p style="margin: 0 0 16px; font-size: 14px; line-height: 1.6; color: #d4d4d8;">
                                Selamat, <strong style="color: #ffffff;">{{ $maba->nama_lengkap }}</strong>! 🎉
                            </p>
                            <p style="margin: 0 0 20px; font-size: 14px; line-height: 1.6; color: #a1a1aa;">
                                Pendaftaran kamu telah diverifikasi dan disetujui (ACC) oleh panitia GAMATIF 2026. Tiket
                                presensi digital kamu kini sudah aktif.
                            </p>

                            <!-- Kotak Informasi Peserta -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                style="background-color: #211d17; border: 1px solid #362e1f; border-radius: 8px; margin-bottom: 24px;">
                                <tr>
                                    <td
                                        style="padding: 12px 16px; font-size: 13px; color: #a1a1aa; border-bottom: 1px solid #2a2419;">
                                        NIM</td>
                                    <td align="right"
                                        style="padding: 12px 16px; font-size: 13px; color: #f4f4f5; font-weight: bold; font-family: monospace; border-bottom: 1px solid #2a2419;">
                                        {{ $maba->nim }}
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 12px 16px; font-size: 13px; color: #a1a1aa; border-bottom: 1px solid #2a2419;">
                                        House / Kelompok</td>
                                    <td align="right"
                                        style="padding: 12px 16px; font-size: 13px; color: #e8d49e; font-weight: bold; border-bottom: 1px solid #2a2419;">
                                        {{ $maba->kelompok?->nama_kelompok ?? 'Belum Ditentukan' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; font-size: 13px; color: #a1a1aa;">Status Presensi
                                    </td>
                                    <td align="right" style="padding: 12px 16px; font-size: 12px; white-space: nowrap;">
                                        <span
                                            style="display: inline-block; background-color: #064e3b; color: #6ee7b7; padding: 4px 8px; border-radius: 4px; font-weight: 600; border: 1px solid #047857; font-size: 11px; line-height: 1.2;">
                                            Diverifikasi
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                style="margin-bottom: 24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/portal/login') }}" target="_blank"
                                            style="display: inline-block; background-color: #c9a84c; color: #0d0c0a; font-size: 13px; font-weight: 700; text-decoration: none; padding: 12px 28px; border-radius: 6px; letter-spacing: 0.05em; text-transform: uppercase;">
                                            Unduh Tiket QR Presensi
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <div
                                style="background-color: #1a1814; border-left: 3px solid #c9a84c; padding: 12px 14px; border-radius: 4px;">
                                <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #a1a1aa;">
                                    ⚠️ <strong>Penting:</strong> Simpan atau unduh gambar QR Code dari dashboard peserta
                                    ke ponsel kamu. Tunjukkan kode tersebut saat gerbang presensi setiap hari kegiatan.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="padding: 20px 24px; background-color: #12100d; border-top: 1px solid #261f15;">
                            <p style="margin: 0; font-size: 11px; color: #52525b; line-height: 1.5;">
                                &copy; 2026 GAMATIF. Seluruh hak cipta dilindungi.<br>
                                Pertanyaan seputar kelompok silakan hubungi Pendamping Kelompok (PK) masing-masing.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>