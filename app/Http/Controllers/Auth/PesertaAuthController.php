<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBaru;
use App\Mail\RegistrasiMabaNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PesertaAuthController extends Controller
{
    public function showLogin()
    {
        return view('peserta.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nim' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('peserta')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('peserta.dashboard'));
        }

        return back()->withErrors([
            'nim' => 'NIM atau password yang dimasukkan salah.',
        ])->onlyInput('nim');
    }

    public function showRegister()
    {
        return view('peserta.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:255', 'unique:mahasiswa_baru,nim'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'nomor_whatsapp' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:mahasiswa_baru,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'bukti_registrasi' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'bukti_sosmed.*' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        // ═══ FORMAT NOMOR WHATSAPP KE FORMAT 62 ═══
        $wa = preg_replace('/[^0-9]/', '', $validated['nomor_whatsapp']);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }

        // ═══ CLEANING ALAMAT (HAPUS ENTER/NEWLINE SEJAK INPUT) ═══
        $alamatClean = preg_replace('/\s+/', ' ', trim($validated['alamat']));

        $buktiRegPath = $request->file('bukti_registrasi')->store('bukti_registrasi', 'public');

        $sosmedPaths = [];
        if ($request->hasFile('bukti_sosmed')) {
            foreach ($request->file('bukti_sosmed') as $file) {
                $sosmedPaths[] = $file->store('bukti_sosmed', 'public');
            }
        }

        $peserta = MahasiswaBaru::create([
            'nim' => $validated['nim'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'alamat' => $alamatClean,
            'nomor_whatsapp' => $wa, // <-- Menggunakan nomor WA yang sudah dibersihkan & di-format
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'bukti_registrasi' => $buktiRegPath,
            'bukti_sosmed' => $sosmedPaths,
            'status' => 0,
        ]);

        // ═══ KIRIM EMAIL NOTIFIKASI REGISTRASI BERHASIL ═══
        try {
            Mail::to($peserta->email)->send(new RegistrasiMabaNotification($peserta));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email registrasi: ' . $e->getMessage());
        }

        Auth::guard('peserta')->login($peserta);

        return redirect()->route('peserta.dashboard')->with('success', 'Pendaftaran berhasil! Tunggu verifikasi admin.');
    }

    public function logout(Request $request)
    {
        Auth::guard('peserta')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('peserta.login');
    }
}