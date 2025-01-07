<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan
    public function index()
    {
        // Mengambil semua pesanan yang belum dikonfirmasi
        $orders = Order::where('status', 'pending')->get(); // Bisa disesuaikan dengan status pesanan Anda

        return view('admin.orders.index', compact('orders'));
    }

    // Konfirmasi pesanan
    public function confirm(Order $order)
    {
        // Perbarui status pesanan menjadi 'confirmed'
        $order->status = 'confirmed';
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan telah dikonfirmasi.');
    }
}
