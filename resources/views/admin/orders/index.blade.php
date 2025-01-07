@extends('layouts.admin')

@section('title', 'Konfirmasi Pesanan')

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
                    <th class="px-4 py-2 text-left">Total Harga</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $order->order_id }}</td>
                        <td class="px-4 py-2">{{ $order->customer_name }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="px-4 py-2 text-center">
                            <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Konfirmasi</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
