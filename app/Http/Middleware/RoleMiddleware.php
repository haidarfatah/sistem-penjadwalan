<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['Anda harus login dulu.']);
        }

        // Cek apakah peran user sesuai dengan yang diminta
        if (Auth::user()->role !== $role) {
            return redirect('/home')->withErrors(['Anda tidak memiliki akses ke halaman ini.']);
        }

        return $next($request);
    }
}
