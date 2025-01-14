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

        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">No. Pesanan</th>
                    <th class="px-4 py-2 text-left">Nama Pembeli</th>
                    <th class="px-4 py-2 text-left">Fasilitas</th>
                    <th class="px-4 py-2 text-left">Jumlah</th>
                    <th class="px-4 py-2 text-left">Total Harga</th>
                    <th class="px-4 py-2 text-left">Tanggal Pemesanan</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ optional($order->user)->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ optional($order->facility)->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $order->quantity }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="px-4 py-2 text-center">
                            @if ($order->status === 'pending')
                                <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Konfirmasi</button>
                                </form>
                            @else
                                <span class="text-gray-500">Dikonfirmasi</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
