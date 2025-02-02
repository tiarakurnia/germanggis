<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Facility;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;

class CartController extends Controller
{
    public function index()
    {
        // Mengambil semua item di keranjang untuk pengguna yang sedang login
        $cart = Cart::with('facility')->where('user_id', Auth::id())->get();

        // Menghitung total harga semua item di keranjang
        $total = $cart->sum(function ($item) {
            return $item->facility->price * $item->quantity;
        });

        // Mengembalikan view keranjang dengan data item dan total
        return view('cart.index', compact('cart', 'total'));
    }

    public function removeItem($id)
    {
        // Mencari item di keranjang berdasarkan ID dan user_id
        $item = Cart::where('id', $id)->where('user_id', Auth::id())->first();

        if ($item) {
            // Menghapus item dari keranjang
            $item->delete();
            return back()->with('success', 'Item berhasil dihapus.');
        }

        return back()->with('error', 'Item tidak ditemukan.');
    }
    public function add(Request $request)
    {
        // Validasi input
        $request->validate([
            'facility_id' => 'required|integer|exists:facilities,id',
            'quantity' => 'required|integer|min:1',
            'booking_date' => 'required|date',
        ]);

        // Mencari fasilitas berdasarkan ID
        $facility = Facility::find($request->facility_id);

        // Logika untuk menambahkan item ke keranjang di database
        // Cek apakah item sudah ada di keranjang
        $cartItem = Cart::where('user_id', Auth::user()->id)
            ->where('facility_id', $facility->id)
            ->where('booking_date', $request->booking_date) // Cek tanggal pemesanan
            ->first();

        if ($cartItem) {
            // Jika item sudah ada, update quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Jika item belum ada, buat item baru di keranjang
            Cart::create([
                'user_id' => Auth::user()->id,
                'facility_id' => $facility->id,
                'name' => $facility->name,
                'price' => $facility->price,
                'quantity' => $request->quantity,
                'booking_date' => $request->booking_date,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function checkout(Request $request)
    {
        // Setup Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $cartItems = Cart::with('facility')->where('user_id', Auth::id())->get();

        $nameParts = explode(' ', Auth::user()->name, 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        $transactionDetails = [
            'order_id' => 'ORDER-' . uniqid(),
            'gross_amount' => $request->total_amount,
        ];

        $itemDetails = [];
        foreach ($cartItems as $item) {
            $itemDetails[] = [
                'id' => uniqid(),
                'price' => intval($item->facility->price),
                'quantity' => $item->quantity,
                'name' => $item->facility->name,
            ];
        }

        $customerDetails = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => Auth::user()->email,
            'phone' => '08123456789',
        ];

        // Data untuk Snap
        $params = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            // Dapatkan Snap Token
            $snapToken = Snap::getSnapToken($params);
            foreach ($cartItems as $item) {
                $facility = $item->facility;
                Order::create([
                    'user_id' => Auth::id(),
                    'facility_id' => $facility->id,
                    'name' => $facility->name,
                    'price' => $facility->price,
                    'quantity' => $item->quantity,
                    'total' => $facility->price * $item->quantity,
                    'status' => 'pending',
                    'order_date' => now(),
                    'booking_date' => $item->booking_date,
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();

            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function clearCart()
    {
        // Menghapus semua item di keranjang untuk pengguna yang sedang login
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
