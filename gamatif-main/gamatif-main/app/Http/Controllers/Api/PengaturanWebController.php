<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PengaturanWeb;
use Illuminate\Http\Request;

class PengaturanWebController extends Controller
{
    // GET /api/pengaturan-web - ambil semua data PengaturanWeb
    public function index()
    {
        try {
            $pengaturanWeb = PengaturanWeb::all();

            return response()->json([
                'message' => 'Berhasil mengambil data pengaturan web.',
                'code' => 200,
                'payload' => $pengaturanWeb
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server saat mengambil data pengaturan web.',
                'code' => 500,
                'payload' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }
}
