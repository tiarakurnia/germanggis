@extends('layouts.auth')

@section('title', 'Masuk - Wisata Germanggis')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary via-accent to-primary">
        <div class="bg-background p-8 rounded-lg shadow-lg max-w-md w-full" data-aos="fade-up" data-aos-duration="1000">
            <h2 class="text-3xl font-extrabold text-primary text-center mb-6">Masuk</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-primary font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-2 rounded-lg border text-primary" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-primary font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 rounded-lg border text-primary" required>
                </div>
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('password.request') }}" class="text-sm text-accent hover:underline">Lupa Password?</a>
                </div>
                <button type="submit"
                    class="w-full bg-primary text-background py-3 rounded-lg font-bold hover:bg-white hover:text-primary transition">
                    Masuk
                </button>
            </form>
            <p class="mt-6 text-sm text-center text-primary">
                Belum punya akun? <a href="{{ route('register') }}"
                    class="text-accent font-semibold hover:underline">Daftar</a>
            </p>
        </div>
    </div>
@endsection
