@extends('layouts.app')

@section('title', 'Wahana - Kolam Renang')

@section('content')
    <!-- Hero Section -->
    <section class="bg-primary text-background py-20" data-aos="fade-up" data-aos-duration="1000">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-extrabold leading-tight mb-4 animate__animated animate__fadeIn animate__delay-1s">
                Kolam Renang Wisata Germanggis
            </h1>
            <p class="text-lg mb-6 animate__animated animate__fadeIn animate__delay-2s">
                Nikmati kesegaran di kolam renang kami yang luas dan menyegarkan, dengan pemandangan alam yang menenangkan!
            </p>
        </div>
    </section>

    <!-- Kolam Renang Description Section -->
    <section class="py-16 bg-background text-primary" data-aos="fade-up" data-aos-duration="1000">
        <div class="container mx-auto text-center">
            <!-- Judul -->
            <h2 class="text-4xl font-extrabold mb-12 animate__animated animate__fadeIn animate__delay-2s">
                Tentang Kolam Renang
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Kolom Deskripsi -->
                <div class="lg:pr-8" data-aos="fade-right" data-aos-duration="1000">
                    <div class="bg-primary bg-opacity-50 p-6 rounded-lg shadow-lg">
                        <p class="text-lg leading-relaxed mb-6 animate__animated animate__fadeIn animate__delay-3s">
                            Kolam renang di Wisata Germanggis menawarkan pengalaman berendam yang menyegarkan dengan
                            pemandangan
                            alam pegunungan yang asri. Kolam ini cocok untuk semua usia, dari anak-anak hingga dewasa,
                            dengan
                            kedalaman yang disesuaikan agar pengunjung merasa nyaman.
                        </p>
                        <p class="text-lg leading-relaxed mb-6 animate__animated animate__fadeIn animate__delay-4s">
                            Dilengkapi dengan berbagai fasilitas seperti pelampung, ruang ganti, dan area duduk untuk
                            bersantai,
                            kami selalu menjaga kebersihan dan kenyamanan pengunjung demi pengalaman terbaik.
                        </p>
                        <p class="text-lg font-semibold text-accent animate__animated animate__fadeIn animate__delay-5s">
                            <strong>Masuk Wahana Ini: GRATIS!</strong>
                        </p>
                    </div>
                </div>

                <!-- Kolom Galeri Gambar -->
                <div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Gambar 1 -->
                        <div class="group" data-aos="zoom-in" data-aos-duration="1000">
                            <div
                                class="overflow-hidden rounded-lg shadow-lg transition-all duration-300 group-hover:scale-105">
                                <img src="{{ asset('images/kolam 1.jpeg') }}" alt="Kolam Anak"
                                    class="w-full h-48 object-cover">
                            </div>
                        </div>

                        <!-- Gambar 2 -->
                        <div class="group" data-aos="zoom-in" data-aos-duration="1000">
                            <div
                                class="overflow-hidden rounded-lg shadow-lg transition-all duration-300 group-hover:scale-105">
                                <img src="{{ asset('images/kolam 5.jpeg') }}" alt="Kolam Dewasa"
                                    class="w-full h-48 object-cover">
                            </div>
                        </div>

                        <!-- Gambar 3 -->
                        <div class="group" data-aos="zoom-in" data-aos-duration="1000">
                            <div
                                class="overflow-hidden rounded-lg shadow-lg transition-all duration-300 group-hover:scale-105">
                                <img src="{{ asset('images/kolam 3.jpeg') }}" alt="Kolam Terapi"
                                    class="w-full h-48 object-cover">
                            </div>
                        </div>

                        <!-- Gambar 4 -->
                        <div class="group" data-aos="zoom-in" data-aos-duration="1000">
                            <div
                                class="overflow-hidden rounded-lg shadow-lg transition-all duration-300 group-hover:scale-105">
                                <img src="{{ asset('images/kolam 4.jpeg') }}" alt="Kolam Bermain"
                                    class="w-full h-48 object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Fasilitas Kolam Renang Section -->
    <section class="py-16 bg-primary text-background px-4 md:px-10">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-extrabold text-white mb-12 animate__animated animate__fadeIn animate__delay-3s">
                Fasilitas Kolam Renang
            </h2>

            <!-- Swiper Container -->
            <div class="swiper-container mx-auto w-full">
                <div class="swiper-wrapper flex justify-center items-center">
                    @foreach ($fasilitas as $item)
                        <div class="swiper-slide flex justify-center items-center">
                            <div
                                class="flex flex-col items-center justify-center bg-white rounded-lg shadow-lg p-10 transform transition duration-300 hover:scale-105">
                                <!-- Gambar Ikon Fasilitas yang lebih besar -->
                                <img src="{{ asset($item['icon']) }}" alt="{{ $item['title'] }}"
                                    class="w-32 h-32 object-contain mb-6">
                                <!-- Judul Fasilitas -->
                                <h3 class="text-2xl font-semibold text-primary mt-4">{{ $item['title'] }}</h3>
                                <!-- Deskripsi Fasilitas -->
                                <p class="text-base text-primary mt-2">{{ $item['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Swiper Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <!-- AOS JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });
    </script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
@endpush
