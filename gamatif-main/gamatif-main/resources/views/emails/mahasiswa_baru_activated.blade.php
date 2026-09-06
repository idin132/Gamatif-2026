<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Akun Berhasil Diaktifkan</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 0; margin: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9f9f9; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; padding: 24px; text-align: left;">
                    <tr>
                        <td>
                            <h1 style="color: #0d6efd; text-align: center; margin-bottom: 20px;">
                                Akun Anda Telah Diaktifkan! 🎉
                            </h1>

                            <p>Halo, <strong>{{ $nama }}</strong></p>

                            <p>Selamat! Akun Anda telah diaktifkan oleh panitia.</p>

                            <p style="font-size: 18px; font-weight: bold; color: #28a745; text-align: center; margin: 20px 0;">
                                ✓ Akun Anda sudah aktif
                            </p>

                            <p>Anda sekarang dapat login ke sistem menggunakan email dan password yang telah diberikan sebelumnya.</p>

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
