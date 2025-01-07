@extends('layouts.auth')

@section('title', 'Daftar - Wisata Germanggis')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-accent via-primary to-accent">
        <div class="bg-background p-8 rounded-lg shadow-lg max-w-md w-full" data-aos="zoom-in" data-aos-duration="1000">
            <h2 class="text-3xl font-extrabold text-primary text-center mb-6">Daftar</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-primary font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-4 py-2 rounded-lg border text-primary" required>
                </div>
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
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-primary font-semibold mb-2">Konfirmasi
                        Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-2 rounded-lg border text-primary" required>
                </div>
                <button type="submit"
                    class="w-full bg-primary text-background py-3 rounded-lg font-bold hover:bg-white hover:text-primary transition">
                    Daftar
                </button>
            </form>
            <p class="mt-6 text-sm text-center text-primary">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-accent font-semibold hover:underline">Masuk</a>
            </p>
        </div>
    </div>
@endsection
