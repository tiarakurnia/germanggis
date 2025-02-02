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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Periksa apakah email ada di database
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            // Email tidak ditemukan
            return back()->withErrors(['email' => 'Email salah.'])->withInput();
        }

        // Periksa apakah password cocok
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        // Login berhasil, arahkan user sesuai role
        $user = Auth::user();

        if ($user->role == 'admin') {
            // Jika user adalah admin, arahkan ke dashboard admin
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
        }

        // Jika bukan admin, arahkan ke halaman utama
        return redirect()->intended(route('home'))->with('success', 'Login berhasil!');
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
        ],[
            // Pesan error kustom
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan, silakan gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus terdiri dari 6 karakter.',
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
