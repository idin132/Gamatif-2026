<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SosialMedia;
use Illuminate\Http\Request;

class SosialMediaController extends Controller
{
    // GET /api/sosial-media - ambil semua data SosialMedia
    public function index()
    {
        try {
            $sosialMedia = SosialMedia::all();

            return response()->json([
                'message' => 'Berhasil mengambil data sosial media.',
                'code' => 200,
                'payload' => $sosialMedia
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server saat mengambil data sosial media.',
                'code' => 500,
                'payload' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }
}
