@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Welcome, Admin!</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Card 1: Total Users -->
        <div class="bg-blue-500 text-white p-4 rounded shadow">
            <h2 class="text-lg font-bold">Users</h2>
            <p class="text-sm">Total: {{ $totalUsers }}</p>
        </div>

        <!-- Card 2: Total Revenue -->
        <div class="bg-green-500 text-white p-4 rounded shadow">
            <h2 class="text-lg font-bold">Revenue</h2>
            <p class="text-sm">Rp{{ number_format($totalRevenue, 0, ',', '.') }} this month</p>
        </div>

        <!-- Card 3: New Orders -->
        <div class="bg-yellow-500 text-white p-4 rounded shadow">
            <h2 class="text-lg font-bold">New Orders</h2>
            <p class="text-sm">{{ $newOrders }}</p>
        </div>
    </div>
@endsection

