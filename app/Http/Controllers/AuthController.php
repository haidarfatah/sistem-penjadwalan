<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menangani login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Cek apakah login berhasil
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard'); // Jika berhasil, arahkan ke dashboard
        }

        // Jika gagal login, tampilkan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Logout pengguna
    public function logout()
    {
        Auth::logout();
        return redirect('/login'); // Redirect ke halaman login setelah logout
    }
}
