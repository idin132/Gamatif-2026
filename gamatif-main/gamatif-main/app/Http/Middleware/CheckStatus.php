<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user(); // ambil user yang login (guard default)

        if ($user && !$user->status) {
            // Jika akun belum aktif, redirect ke halaman khusus
            return redirect()->route('akun.belum-aktif');
        }

        return $next($request);
    }
}
