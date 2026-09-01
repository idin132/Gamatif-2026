<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBaru;
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
            'bukti_registrasi' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'bukti_sosmed.*' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

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
            'alamat' => $validated['alamat'],
            'nomor_whatsapp' => $validated['nomor_whatsapp'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'bukti_registrasi' => $buktiRegPath,
            'bukti_sosmed' => $sosmedPaths,
            'status' => 0,
        ]);

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