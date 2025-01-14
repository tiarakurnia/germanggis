<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Facility; // Pastikan untuk mengimpor model Facility
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Menyimpan pesanan dari user
    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        // Mengambil fasilitas berdasarkan ID
        $facility = Facility::find($validated['facility_id']);
        
        // Menghitung total harga
        $totalPrice = $validated['quantity'] * $facility->price;

        // Membuat pesanan baru
        Order::create([
            'user_id' => Auth::id(), // Mengambil ID pengguna yang sedang login
            'facility_id' => $validated['facility_id'],
            'quantity' => $validated['quantity'],
            'booking_date' => $validated['date'], // Menggunakan 'booking_date' sesuai dengan skema
            'total' => $totalPrice,
            'status' => 'pending', // Status awal pesanan
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibuat!');
    }

    public function index()
    {
        // Mengambil semua pesanan dengan relasi user dan facility
        $orders = Order::with('user', 'facility')->latest()->get();

        // Mengembalikan view dengan data pesanan
        return view('orders.index', compact('orders')); // Pastikan untuk menyesuaikan nama view
    }
}
