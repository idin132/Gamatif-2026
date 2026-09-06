<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalKegiatan;
use Illuminate\Http\Request;

class JadwalKegiatanController extends Controller
{
    public function index()
    {
        $jadwalKegiatan = JadwalKegiatan::all();

        return response()->json([
            'message' => 'Data jadwal kegiatan berhasil diambil',
            'code' => 200,
            'payload' => $jadwalKegiatan,
        ]);
    }
}
