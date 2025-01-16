<header class="bg-primary text-background py-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="text-xl font-bold">
            <a href="{{ route('home') }}" class="hover:underline">
                <img src="{{ asset('images/logo.png') }}" alt="Wisata Germanggis" class="w-auto h-10">
            </a>
        </div>

        <!-- Navigation Links -->
        @if (Route::has('login'))
            <nav class="hidden md:flex space-x-6 items-center">
                @auth
                    <!-- Links -->
                    <a href="{{ route('home') }}" class="hover:underline hover:text-accent transition">Beranda</a>
                    <a href="{{ route('wahana') }}" class="hover:underline hover:text-accent transition">Wahana</a>
                    <a href="{{ route('fasilitas') }}" class="hover:underline hover:text-accent transition">Fasilitas</a>
                    <a href="{{ route('keranjang') }}" class="hover:underline hover:text-accent transition">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                    <a href="{{ route('pesanan') }}" class="hover:underline hover:text-accent transition">
                        <i class="fa-solid fa-receipt"></i>
                    </a>

                    <!-- User Dropdown -->
                    <div class="relative">
                        <!-- Trigger Button -->
                        <button class="hover:underline focus:outline-none focus:ring-2 focus:ring-accent transition"
                            id="dropdownButton">
                            {{ Auth::user()->name }}
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-background text-primary rounded shadow-lg hidden"
                            id="dropdownMenu">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="button"
                                    class="block w-full text-left px-4 py-2 text-sm hover:bg-primary hover:text-background transition"
                                    id="logout-btn">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Login/Register Links -->
                    <a href="{{ route('login') }}" class="hover:underline hover:text-accent transition">Login</a>
                    <a href="{{ route('register') }}" class="hover:underline hover:text-accent transition">Daftar</a>
                @endauth
            </nav>
        @endif

        <!-- Mobile Menu Toggle -->
        <button class="md:hidden text-2xl" id="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div class="hidden bg-background text-primary p-4 space-y-4 md:hidden" id="mobile-menu">
        <a href="{{ route('home') }}" class="block hover:underline">Beranda</a>
        <a href="{{ route('wahana') }}" class="block hover:underline">Wahana</a>
        <a href="{{ route('fasilitas') }}" class="block hover:underline">Fasilitas</a>
        <a href="{{ route('keranjang') }}" class="block hover:underline">
            <i class="fa-solid fa-cart-shopping"></i> Keranjang
        </a>
        <a href="{{ route('pesanan') }}" class="block hover:underline">
            <i class="fa-solid fa-receipt"></i> Pesanan
        </a>

        <!-- Authentication -->
        @if (Auth::check())
            {{-- <a href="{{ route('profile') }}" class="block hover:underline">Profil</a> --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button"
                    class="block w-full text-left px-4 py-2 text-sm hover:bg-primary hover:text-background transition"
                    id="logout-btn">
                    Keluar
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block hover:underline">Login</a>
            <a href="{{ route('register') }}" class="block hover :underline">Daftar</a>
        @endif
    </div>
</header>

@push('scripts')
    <script>
        document.getElementById('menu-toggle').addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Tutup mobile menu saat link diklik
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });

        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        if (dropdownButton && dropdownMenu) {
            dropdownButton.addEventListener('click', (event) => {
                event.stopPropagation(); // Cegah event bubbling
                dropdownMenu.classList.toggle('hidden');
            });

            // Tutup dropdown saat klik di luar
            document.addEventListener('click', () => {
                dropdownMenu.classList.add('hidden');
            });
        }

        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika "Ya, Keluar" dipilih, submit form logout
                    document.getElementById('logout-form').submit();
                }
            });
        });
    </script>
@endpush
