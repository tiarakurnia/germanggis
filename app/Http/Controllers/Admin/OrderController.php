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
        // Mengambil semua pesanan dan urutkan berdasarkan status (pending di atas, confirmed di bawah)
        $orders = Order::with('user', 'facility') // Mengambil relasi user dan facility
            ->orderByRaw("FIELD(status, 'Pending') DESC") // Menampilkan 'pending' terlebih dahulu
            ->orderBy('created_at', 'desc') // Pesanan terbaru di atas
            ->get();

        return view('admin.orders.index', compact('orders')); // Mengembalikan view dengan data pesanan
    }

    // Konfirmasi pesanan
    public function store($id)
    {
        $data = Order::find($id);

        if (empty($data)) {
            # code...
            return abort(404);
        }
        // Update status pesanan menjadi 'confirmed'
        $data->update([
            'status' => 'Confirmed',
            'updated_at' => now(), // Memastikan waktu pembaruan juga diperbarui
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan telah dikonfirmasi!'); // Redirect dengan pesan sukses
    }
    public function confirm($id)
    {
        // Temukan pesanan berdasarkan ID
        $order = Order::find($id);

        // Jika pesanan tidak ditemukan, tampilkan 404
        if (!$order) {
            return abort(404); 
        }

        // Update status pesanan menjadi 'Confirmed'
        $order->update([
            'status' => 'Confirmed',
            'updated_at' => now(), // Memastikan waktu pembaruan juga diperbarui
        ]);

        // Redirect ke halaman daftar pesanan dengan pesan sukses
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan telah dikonfirmasi!');
    }

    public function complete($id)
    {
        $order = Order::find($id);
        if (!$order) return abort(404);

        $order->update(['status' => 'Completed']);

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan telah diselesaikan!');
    }
    public function cancel($id)
    {
        $order = Order::find($id);
        if (!$order) return abort(404);

        $order->update(['status' => 'Canceled']);

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan telah dibatalkan!');
    }

}
