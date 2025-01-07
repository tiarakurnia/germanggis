<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
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


    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        
        // Menambahkan role di sini, 'admin' bisa diganti dengan 'user'
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Password di-hash menggunakan Bcrypt
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect(route('home'))->with('success', 'Pendaftaran berhasil! Selamat datang.');
       }

    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Tautan reset password telah dikirim ke email Anda.')
            : back()->withErrors(['email' => 'Gagal mengirim tautan reset password.']);
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route('home'))->with('success', 'Berhasil keluar.');
    }

}
