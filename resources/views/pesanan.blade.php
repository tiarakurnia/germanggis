@extends('layouts.app')

@section('title', 'Pesanan Anda')

@section('content')
    <section class="py-16 bg-background text-primary">
        <div class="container mx-auto">
            <h1 class="text-4xl font-extrabold text-center mb-10">Pesanan Anda</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if ($orders->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders as $order)
                        <div class="bg-white shadow-lg rounded-lg p-6">
                            <img src="{{ $order->facility->image }}" alt="{{ $order->facility->name }}"
                                class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-bold">{{ $order->facility->name }}</h3>
                            <p class="text-sm text-gray-700 mb-2">{{ $order->facility->description }}</p>
                            <p class="text-lg font-bold">Rp{{ number_format($order->price, 0, ',', '.') }} x
                                {{ $order->quantity }}</p>
                            <p class="text-lg font-bold mt-2">Total: Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                            @if ($order->booking_date)
                                <p class="text-sm text-gray-500 mt-2">Tanggal: {{ $order->booking_date }}</p>
                            @endif
                            {{-- Status Pesanan --}}
                            @if ($order->status == 'Canceled')
                                <p class="text-red-500 font-bold">Pesanan dibatalkan oleh admin</p>
                                <a href="https://wa.me/628816735135?text=Halo Admin, saya ingin mengajukan refund untuk pesanan saya dengan ID: {{ $order->id }}"
                                    class="block mt-2 bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-600">
                                    Hubungi Admin untuk Refund
                                </a>
                            @elseif ($order->status == 'Pending')
                                <button class="mt-4 bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600">
                                    {{ ucfirst($order->status) }}
                                </button>
                            @elseif ($order->status == 'Confirmed')
                                <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                                    {{ ucfirst($order->status) }}
                                </button>
                            @elseif ($order->status == 'Completed')
                                <button class="mt-4 bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                                    {{ ucfirst($order->status) }}
                                </button>
                            @endif

                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-lg">Belum ada pesanan. Silakan lakukan checkout.</p>
            @endif
        </div>
    </section>
@endsection
