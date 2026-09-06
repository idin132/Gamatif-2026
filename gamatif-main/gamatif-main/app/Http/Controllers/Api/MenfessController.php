<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menfess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenfessController extends Controller
{
    public function index()
    {
        try {
            $menfesses = Menfess::latest()->get();

            return response()->json([
                'code' => 200,
                'message' => 'Success retrieving all menfess data',
                'payload' => $menfesses
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Internal Server Error',
                'payload' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'to' => 'required|string|max:255',
            'message' => 'required|string',
            'from' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422, // Unprocessable Entity
                'message' => 'Validation failed',
                'payload' => $validator->errors()
            ], 422);
        }

        try {
            // Buat menfess baru
            $menfess = Menfess::create([
                'to' => $request->to,
                'message' => $request->message,
                'from' => $request->from ?? 'Anonymous', // Jika 'from' tidak ada, isi dengan 'Anonymous'
            ]);

            return response()->json([
                'code' => 201, // Created
                'message' => 'Menfess created successfully',
                'payload' => $menfess
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Internal Server Error',
                'payload' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $menfess = Menfess::find($id);

            if (!$menfess) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Menfess not found',
                    'payload' => null
                ], 404);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Success retrieving menfess detail',
                'payload' => $menfess
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Internal Server Error',
                'payload' => $e->getMessage()
            ], 500);
        }
    }
}
