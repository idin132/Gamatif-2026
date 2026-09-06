<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Absensi;
use App\Models\JadwalKegiatan;

class ProfileController extends Controller
{
    // GET /api/profile - ambil data user yang sedang login
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    // PUT /api/profile - update data profil
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'nomor_whatsapp' => 'required|string',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'user' => $user
        ]);
    }

    // PUT /api/profile/password - ganti password
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // pastikan kirim field new_password_confirmation
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Password lama salah'], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['message' => 'Password berhasil diganti']);
    }

    // GET /api/absensi - ambil data absensi untuk user yang sedang login
    public function getAbsensi(Request $request)
    {
        $user = $request->user();

        $jadwal = JadwalKegiatan::all();

        $rekap = $jadwal->map(function ($item) use ($user) {
            $absensi = Absensi::where('mahasiswa_baru_id', $user->id)
                ->where('jadwal_kegiatan_id', $item->id)
                ->first();

            return [
                'hari' => $item->nama,
                'status' => $absensi ? ucfirst($absensi->status) : 'Belum Absen',
            ];
        });

        return response()->json($rekap);
    }
}
