<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user yang terautentikasi memiliki role 'user' atau 'admin'
        if (Auth::check()) {
            // Jika pengguna adalah admin, arahkan ke dashboard admin
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            }
            // Jika pengguna adalah user, lanjutkan ke rute yang diminta
            return $next($request);
        }

        // Jika pengguna tidak terautentikasi, arahkan ke halaman beranda
        return redirect()->route('home')->with('error', 'You need to login first.');
    }
}