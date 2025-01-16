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
            ->orderByRaw("FIELD(status, 'pending') DESC") // Menampilkan 'pending' terlebih dahulu
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
            'status' => 'confirmed',
            'updated_at' => now(), // Memastikan waktu pembaruan juga diperbarui
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan telah dikonfirmasi!'); // Redirect dengan pesan sukses
    }
}
