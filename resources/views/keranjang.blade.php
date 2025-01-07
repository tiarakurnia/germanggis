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
                    <button id="clear-cart"
                        class="bg-red-500 text-background px-4 py-2 rounded-lg hover:bg-red-600 transition">
                        Kosongkan Keranjang
                    </button>
                </div>
                <div id="cart-items" class="space-y-4"></div>
                <div class="flex justify-between items-center mt-6">
                    <h3 class="text-xl font-semibold">Total:</h3>
                    <p id="cart-total" class="text-2xl font-bold">Rp 0</p>
                </div>
                <button id="checkout-btn"
                    class="bg-background text-primary w-full py-3 mt-6 rounded-lg shadow-lg hover:bg-white hover:text-primary transition">
                    Checkout
                </button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const cartItemsContainer = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const checkoutBtn = document.getElementById('checkout-btn');
        const clearCartBtn = document.getElementById('clear-cart');

        // Load keranjang dari localStorage
        const loadCart = () => {
            try {
                const cartData = localStorage.getItem('cart');
                const cart = cartData ? JSON.parse(cartData) : [];

                cartItemsContainer.innerHTML = '';
                let total = 0;

                if (cart.length === 0) {
                    cartItemsContainer.innerHTML = '<p class="text-center text-lg">Keranjang Anda kosong!</p>';
                    cartTotal.textContent = 'Rp 0';
                    return;
                }

                cart.forEach((item, index) => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;

                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('flex', 'justify-between', 'items-center', 'border-b',
                        'border-background', 'pb-2');
                    itemDiv.innerHTML = `
                        <div class="flex items-center space-x-4">
                            <div>
                                <h4 class="font-semibold">${item.name}</h4>
                                <p class="text-sm">Rp ${item.price.toLocaleString()} x ${item.quantity}</p>
                                <p class="text-sm">Tanggal Penyewaan: ${item.date}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="bg-red-500 text-background px-3 py-1 rounded-lg hover:bg-red-600 transition" onclick="removeFromCart(${index})">Hapus</button>
                        </div>
                    `;
                    cartItemsContainer.appendChild(itemDiv);
                });

                cartTotal.textContent = `Rp ${total.toLocaleString()}`;
            } catch (error) {
                console.error('Terjadi kesalahan saat memuat keranjang:', error);
                alert('Terjadi kesalahan saat memuat keranjang.');
            }
        };

        // Hapus item dari keranjang
        const removeFromCart = (index) => {
            try {
                const cartData = localStorage.getItem('cart');
                const cart = cartData ? JSON.parse(cartData) : [];
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                loadCart();
            } catch (error) {
                console.error('Terjadi kesalahan saat menghapus item:', error);
                alert('Terjadi kesalahan saat menghapus item.');
            }
        };

        // Kosongkan keranjang
        clearCartBtn.addEventListener('click', () => {
            try {
                localStorage.removeItem('cart');
                loadCart();
            } catch (error) {
                console.error('Terjadi kesalahan saat mengosongkan keranjang:', error);
                alert('Terjadi kesalahan saat mengosongkan keranjang.');
            }
        });

        // Proses Checkout
        document.getElementById('checkout-btn').onclick = function() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            if (cart.length === 0) {
                alert('Keranjang Anda kosong!');
                return;
            }

            fetch('{{ route('checkout.process') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        items: cart,
                        total_amount: cart.reduce((total, item) => total + item.price * item.quantity, 0)
                    })
                })
                .then(response => {
                    console.log(response); // Log respons untuk melihat apa yang diterima
                    if (!response.ok) {
                        throw new Error('Terjadi kesalahan saat memproses checkout.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.snapToken) {
                        // Proses pembayaran dengan snapToken
                        window.snap.pay(data.snapToken);
                    } else {
                        alert('Gagal mendapatkan Snap Token.');
                        console.error('Snap Token tidak tersedia atau tidak valid');
                    }
                })
                .catch(error => {
                    console.error('Terjadi kesalahan: ', error);
                    alert('Terjadi kesalahan: ' + error.message);
                });
        };

        // Inisialisasi keranjang
        loadCart();
    </script>
@endpush
