<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use App\Models\Order; 

class MidtransController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production';
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Request $request)
    {
        $cartItems = $request->input('cart'); // Ambil data keranjang dari request

        if (empty($cartItems)) {
            return response()->json(['error' => 'Keranjang kosong!'], 400);
        }

        // Menghitung total harga keranjang
        $grossAmount = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cartItems));

        if ($grossAmount < 0.01) {
            return response()->json(['error' => 'Total harus lebih dari 0.01.'], 400);
        }

        // Buat order_id unik
        $orderId = 'ORDER-' . time();

        // Detail transaksi
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $grossAmount,
        ];

        // Detail pelanggan
        $customerDetails = [
            'first_name' => $request->user()->name,
            'email' => $request->user()->email,
            'phone' => $request->user()->phone ?? '08123456789',
        ];

        // Detail item dalam keranjang
        $items = array_map(function ($item) {
            return [
                'id' => $item['id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'name' => $item['name'],
            ];
        }, $cartItems);

        // Data transaksi yang dikirim ke Midtrans
        $transactionData = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $items,
        ];

        try {
            // Buat Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($transactionData);
            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());

            return response()->json(['error' => 'Terjadi kesalahan saat membuat transaksi.'], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        $notification = new \Midtrans\Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;

        // Update status transaksi berdasarkan status yang diterima
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // Update status transaksi menjadi berhasil
            Log::info("Transaksi berhasil: {$orderId}");
        } elseif ($transactionStatus == 'pending') {
            // Transaksi tertunda
            Log::info("Transaksi tertunda: {$orderId}");
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'cancel' || $transactionStatus == 'expire') {
            // Transaksi gagal
            Log::info("Transaksi gagal: {$orderId}");
        }

        return response()->json(['status' => 'OK']);
    }
    public function callback(Request $request)
    {
        // Ambil notifikasi dari Midtrans
        $notif = new Notification();

        // Ambil order berdasarkan ID yang dikirim dari Midtrans
        $order = Order::where('id', $notif->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        // Cek status transaksi dari Midtrans
        if ($notif->transaction_status == 'settlement') {
            // Pembayaran sukses, ubah status pesanan menjadi "confirmed"
            $order->update(['status' => 'confirmed']);
        } elseif ($notif->transaction_status == 'pending') {
            // Jika masih pending, biarkan status tetap "pending"
            $order->update(['status' => 'pending']);
        } elseif (in_array($notif->transaction_status, ['cancel', 'expire', 'failure'])) {
            // Jika gagal, batalkan pesanan
            $order->update(['status' => 'canceled']);
        }

        return response()->json(['message' => 'Status pesanan diperbarui']);
    }
}