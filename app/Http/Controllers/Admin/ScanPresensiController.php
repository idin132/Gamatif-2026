<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalKegiatan;
use App\Models\MahasiswaBaru;
use Illuminate\Http\Request;

class ScanPresensiController extends Controller
{
    public function index()
    {
        $jadwals = JadwalKegiatan::orderBy('tanggal', 'asc')->get();
        return view('admin.scan_presensi', compact('jadwals'));
    }

    public function prosesScan(Request $request)
    {
        $request->validate([
            'jadwal_kegiatan_id' => 'required|exists:jadwal_kegiatan,id',
            'identifier' => 'required', // Bisa berupa string QR Code atau NIM
        ]);

        $identifier = trim($request->identifier);
        $maba = null;

        // 1. Cek apakah identifier berformat JSON (dari hasil kamera scan QR)
        $payload = json_decode($identifier, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($payload)) {
            if (!empty($payload['id'])) {
                $maba = MahasiswaBaru::with('kelompok')->find($payload['id']);
            } elseif (!empty($payload['nim'])) {
                $maba = MahasiswaBaru::with('kelompok')->where('nim', $payload['nim'])->first();
            }
        }

        // 2. Jika bukan JSON, cari langsung berdasarkan NIM atau ID
        if (!$maba) {
            $maba = MahasiswaBaru::with('kelompok')
                ->where('nim', $identifier)
                ->orWhere('id', $identifier)
                ->first();
        }

        // 3. Validasi maba ditemukan atau belum di-ACC
        if (!$maba) {
            return response()->json([
                'status' => 'error',
                'message' => "Mahasiswa dengan data '{$identifier}' tidak ditemukan!"
            ], 404);
        }

        if ($maba->status != 1) {
            return response()->json([
                'status' => 'error',
                'message' => "Mahasiswa {$maba->nama_lengkap} ({$maba->nim}) belum di-ACC oleh admin!"
            ], 422);
        }

        // 4. Catat presensi ke database
        $absensi = Absensi::updateOrCreate(
            [
                'mahasiswa_baru_id' => $maba->id,
                'jadwal_kegiatan_id' => $request->jadwal_kegiatan_id,
            ],
            [
                'kelompok_id' => $maba->kelompok_id,
                'status' => 'hadir',
            ]
        );

        $namaKelompok = $maba->kelompok?->nama_kelompok ?? '-';

        return response()->json([
            'status' => 'success',
            'message' => "Presensi Berhasil: {$maba->nim} - {$maba->nama_lengkap} [House: {$namaKelompok}] (HADIR)",
            'data' => [
                'nim' => $maba->nim,
                'nama' => $maba->nama_lengkap,
                'kelompok' => $namaKelompok,
                'status' => 'hadir',
            ]
        ]);
    }
}