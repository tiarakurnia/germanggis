<?php

namespace App\Http\Controllers;
use App\Models\User; // Pastikan untuk mengimpor model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Mencoba untuk login
        if (Auth::attempt($request->only('email', 'password'))) {
            // Ambil data user yang sedang login
            $user = Auth::user();

            if ($user->role == 'admin') {
                // Jika user adalah admin, arahkan ke dashboard admin
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil! Selamat datang Admin.');
            }

            // Jika bukan admin, arahkan ke halaman utama
            return redirect()->intended(route('home'))->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // Menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        
        // Menambahkan role di sini, 'admin' bisa diganti dengan 'user'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Password di-hash menggunakan Bcrypt
            'role' => 'user', // Default role adalah user
        ]);

        // Redirect ke halaman login setelah registrasi berhasil
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    // Proses logout
    public function logout()
    {
        Auth::logout();

        return redirect(route('home'))->with('success', 'Berhasil keluar.');
    }

}
