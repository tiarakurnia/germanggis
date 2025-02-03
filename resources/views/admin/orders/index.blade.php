@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-4">Daftar Pesanan</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left border">No. Pesanan</th>
                    <th class="px-4 py-2 text-left border">Nama Pembeli</th>
                    <th class="px-4 py-2 text-left border">Fasilitas</th>
                    <th class="px-4 py-2 text-left border">Jumlah</th>
                    <th class="px-4 py-2 text-left border">Total Harga</th>

                    <!-- Tombol Sorting untuk Tanggal Pemesanan -->
                    <th class="px-4 py-2 text-left border">
                        <a href="{{ route('admin.orders.index', ['sort' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                            class="flex items-center">
                            Tanggal Pemesanan
                            @if ($sortOrder === 'asc')
                                <i class="fas fa-sort-up ml-1"></i>
                            @else
                                <i class="fas fa-sort-down ml-1"></i>
                            @endif
                        </a>
                    </th>

                    <th class="px-4 py-2 text-left border">Status</th>
                    <th class="px-4 py-2 text-center border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border-b">
                        <td class="px-4 py-2 border">{{ $order->id }}</td>
                        <td class="px-4 py-2 border">{{ optional($order->user)->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ optional($order->facility)->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $order->quantity }}</td>
                        <td class="px-4 py-2 border">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border">{{ $order->booking_date }}</td>
                        <td class="px-4 py-2 border">{{ ucfirst($order->status) }}</td>
                        <td class="px-4 py-2 text-center border">
                            <div class="flex flex-row justify-center items-center space-x-2">
                                @if ($order->status === 'pending')
                                    <!-- Tombol Konfirmasi dan Cancel untuk status Pending -->
                                    <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>
                                @elseif ($order->status === 'Confirmed')
                                    <!-- Tombol Selesaikan untuk status Confirmed -->
                                    <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                            <i class="fas fa-check"></i> Selesaikan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
