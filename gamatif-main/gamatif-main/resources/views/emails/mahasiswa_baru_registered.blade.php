<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Akun Mahasiswa Baru</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 0; margin: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9f9f9; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; padding: 24px; text-align: left;">
                    <tr>
                        <td>
                            <h1 style="color: #0d6efd; text-align: center; margin-bottom: 20px;">
                                Selamat Datang di IF UNIKOM 🎉
                            </h1>

                            <p>Halo, <strong>{{ $nama }}</strong></p>

                            <p>Selamat! Akun Anda telah berhasil dibuat.<br>Berikut informasi akun Anda:</p>

                            <div style="background: #f4f6f8; border-radius: 6px; padding: 16px; margin: 20px 0;">
                                <p style="margin: 0 0 8px;"><strong>Email:</strong> {{ $email }}</p>
                                <p style="margin: 0;"><strong>Password:</strong>
                                    <span style="background:#fff; padding:4px 8px; border-radius:4px; font-family: monospace;">
                                        {{ $password }}
                                    </span>
                                </p>
                            </div>

                            <p style="color: #b02a37; font-weight: bold; margin-top: 12px;">
                                ⚠️ Akun Anda belum aktif.
                            </p>
                            <p>Mohon menunggu proses konfirmasi dari panitia.<br>
                            Setelah akun Anda disetujui, Anda akan menerima email pemberitahuan aktivasi.<br>
                            Silakan cek email Anda secara berkala.</p>

                            <p style="margin-top: 24px;">Terima kasih atas perhatian dan kerjasamanya.</p>
                            <p style="font-weight: bold;">Hormat kami,<br>Panitia GAMATIF {{ date('Y') }}</p>

                            <hr style="border: none; border-top: 1px solid #ddd; margin: 24px 0;">
                            <p style="font-size: 12px; color: #888; text-align: center;">
                                Ini adalah email otomatis. Mohon jangan membalas email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
