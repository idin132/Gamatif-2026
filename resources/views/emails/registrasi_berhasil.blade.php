<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
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
                            <h1 style="margin: 0; font-size: 22px; color: #ffffff; font-weight: 700;">Pendaftaran Akun
                                Berhasil</h1>
                        </td>
                    </tr>

                    <!-- Konten Utama -->
                    <tr>
                        <td style="padding: 28px 24px;">
                            <p style="margin: 0 0 16px; font-size: 14px; line-height: 1.6; color: #d4d4d8;">
                                Halo, <strong style="color: #ffffff;">{{ $maba->nama_lengkap }}</strong>!
                            </p>
                            <p style="margin: 0 0 20px; font-size: 14px; line-height: 1.6; color: #a1a1aa;">
                                Berkas dan data registrasi akun kamu untuk kegiatan <strong>GAMATIF 2026</strong> telah
                                berhasil kami terima. Saat ini akun kamu sedang dalam proses verifikasi oleh panitia.
                            </p>

                            <!-- Ringkasan Data -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                style="background-color: #211d17; border: 1px solid #362e1f; border-radius: 8px; margin-bottom: 24px;">
                                <tr>
                                    <td
                                        style="padding: 12px 16px; font-size: 13px; color: #a1a1aa; border-bottom: 1px solid #2a2419;">
                                        NIM</td>
                                    <td align="right"
                                        style="padding: 12px 16px; font-size: 13px; color: #f4f4f5; font-weight: bold; font-family: monospace; border-bottom: 1px solid #2a2419;">
                                        {{ $maba->nim }}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 12px 16px; font-size: 13px; color: #a1a1aa; border-bottom: 1px solid #2a2419;">
                                        Nomor WhatsApp</td>
                                    <td align="right"
                                        style="padding: 12px 16px; font-size: 13px; color: #f4f4f5; border-bottom: 1px solid #2a2419;">
                                        {{ $maba->nomor_whatsapp }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; font-size: 13px; color: #a1a1aa;">Status Akun</td>
                                    <td align="right" style="padding: 12px 16px; font-size: 12px; white-space: nowrap;">
                                        <span
                                            style="display: inline-block; background-color: #451a03; color: #fdba74; padding: 4px 8px; border-radius: 4px; font-weight: 600; border: 1px solid #7c2d12; font-size: 11px; line-height: 1.2;">
                                            Belum diverifikasi
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #71717a;">
                                💡 Tiket QR Code Presensi akan otomatis muncul di portal setelah berkas kamu
                                diverifikasi. Kami akan mengirimkan email konfirmasi lanjutan segera setelah akun kamu
                                di-ACC.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="padding: 20px 24px; background-color: #12100d; border-top: 1px solid #261f15;">
                            <p style="margin: 0; font-size: 11px; color: #52525b; line-height: 1.5;">
                                Email otomatis dari Panitia GAMATIF 2026.<br>
                                Harap jangan membalas email ini secara langsung.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>