<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan
    public function index(Request $request)
    {
        //parameter sorting dari request, default-nya 'desc' (terbaru ke terlama)
        $sortOrder = $request->query('sort', 'desc');

        // Mengambil semua pesanan dan urutkan berdasarkan status (pending di atas, confirmed di bawah)
        $orders = Order::with('user', 'facility') // Mengambil relasi user dan facility
            ->orderByRaw("FIELD(status, 'Pending') DESC") // Menampilkan 'pending' terlebih dahulu
            ->orderBy('booking_date', $sortOrder) // Sort berdasarkan booking_date
            ->orderBy('created_at', 'desc') // Pesanan terbaru di atas
            ->get();

        return view('admin.orders.index', compact('orders', 'sortOrder')); 
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
