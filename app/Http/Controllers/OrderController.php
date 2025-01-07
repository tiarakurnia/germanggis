<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menyimpan pesanan dari user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        $totalPrice = $validated['quantity'] * $request->input('price');

        Order::create([
            'user_id' => Auth(),
            'facility_id' => $validated['facility_id'],
            'quantity' => $validated['quantity'],
            'date' => $validated['date'],
            'total_price' => $totalPrice,
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibuat!');
    }

    // Melihat pesanan masuk (khusus admin)
    public function index()
    {
        $orders = Order::with('user', 'facility')->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }
}
