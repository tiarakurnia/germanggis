@extends('layouts.auth')

@section('title', 'Lupa Password - Wisata Germanggis')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary via-background to-accent">
        <div class="bg-background p-8 rounded-lg shadow-lg max-w-md w-full" data-aos="flip-left" data-aos-duration="1000">
            <h2 class="text-3xl font-extrabold text-primary text-center mb-6">Lupa Password</h2>
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-primary font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-2 rounded-lg border text-primary" required>
                </div>
                <button type="submit"
                    class="w-full bg-primary text-background py-3 rounded-lg font-bold hover:bg-accent hover:text-primary transition">
                    Kirim Tautan Reset Password
                </button>
            </form>
            <p class="mt-6 text-sm text-center text-primary">
                <a href="{{ route('login') }}" class="text-accent font-semibold hover:underline">Kembali ke Login</a>
            </p>
        </div>
    </div>
@endsection
