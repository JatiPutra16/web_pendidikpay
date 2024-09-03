<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum, redirect ke halaman login
            return redirect()->route('login');
        }

        // Jika sudah, lanjutkan permintaan
        return $next($request);
    }
}
