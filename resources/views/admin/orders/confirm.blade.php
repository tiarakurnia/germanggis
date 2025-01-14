@extends('layouts.admin')

@section('title', 'Konfirmasi Pesanan')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-4">Konfirmasi Pesanan #{{ $order->id }}</h1>

        <div class="mb-4">
            <h2 class="text-xl">Detail Pesanan</h2>
            <p><strong>Nama Pembeli:</strong> {{ optional($order->user)->name ?? '-' }}</p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        </div>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Konfirmasi
                Pesanan</button>
        </form>
    </div>
@endsection
