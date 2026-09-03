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
            'qr_data' => 'required',
        ]);

        // Decode payload QR
        $payload = json_decode($request->qr_data, true);
        $mabaId = $payload['id'] ?? null;

        if (!$mabaId) {
            // Jika isi QR hanya angka ID maba langsung
            $mabaId = is_numeric($request->qr_data) ? $request->qr_data : null;
        }

        $maba = MahasiswaBaru::find($mabaId);

        if (!$maba) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak valid atau mahasiswa tidak ditemukan!'
            ], 404);
        }

        // Simpan / Update ke tabel absensi dengan status otomatis 'hadir'
        $absensi = Absensi::updateOrCreate(
            [
                'mahasiswa_baru_id' => $maba->id,
                'jadwal_kegiatan_id' => $request->jadwal_kegiatan_id,
            ],
            [
                'status' => 'hadir',
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => "Absensi berhasil: {$maba->nim} - {$maba->nama_lengkap} (HADIR)",
            'data' => [
                'nama' => $maba->nama_lengkap,
                'nim' => $maba->nim,
                'status' => 'hadir',
            ]
        ]);
    }
}