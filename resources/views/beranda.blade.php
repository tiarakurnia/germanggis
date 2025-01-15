@extends('layouts.app')

@section('title', 'Beranda - Wisata Germanggis')

@section('content')
    <!-- Slider Section -->
    <section class="relative py-5">
        <div class="swiper-container">
            <!-- Wrapper -->
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <img src="{{ asset('images/penginapan dengan tulisan germanggis.jpeg') }}" alt="Slide 1"
                        class="w-full h-[600px] object-cover rounded-lg">
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img src="{{ asset('images/Penginapan dengan kolam.jpeg') }}" alt="Slide 2"
                        class="w-full h-[600px] object-cover rounded-lg">
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <img src="{{ asset('images/patung manggis.jpeg') }}" alt="Slide 3"
                        class="w-full h-[600px] object-cover rounded-lg">
                </div>
            </div>
            <!-- Navigation Buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="bg-primary text-background py-20" data-aos="fade-up" data-aos-duration="1000">
        <div class="container mx-auto flex flex-col md:flex-row items-center">
            <!-- Text Content -->
            <div class="md:w-1/2 text-center md:text-left pl-8" data-aos="fade-right" data-aos-duration="1000">
                <h1 class="text-4xl font-extrabold leading-tight mb-4">
                    Selamat Datang di <span class="text-accent">Wisata Germanggis</span>
                </h1>
                <p class="text-lg mb-6">
                    Rasakan keindahan alam, petualangan seru, dan pengalaman tak terlupakan bersama kami!
                </p>
                <a href="{{ Auth::check() ? route('wahana') : route('login') }}"
                    class="bg-background
                    text-primary px-6 py-3 rounded-lg shadow-lg hover:bg-primary hover:text-background transition
                    duration-300">
                    Jelajahi Wahana
                </a>
            </div>
            <!-- Image -->
            <div class="md:w-1/2 mt-8 md:mt-0 flex justify-center" data-aos="fade-left" data-aos-duration="1000">
                <img src="{{ asset('images/Pemandangan dari atas.jpeg') }}" alt="Wisata Germanggis"
                    class="w-3/4 rounded-lg shadow-lg hover:scale-105 transition duration-300">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-background text-primary" data-aos="fade-up" data-aos-duration="1000">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Kenapa Harus Wisata Germanggis?</h2>
            <div class="w-24 h-1 bg-accent mx-auto mb-10"></div>

            <!-- Grid Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="p-6 bg-primary text-background rounded-lg shadow-lg hover:shadow-xl transition duration-300"
                    data-aos="fade-up" data-aos-duration="1000">
                    <img src="{{ asset('images/pemandangan pagi.jpeg') }}" alt="Alam Asri"
                        class="mx-auto w-24 h-24 mb-4 rounded-full">
                    <h3 class="text-xl font-semibold mb-2">Alam yang Asri</h3>
                    <p>Keindahan pegunungan yang memberikan ketenangan jiwa.</p>
                </div>
                <!-- Feature 2 -->
                <div class="p-6 bg-primary text-background rounded-lg shadow-lg hover:shadow-xl transition duration-300"
                    data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <img src="{{ asset('images/kolam renang.jpeg') }}" alt="Wahana Menarik"
                        class="mx-auto w-24 h-24 mb-4 rounded-full">
                    <h3 class="text-xl font-semibold mb-2">Wahana Seru</h3>
                    <p>Bermain seru dengan fasilitas lengkap untuk semua umur.</p>
                </div>
                <!-- Feature 3 -->
                <div class="p-6 bg-primary text-background rounded-lg shadow-lg hover:shadow-xl transition duration-300"
                    data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <img src="{{ asset('images/mendoan.jpg') }}" alt="Kuliner Lokal"
                        class="mx-auto w-24 h-24 mb-4 rounded-full">
                    <h3 class="text-xl font-semibold mb-2">Kuliner Lokal</h3>
                    <p>Rasakan cita rasa otentik khas Cilongok.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-8 bg-accent text-background flex flex-col items-center justify-center space-y-4 text-center"
        data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
        <!-- Judul -->
        <h2 class="text-3xl font-bold text-gray-800">Ayo Rencanakan Liburan Anda!</h2>
        <!-- Deskripsi -->
        <p class="text-lg text-gray-700">Pesan tiket sekarang dan nikmati berbagai aktivitas seru di Wisata Germanggis.</p>
        <!-- Tombol -->
        <a href="{{ Auth::check() ? route('fasilitas') : route('login') }}"
            class="bg-primary text-white px-8 py-4 rounded-lg shadow-lg hover:bg-white hover:text-primary transition duration-300 transform hover:scale-105 hover:shadow-xl">
            Pesan Tiket Sekarang
        </a>
    </section>


    <!-- Map Section -->
    <section class="py-16 bg-primary text-background" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Lokasi Wisata Germanggis</h2>
            <p class="mb-6">Camp Area Germanggis, Cilongok, Banyumas, Jawa Tengah</p>
            <div class="flex justify-center">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.0504733468583!2d109.12630259999999!3d-7.348229399999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f8b27cdc9fb75%3A0x2a80475b9723b388!2sCamp%20Area%20Germanggis!5e0!3m2!1sid!2sid!4v1732368926311!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- AOS JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Durasi animasi dalam milidetik
            offset: 100, // Jarak untuk memulai animasi (dari atas)
            once: true // Menjalankan animasi hanya sekali
        });
    </script>

    <!-- Swiper.js JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            loop: true, // Mengaktifkan looping
            autoplay: {
                delay: 3000, // Waktu jeda antar slide (ms)
                disableOnInteraction: false, // Autoplay tetap berjalan meskipun ada interaksi
            },
            effect: 'fade', // Menggunakan efek fade
            fadeEffect: {
                crossFade: true, // Crossfade antar slide
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
@endpush
<style>
    .swiper-button-prev::after {
        content: '<';
        /* Ganti dengan tanda kurang dari */
        font-size: 12px;
        /* Atur ukuran */
        color: #fff;
        /* Warna ikon tetap putih */
        font-weight: normal;
        /* Tebal ikon tetap ringan */
    }

    .swiper-button-next::after {
        content: '>';
        /* Ganti dengan tanda lebih dari */
        font-size: 12px;
        /* Atur ukuran */
        color: #fff;
        /* Warna ikon tetap putih */
        font-weight: normal;
        /* Tebal ikon tetap ringan */
    }

    .swiper-button-prev {
        left: 25px;
        /* Lebih ke tepi */
    }

    .swiper-button-next {
        right: 25px;
        /* Lebih ke tepi */
    }
</style>
