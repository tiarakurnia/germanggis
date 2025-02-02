@extends('layouts.app')

@section('title', 'Keranjang Anda')

@section('content')
    <section class="py-16 bg-background text-primary">
        <div class="container mx-auto">
            <h1 class="text-4xl font-extrabold text-center mb-10">Keranjang Anda</h1>

            <!-- Keranjang -->
            <div id="cart-container" class="bg-primary text-background p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Detail Keranjang</h2>
                    <form action="{{ route('cart.clear') }}" method="POST" id="clear-cart-form">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 text-background px-4 py-2 rounded-lg hover:bg-red-600 transition">
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>
                <div id="cart-items" class="space-y-4">
                    @if ($cart->isEmpty())
                        <p class="text-center text-lg">Keranjang Anda kosong!</p>
                    @else
                        @foreach ($cart as $item)
                            <div class="flex justify-between items-center border-b border-background pb-2"
                                id="item-{{ $item->id }}">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <h4 class="font-semibold">{{ $item->facility->name }}</h4>
                                        <p class="text-sm">Rp {{ number_format($item->facility->price, 0, ',', '.') }} x
                                            {{ $item->quantity }}</p>
                                        <p class="text-sm">Tanggal Penyewaan: {{ $item->booking_date }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                        class="remove-item-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-background px-3 py-1 rounded-lg hover:bg-red-600 transition">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="flex justify-between items-center mt-6">
                    <h3 class="text-xl font-semibold">Total:</h3>
                    <p class="text-2xl font-bold">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>
                <form id="checkout-form">
                    @csrf
                    <button type="button" id="checkout-button"
                        class="bg-background text-primary w-full py-3 mt-6 rounded-lg shadow-lg hover:bg-white hover:text-primary transition">
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.getElementById('checkout-button').addEventListener('click', function() {
            const cartItems = [];
            const totalAmount = {{ $total }}; // Total dari server

            // Mengumpulkan data item dari keranjang
            document.querySelectorAll('#cart-items > div').forEach(item => {
                const facilityId = item.id.split('-')[1]; // Mendapatkan ID fasilitas
                const price = parseInt(item.querySelector('.text-sm').innerText.match(/Rp\s([\d,.]+)/)[1]
                    .replace(/\./g, '')); // Harga
                const quantity = parseInt(item.querySelector('.text-sm').innerText.split('x')[1]
                    .trim()); // Jumlah
                const bookingDate = item.querySelector('.text-sm:nth-of-type(2)').innerText.split(': ')[
                    1]; // Tanggal penyewaan

                cartItems.push({
                    facility_id: facilityId,
                    price: price,
                    quantity: quantity,
                    name: item.querySelector('h4').innerText // Mengambil nama dari DOM
                });
            });

            // Mengirim data checkout ke server
            fetch('{{ route('checkout.process') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        items: cartItems,
                        total_amount: totalAmount
                    })
                })
                .then(response => {
                    console.log(response); // Log respons untuk melihat status dan data
                    return response.json();
                })
                .then(data => {
                    if (data['snapToken']) {
                        // Inisialisasi pembayaran dengan Snap Midtrans
                        // window.snap.pay(data['snapToken'], {
                        //     onSuccess: function(result) {
                        //         // Kosongkan keranjang
                        //         clearCart();

                        //         Swal.fire({
                        //             title: "Pembayaran Berhasil",
                        //             text: "Terima kasih telah melakukan pembayaran.",
                        //             icon: "success",
                        //             timer: 2000,
                        //             showConfirmButton: false
                        //         }).then(() => {
                        //             location.reload(); // Refresh halaman
                        //         });
                        //     },
                        //     onPending: function(result) {
                        //         alert('Pembayaran pending. Mohon selesaikan pembayaran Anda.');
                        //         console.log('Pending:', result);
                        //         location.reload(); // Refresh halaman
                        //     },
                        //     onError: function(result) {
                        //         alert('Terjadi kesalahan dalam proses pembayaran.');
                        //         console.error('Error:', result);
                        //         location.reload(); // Refresh halaman
                        //     },
                        //     onClose: function() {
                        //         alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
                        //         location.reload(); // Refresh halaman
                        //     }
                        // }
                        window.snap.pay(data['snapToken'], {
                            onSuccess: function(result) {
                                fetch('{{ route('midtrans.callback') }}', { // Panggil endpoint callback
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        order_id: result.order_id,
                                        transaction_status: 'settlement',
                                    })
                                }).then(() => {
                                    Swal.fire({
                                        title: "Pembayaran Berhasil",
                                        text: "Terima kasih telah melakukan pembayaran.",
                                        icon: "success",
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload(); // Refresh halaman
                                    });
                                });
                            },
                            onPending: function(result) {
                                fetch('{{ route('midtrans.callback') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        order_id: result.order_id,
                                        transaction_status: 'pending',
                                    })
                                }).then(() => {
                                    alert('Pembayaran masih pending.');
                                    location.reload();
                                });
                            },
                            onError: function(result) {
                                fetch('{{ route('midtrans.callback') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        order_id: result.order_id,
                                        transaction_status: 'failure',
                                    })
                                }).then(() => {
                                    alert('Terjadi kesalahan dalam proses pembayaran.');
                                    location.reload();
                                });
                            },
                            onClose: function() {
                                alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
                                location.reload();
                            }
                        });
                    } else {
                        alert('Gagal mendapatkan Snap Token.');
                        console.error('Snap Token tidak tersedia atau tidak valid:', data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat melakukan checkout.');
                });
        });

        function clearCart() {
            fetch('{{ route('cart.clear') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Keranjang berhasil dikosongkan.');
                    } else {
                        console.error('Gagal mengosongkan keranjang.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endpush
