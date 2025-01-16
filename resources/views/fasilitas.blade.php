@extends('layouts.app')

@section('title', 'Fasilitas')

@section('content')
    <section class="py-16 bg-background text-primary">
        <div class="container mx-auto">
            <h1 class="text-4xl font-extrabold text-center mb-10">Fasilitas Wisata Germanggis</h1>

            <!-- Tabs Navigation -->
            <div class="flex border-b border-gray-300 justify-center space-x-4 mb-10">
                @foreach ($categories as $categoryName => $items)
                    <button class="category-tab bg-primary text-background px-6 py-3 rounded-lg"
                        data-category="{{ Str::slug($categoryName) }}">
                        {{ ucwords($categoryName) }}
                    </button>
                @endforeach
            </div>

            <!-- Tabs Content -->
            <div>
                @foreach ($categories as $categoryName => $items)
                    <div id="tabpanel-{{ Str::slug($categoryName) }}"
                        class="category-content {{ $loop->first ? 'block' : 'hidden' }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($items as $item)
                                <div class="p-4 bg-white shadow rounded-lg">
                                    <img src="{{ $item->image }}" alt="{{ $item->name }}"
                                        class="w-full h-48 object-cover rounded-lg mb-4">
                                    <h3 class="text-xl font-semibold">{{ $item->name }}</h3>
                                    <p class="text-sm text-gray-700">{!! nl2br(e($item->description)) !!}</p>
                                    <p class="text-lg font-bold mt-2">Rp{{ number_format($item->price, 0, ',', '.') }}</p>

                                    <label for="quantity-{{ $item->id }}" class="block mt-2">Jumlah Produk:</label>
                                    <input type="number" id="quantity-{{ $item->id }}"
                                        class="w-full border rounded-lg px-4 py-2 mt-2" min="1" value="1">

                                    <label for="booking-date-{{ $item->id }}" class="block mt-4 text-sm">Tanggal
                                        Pemesanan:</label>
                                    <input type="date" id="booking-date-{{ $item->id }}"
                                        class="w-full border rounded-lg px-4 py-2 mt-2"
                                        min="{{ \Carbon\Carbon::today()->toDateString() }}">

                                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded-lg hover:bg-accent"
                                        onclick="addToCart({{ $item->id }}, '{{ $item->name }}', {{ $item->price }}, document.getElementById('quantity-{{ $item->id }}').value, document.getElementById('booking-date-{{ $item->id }}').value)">
                                        Tambah ke Keranjang
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Function to switch tabs
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.category-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    const categorySlug = this.getAttribute('data-category');

                    // Hapus kelas aktif dari semua tab
                    document.querySelectorAll('.category-tab').forEach(tab => {
                        tab.classList.remove('bg-accent', 'text-white');
                        tab.classList.add('bg-primary', 'text-background');
                    });
                    this.classList.add('bg-accent', 'text-white'); // Tab yang aktif

                    // Sembunyikan semua konten kategori
                    document.querySelectorAll('.category-content').forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Tampilkan konten kategori yang dipilih
                    const selectedTabContent = document.getElementById('tabpanel-' + categorySlug);
                    if (selectedTabContent) {
                        selectedTabContent.classList.remove('hidden');
                    }
                });
            });

            // Menampilkan tab pertama saat halaman dimuat
            const firstTabButton = document.querySelector('.category-tab');
            const firstTabContent = document.querySelector('.category-content');

            if (firstTabButton) {
                firstTabButton.classList.add('bg-accent', 'text-white');
            }
            if (firstTabContent) {
                firstTabContent.classList.remove('hidden');
            }
        });

        // Function to add items to cart
        function addToCart(facility_id, name, price, quantity, booking_date) {
            const quantityValue = parseInt(quantity) || 1;

            if (quantityValue < 1) {
                alert('Jumlah produk harus minimal 1.');
                return;
            }

            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        facility_id: facility_id,
                        quantity: quantityValue,
                        booking_date: booking_date,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        Swal.fire({
                            title: "",
                            text: "Item Berhasil dimasukan kedalam keranjang",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        })
                    } else {
                        alert('Gagal menyimpan ke keranjang. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
        }
    </script>
@endpush
