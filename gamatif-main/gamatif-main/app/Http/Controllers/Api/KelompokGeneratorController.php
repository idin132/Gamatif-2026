<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KelompokGeneratorController extends Controller
{
    /**
     * Mengecek dan mengembalikan kelompok mahasiswa yang sedang login.
     */
    public function getStatus(Request $request)
    {
        try {
            $mahasiswa = $request->user();

            if (!$mahasiswa) {
                return response()->json([
                    'message' => 'User tidak ditemukan.',
                    'kode' => 401,
                    'payload' => null,
                ], 401);
            }

            if ($mahasiswa->kelompok_id) {
                // Load relasi kelompok secara eksplisit
                $kelompok = Kelompok::find($mahasiswa->kelompok_id);

                if ($kelompok) {
                    return response()->json([
                        'message' => 'Anda sudah memiliki kelompok.',
                        'kode' => 200,
                        'payload' => $kelompok,
                    ]);
                }
            }

            // Jika belum punya kelompok
            return response()->json([
                'message' => 'Anda belum mendapatkan kelompok.',
                'kode' => 404,
                'payload' => null,
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error in getStatus: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'message' => 'Terjadi kesalahan pada server.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Menempatkan mahasiswa ke dalam kelompok secara adil.
     */
    public function generate(Request $request)
    {
        try {
            $mahasiswa = $request->user();

            if (!$mahasiswa) {
                return response()->json([
                    'message' => 'User tidak ditemukan.',
                    'kode' => 401,
                    'payload' => null,
                ], 401);
            }

            // Debug: Log informasi mahasiswa
            Log::info('Generate kelompok untuk mahasiswa ID: ' . $mahasiswa->id);
            Log::info('Current kelompok_id: ' . ($mahasiswa->kelompok_id ?? 'null'));

            // 1. Cek apakah mahasiswa sudah punya kelompok
            if ($mahasiswa->kelompok_id) {
                $kelompok = Kelompok::where('id', $mahasiswa->kelompok_id)->first();

                return response()->json([
                    'message' => 'Aksi gagal, Anda sudah terdaftar di sebuah kelompok.',
                    'kode' => 409, // 409 Conflict
                    'payload' => $kelompok ? [
                        'id' => $kelompok->id,
                        'nama_kelompok' => $kelompok->nama_kelompok,
                        'url_grub' => $kelompok->url_grub,
                    ] : null,
                ], 409);
            }

            $genderMahasiswa = $mahasiswa->jenis_kelamin;
            Log::info('Gender mahasiswa: ' . $genderMahasiswa);

            // 2. Pastikan ada kelompok yang tersedia
            $totalKelompok = Kelompok::count();
            Log::info('Total kelompok tersedia: ' . $totalKelompok);

            if ($totalKelompok === 0) {
                return response()->json([
                    'message' => 'Tidak ada kelompok yang tersedia.',
                    'kode' => 500
                ], 500);
            }

            // 3. Transaksi Database untuk menghindari race condition
            DB::beginTransaction();

            // 4. Cari kelompok yang paling ideal dengan logging yang lebih detail
            $kelompoksWithCounts = Kelompok::query()
                ->withCount(['mahasiswaBaru as count_gender' => function ($query) use ($genderMahasiswa) {
                    $query->where('jenis_kelamin', $genderMahasiswa);
                }])
                ->withCount('mahasiswaBaru as count_total')
                ->get();

            Log::info('Kelompoks with counts: ', $kelompoksWithCounts->toArray());

            $targetKelompok = $kelompoksWithCounts
                ->sortBy('count_gender')
                ->sortBy('count_total')
                ->first();

            if (!$targetKelompok) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Tidak ada kelompok yang cocok ditemukan.',
                    'kode' => 500
                ], 500);
            }

            Log::info('Target kelompok dipilih: ', [
                'id' => $targetKelompok->id,
                'nama' => $targetKelompok->nama_kelompok,
                'count_gender' => $targetKelompok->count_gender,
                'count_total' => $targetKelompok->count_total
            ]);

            // 5. Masukkan mahasiswa ke kelompok target
            $mahasiswa->kelompok_id = $targetKelompok->id;
            $saved = $mahasiswa->save();

            if (!$saved) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Gagal menyimpan data mahasiswa.',
                    'kode' => 500
                ], 500);
            }

            Log::info('Mahasiswa berhasil ditambahkan ke kelompok: ' . $targetKelompok->id);

            DB::commit();

            // 6. Kembalikan data kelompok yang baru didapat
            return response()->json([
                'message' => 'Selamat! Anda berhasil mendapatkan kelompok.',
                'kode' => 200,
                'payload' => [
                    'id' => $targetKelompok->id,
                    'nama_kelompok' => $targetKelompok->nama_kelompok,
                    'url_grub' => $targetKelompok->url_grub,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error in generate: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'message' => 'Terjadi kesalahan pada server saat generate kelompok.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}
