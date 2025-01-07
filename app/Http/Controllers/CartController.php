<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with('facility')->where('user_id', Auth::id())->get();
        $total = $cart->sum(function ($item) {
            return $item->facility->price * $item->quantity;
        });

        return view('cart.index', compact('cart', 'total'));
    }

    public function removeItem($id)
    {
        $item = Cart::where('id', $id)->where('user_id', Auth::id())->first();

        if ($item) {
            $item->delete();
            return back()->with('success', 'Item berhasil dihapus.');
        }

        return back()->with('error', 'Item tidak ditemukan.');
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $facility = Facility::find($request->facility_id);

        Cart::create([
            'user_id' => Auth::id(),
            'facility_id' => $facility->id,
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Item berhasil ditambahkan ke keranjang.');
    }

    public function checkout(Request $request)
    {
        if ($request->expectsJson()) {
            // Ambil data keranjang pengguna
            $cart = Cart::with('facility')->where('user_id', Auth::id())->get();

            // Cek apakah keranjang kosong
            if ($cart->isEmpty()) {
                return response()->json(['error' => 'Keranjang kosong.'], 400);
            }

            // Hitung total harga
            $total = $cart->sum(fn($item) => $item->facility->price * $item->quantity);

            // Setup Midtrans
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');
            \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is3ds');

            // Parameter transaksi
            $params = [
                'transaction_details' => [
                    'order_id' => uniqid(),
                    'gross_amount' => $total,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
            ];

            // Coba dapatkan Snap Token dari Midtrans
            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                return response()->json(['snapToken' => $snapToken]);
            } catch (\Exception $e) {
                Log::error('Midtrans error: ' . $e->getMessage());
                return response()->json(['error' => 'Gagal memproses pembayaran.'], 500);
            }
        }

        // Jika bukan permintaan JSON, kembalikan error
        return back()->with('error', 'Permintaan tidak valid.');
    }
    public function success()
    {
        return view('success');
    }
}
