<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KritikSaran;
use Illuminate\Http\Request;

class KritikSaranController extends Controller
{
    // POST /api/kritik-saran - simpan kritik saran
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'pesan' => 'required|string',
        ]);

        KritikSaran::create($validated);

        return response()->json([
            'message' => 'Kritik dan saran berhasil dikirim',
        ]);
    }
}
