<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user yang terautentikasi memiliki role 'admin'
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }
        return redirect()->route('home')->with('error', 'You do not have admin access.');
    }
}
