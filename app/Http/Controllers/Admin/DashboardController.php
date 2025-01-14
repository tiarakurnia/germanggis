<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total pengguna
        $totalUsers = User::count();

        // Mengambil total pendapatan bulan ini
        $totalRevenue = Order::whereMonth('created_at', now()->month)
            ->sum('total');

        // Mengambil jumlah pesanan baru bulan ini
        $newOrders = Order::whereMonth('created_at', now()->month)->count();

        // Mengambil data penjualan bulanan
        $salesData = Order::select(DB::raw('SUM(total) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total');

        $months = Order::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('month');

        // Debugging: Uncomment the line below to check variable values
        // dd(compact('totalUsers', 'totalRevenue', 'newOrders', 'salesData', 'months'));

        return view('admin.dashboard', compact('totalUsers', 'totalRevenue', 'newOrders', 'salesData', 'months'));
    }
}