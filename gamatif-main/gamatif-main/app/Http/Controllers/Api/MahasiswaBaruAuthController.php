<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBaru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\MahasiswaBaruRegistered;
use Illuminate\Validation\ValidationException;
use Exception;

class MahasiswaBaruAuthController extends Controller
{
    public function register(Request $request)
    {
        DB::beginTransaction();

        try {
            // --- PERUBAHAN VALIDASI DI SINI ---
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'nim' => 'required|string|unique:mahasiswa_baru,nim',
                'jenis_kelamin' => 'required|in:L,P',
                'tanggal_lahir' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) {
                        try {
                            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $value);
                            if (!$date || $date->format('Y-m-d') !== $value) {
                                $fail('Format tanggal lahir tidak valid.');
                            }
                        } catch (\Exception $e) {
                            $fail('Format tanggal lahir tidak valid.');
                        }
                    },
                ],
                'alamat' => 'required|string',
                'nomor_whatsapp' => 'required|string',
                'email' => 'required|email|unique:mahasiswa_baru,email',

                // Validasi untuk file bukti registrasi (satu file)
                'bukti_registrasi' => 'required|file|mimes:png,jpg,pdf|max:2048', // max 2MB

                // Validasi untuk bukti sosmed (harus berupa array file)
                'bukti_sosmed' => 'required|array',
                'bukti_sosmed.*' => 'required|file|mimes:png,jpg,pdf|max:2048', // max 2MB per file
            ]);

            // --- LOGIKA UPLOAD FILE ---

            // 1. Handle upload untuk bukti_registrasi (single file)
            if ($request->hasFile('bukti_registrasi')) {
                // Simpan file ke 'storage/app/public/bukti_registrasi'
                $pathRegistrasi = $request->file('bukti_registrasi')->store('bukti_registrasi', 'public');
                $validatedData['bukti_registrasi'] = $pathRegistrasi;
            }

            // 2. Handle upload untuk bukti_sosmed (multiple files)
            if ($request->hasFile('bukti_sosmed')) {
                $sosmedPaths = [];
                foreach ($request->file('bukti_sosmed') as $file) {
                    // Simpan setiap file ke 'storage/app/public/bukti_sosmed'
                    $path = $file->store('bukti_sosmed', 'public');
                    $sosmedPaths[] = $path;
                }
                $validatedData['bukti_sosmed'] = $sosmedPaths; // $sosmedPaths sudah berbentuk array
            }

            // Generate password random
            $plainPassword = Str::random(8);
            $validatedData['password'] = Hash::make($plainPassword);
            $validatedData['status'] = false;

            // Simpan data mahasiswa
            $mahasiswa = MahasiswaBaru::create($validatedData);

            // Kirim email - jika gagal, rollback
            try {
                Mail::to($mahasiswa->email)->send(
                    new MahasiswaBaruRegistered($mahasiswa->nama_lengkap, $mahasiswa->email, $plainPassword)
                );
            } catch (Exception $e) {
                Log::error('Email sending failed during registration', [
                    'user_id' => $mahasiswa->id ?? null,
                    'email' => $mahasiswa->email ?? null,
                    'error' => $e->getMessage(),
                ]);
                DB::rollBack();
                // Opsional: Hapus file yang sudah diupload jika email gagal
                // Storage::disk('public')->delete($validatedData['bukti_registrasi']);
                // Storage::disk('public')->delete($validatedData['bukti_sosmed']);
                return response()->json([
                    'message' => 'Gagal mengirim email pendaftaran. Silakan coba lagi.',
                    'kode' => 500,
                    'payload' => null
                ], 500);
            }

            DB::commit();

            return response()->json([
                'message' => 'Registrasi berhasil! Silakan cek email Anda untuk password akun dan tunggu aktivasi dari panitia.',
                'kode' => 201,
                'payload' => $mahasiswa,
            ], 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Data yang Anda masukkan tidak valid.',
                'kode' => 422,
                'payload' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Registration failed with server error', [
                'request_data' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan pada server. Silakan coba beberapa saat lagi.',
                'kode' => 500,
                'payload' => null
            ], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $mahasiswa = MahasiswaBaru::with('kelompok')->where('email', $request->email)->first();


            if (!$mahasiswa || !Hash::check($request->password, $mahasiswa->password)) {
                return response()->json([
                    'message' => 'Email atau password salah.',
                    'kode' => 401,
                    'payload' => null,
                ], 401);
            }

            if (!$mahasiswa->status) {
                return response()->json([
                    'message' => 'Akun Anda belum aktif. Silakan tunggu konfirmasi panitia.',
                    'kode' => 403,
                    'payload' => null,
                ], 403);
            }

            $token = $mahasiswa->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil.',
                'kode' => 200,
                'payload' => [
                    'token' => $token,
                    'user' => $mahasiswa,
                ],
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Data login tidak valid.',
                'kode' => 422,
                'payload' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server saat login.',
                'kode' => 500,
                'payload' => [
                    'error' => $e->getMessage(),
                ]
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout berhasil.',
                'kode' => 200,
                'payload' => null,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat logout.',
                'kode' => 500,
                'payload' => [
                    'error' => $e->getMessage(),
                ]
            ], 500);
        }
    }

    public function me(Request $request)
    {
        try {
            return response()->json([
                'message' => 'User data retrieved.',
                'kode' => 200,
                'payload' => [
                    'user' => $request->user()->load('kelompok'),

                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data user.',
                'kode' => 500,
                'payload' => [
                    'error' => $e->getMessage(),
                ]
            ], 500);
        }
    }
}
