@extends('layouts.app')

@section('title', 'Transaksi Berhasil')

@section('content')
    <section class="py-16 bg-background text-primary">
        <div class="container mx-auto">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold mb-6" data-aos="fade-down">Terima Kasih!</h1>
                <p class="text-lg mb-6">Pesanan Anda berhasil diproses. Kami akan segera menghubungi Anda untuk pengiriman.
                </p>
                <a href="{{ route('beranda') }}"
                    class="bg-primary text-background px-6 py-3 rounded-lg shadow-lg hover:bg-green-700 transition">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>
@endsection
