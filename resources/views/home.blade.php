@extends('layouts.app2')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <section
        class="relative min-h-screen flex flex-col items-center justify-center text-center pt-24 bg-cover bg-center bg-no-repeat"
        style="background-image: url('/img/bg.jpg');">

        <!-- Overlay smoke effect lembut -->
        <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/100 to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-b from-transparent to-white"></div>


        <!-- Konten Hero -->
        <div class="relative z-10 flex flex-col items-center">
            <!-- Logo -->
            <img src="https://linggakab.go.id/resources/config/icon_256.png" alt="Logo Desa" class="w-28 mb-6"
                data-aos="fade-up">

            <!-- Container Judul -->
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 text-center mt-2 flex flex-col items-center">
                <h1 class="text-3xl md:text-4xl font-bold text-green-700 " data-aos="fade-up" data-aos-delay="100">
                    Desa Mentuda
                </h1>
                <p class="text-gray-800 mt-2 text-sm sm:text-base md:text-lg text-center" data-aos="fade-up"
                    data-aos-delay="200">
                    Selamat Datang Di Portal Web Pemerintahan Desa Mentuda
                </p>
            </div>

            <!-- Menu Cards -->
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-10" data-aos="fade-up" data-aos-delay="300">
                <div class="flex flex-wrap justify-center gap-4 sm:gap-5 lg:gap-6">

                    <!-- Card -->
                    <a href="{{ route('berita') }}"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/48/000000/news.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">
                            Berita
                        </p>
                    </a>

                    <!-- Card -->

                    <a href="#"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/law.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">Produk
                            Hukum</p>
                    </a>

                    <!-- Card -->
                    <a href="#"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/document.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">
                            Informasi
                            Publik</p>
                    </a>

                    <!-- Card -->
                    <a href="#"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/news.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">Arsip
                            Berita</p>
                    </a>

                    <!-- Card -->
                    <a href="{{ route('galeri') }}"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/image.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">Album
                            Galeri</p>
                    </a>

                    <!-- Card -->
                    <a href="#"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/megaphone.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">
                            Pengaduan
                        </p>
                    </a>

                    <!-- Card -->
                    <a href="#"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/city-buildings.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">
                            Pembangunan</p>
                    </a>

                    <!-- Card -->
                    <a href="#"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/pie-chart.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">Status
                            IDM
                        </p>
                    </a>

                </div>
            </div>

        </div>

        <!-- Scroll Down Indicator -->
        <div x-data="{ show: true }" x-init="window.addEventListener('scroll', () => { show = window.scrollY < 50 })" x-show="show" x-transition
            class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 md:bottom-8 md:right-8 lg:bottom-10 lg:right-10 z-10 flex flex-col items-center text-green-700">
            <span class=" font-bold text-[10px] sm:text-xs tracking-widest mb-1 [writing-mode:vertical-rl]">SCROLL</span>

            <div class="w-4 h-8 sm:w-5 sm:h-10 border-2 border-green-700 rounded-full flex justify-center my-1">
                <div class="w-1 h-2 sm:h-3 bg-green-700 mt-1 rounded-full animate-[bounceHigh_1.5s_infinite]"></div>
            </div>

            <span class="font-bold text-[10px] sm:text-xs tracking-widest mt-1 [writing-mode:vertical-rl]">DOWN</span>
        </div>
    </section>

    <!-- population administration section -->
    <section class="max-w-6xl mx-auto px-4 py-12" data-aos="fade-up">
        <h2 class="text-3xl font-bold text-center text-green-700 mb-4">
            Administrasi Penduduk
        </h2>
        <p class="text-center text-gray-600 mb-8 max-w-2xl mx-auto text-sm">
            Sistem digital yang berfungsi mempermudah pengelolaan data dan informasi terkait dengan kependudukan dan
            pendayagunaannya untuk pelayanan publik yang efektif dan efisien.
        </p>

        <!-- Statistik -->
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-10" data-aos="fade-up" data-aos-delay="300">
            <div class="flex flex-wrap justify-center gap-4 sm:gap-5 lg:gap-6">

                <!-- Total Penduduk -->
                <div
                    class="bg-green-700 rounded-xl shadow w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer text-white">
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>

                    <!-- Angka -->
                    <p class="text-xs sm:text-sm md:text-base font-bold counter" data-target="17000">0</p>
                    <span class="text-[9px] sm:text-[10px] md:text-xs text-center">Total Penduduk</span>
                </div>

                <!-- Kepala Keluarga -->
                <div
                    class="bg-green-700 rounded-xl shadow w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                    </svg>

                    <p class="text-xs sm:text-sm md:text-base font-bold counter" data-target="700">0</p>
                    <span class="text-[9px] sm:text-[10px] md:text-xs text-center">Kepala Keluarga</span>
                </div>

                <!-- Laki-Laki -->
                <div
                    class="bg-green-700 rounded-xl shadow w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    <p class="text-xs sm:text-sm md:text-base font-bold counter" data-target="1700">0</p>
                    <span class="text-[9px] sm:text-[10px] md:text-xs text-center">Laki-Laki</span>
                </div>

                <!-- Perempuan -->
                <div
                    class="bg-green-700 rounded-xl shadow w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>

                    <p class="text-xs sm:text-sm md:text-base font-bold counter" data-target="1700">0</p>
                    <span class="text-[9px] sm:text-[10px] md:text-xs text-center">Perempuan</span>
                </div>

                <!-- Sementara -->
                <div
                    class="bg-green-700 rounded-xl shadow w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>

                    <p class="text-xs sm:text-sm md:text-base font-bold counter" data-target="12">0</p>
                    <span class="text-[9px] sm:text-[10px] md:text-xs text-center">Sementara</span>
                </div>

                <!-- Mutasi -->
                <div
                    class="bg-green-700 rounded-xl shadow w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>

                    <p class="text-xs sm:text-sm md:text-base font-bold counter" data-target="1">0</p>
                    <span class="text-[9px] sm:text-[10px] md:text-xs text-center">Mutasi Penduduk</span>
                </div>

            </div>
        </div>
    </section>

    <!-- Struktur Organisasi Section -->
    <section class="max-w-6xl mx-auto px-4 py-12" data-aos="fade-up">
        <!-- Content -->
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-green-700 mb-4">
                Struktur Organisasi Desa Mentuda
            </h2>
            <p class="text-gray-600 mb-6 text-sm md:text-base leading-relaxed max-w-2xl mx-auto">
                Untuk memastikan tata kelola pemerintahan desa yang efisien, transparan,
                dan responsif terhadap kebutuhan masyarakat.
            </p>
            <button
                class="px-5 py-2 border border-green-700 text-green-700 rounded-full hover:bg-green-700 hover:text-white transition">
                Lihat Detail Organisasi
            </button>
        </div>

        <!-- Swiper -->
        <div class="swiper mySwiper" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
                <!-- Card 1 -->
                <div class="swiper-slide">
                    <div
                        class="bg-white rounded-lg shadow p-4 transform transition duration-300 hover:scale-105 hover:shadow-lg cursor-pointer">
                        <img src="img/user/user1.jpg" alt="Foto" class="w-full h-48 object-cover rounded-lg">
                        <div class="text-center mt-3">
                            <p class="font-semibold text-base">Nur Azani Bayu Rezki</p>
                            <p class="text-gray-500 text-sm">IT Specialist</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="swiper-slide">
                    <div
                        class="bg-white rounded-lg shadow p-4 transform transition duration-300 hover:scale-105 hover:shadow-lg cursor-pointer">
                        <img src="img/user/user2.jpg" alt="Foto" class="w-full h-48 object-cover rounded-lg">
                        <div class="text-center mt-3">
                            <p class="font-semibold text-base">Ahmad Santoso</p>
                            <p class="text-gray-500 text-sm">Sekretaris Desa</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="swiper-slide">
                    <div
                        class="bg-white rounded-lg shadow p-4 transform transition duration-300 hover:scale-105 hover:shadow-lg cursor-pointer">
                        <img src="img/user/user3.jpg" alt="Foto" class="w-full h-48 object-cover rounded-lg">
                        <div class="text-center mt-3">
                            <p class="font-semibold text-base">Siti Aminah</p>
                            <p class="text-gray-500 text-sm">Bendahara</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="swiper-slide">
                    <div
                        class="bg-white rounded-lg shadow p-4 transform transition duration-300 hover:scale-105 hover:shadow-lg cursor-pointer">
                        <img src="img/user/user2.jpg" alt="Foto" class="w-full h-48 object-cover rounded-lg">
                        <div class="text-center mt-3">
                            <p class="font-semibold text-base">Budi Hartono</p>
                            <p class="text-gray-500 text-sm">Kepala Desa</p>
                        </div>
                    </div>
                </div>
                <!-- Card 5 -->
                <div class="swiper-slide">
                    <div
                        class="bg-white rounded-lg shadow p-4 transform transition duration-300 hover:scale-105 hover:shadow-lg cursor-pointer">
                        <img src="img/user/user1.jpg" alt="Foto" class="w-full h-48 object-cover rounded-lg">
                        <div class="text-center mt-3">
                            <p class="font-semibold text-base">Ujang</p>
                            <p class="text-gray-500 text-sm">Tukang Kebun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Potensi Desa Section -->
    <section class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid lg:grid-cols-2 gap-8 items-center">
            <!-- Right (Content) -->
            <div class="order-1 lg:order-2 text-center lg:text-left" data-aos="fade-left" data-aos-delay="200">
                <h2 class="text-2xl md:text-3xl font-bold text-green-700 mb-4">Potensi Desa</h2>
                <p class="text-gray-700 mb-6 text-sm md:text-base leading-relaxed">
                    Informasi tentang potensi dan kemajuan Desa di berbagai bidang seperti ekonomi,
                    pariwisata, pertanian, industri kreatif, dan kelestarian lingkungan.
                </p>
                <button
                    class="px-5 py-2 border border-green-700 text-green-700 rounded-full hover:bg-green-700 hover:text-white transition">
                    Lihat Potensi Lainnya
                </button>
            </div>

            <!-- Left (Cards) -->
            <div class="order-2 lg:order-1 grid grid-cols-1 lg:grid-cols-2 gap-6" data-aos="fade-right"
                data-aos-delay="200">

                <!-- Card 1 -->
                <div x-data="{ open: false }">
                    <div @click="open = true"
                        class="bg-white rounded-lg shadow p-4 transition duration-300 hover:scale-105 hover:shadow-lg cursor-pointer h-64 flex flex-col items-center justify-center">
                        <img src="img/potensi1.jpg" alt="Foto" class="w-full h-40 object-cover rounded-lg">
                        <p class="font-semibold text-base mt-3">Hasil Laut</p>
                    </div>
                    <!-- Modal -->
                    <div x-show="open" x-transition x-cloak @click.self="open = false"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
                            <button @click="open = false"
                                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>
                            <img src="img/potensi1.jpg" alt="Foto" class="w-full h-48 object-cover rounded-lg">
                            <h3 class="text-xl font-bold mt-4">Hasil Laut</h3>
                            <p class="text-gray-600 mt-2 text-sm">
                                Potensi pendapatan utama berasal dari hasil laut berupa
                                <span class="font-semibold">ikan bilis kering</span>,
                                yang menjadi komoditas unggulan desa. Produk ini banyak diminati pasar lokal maupun
                                luar
                                daerah.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div x-data="{ open: false }">
                    <div @click="open = true"
                        class="bg-white rounded-lg shadow p-4 transition duration-300 hover:scale-105 hover:shadow-lg cursor-pointer h-64 flex flex-col items-center justify-center">
                        <img src="img/potensi2.jpg" alt="Foto" class="w-full h-40 object-cover rounded-lg">
                        <p class="font-semibold text-base mt-3">Bidang Pariwisata</p>
                    </div>
                    <!-- Modal -->
                    <div x-show="open" x-transition x-cloak @click.self="open = false"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
                            <button @click="open = false"
                                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>
                            <img src="img/potensi2.jpg" alt="Foto" class="w-full h-48 object-cover rounded-lg">
                            <h3 class="text-xl font-bold mt-4">Bidang Pariwisata</h3>
                            <p class="text-gray-600 mt-2 text-sm">
                                Bidang <span class="font-semibold">pariwisata alam</span> menjadi daya tarik utama,
                                dengan panorama indah dan potensi wisata edukasi yang menarik wisatawan untuk
                                menikmati
                                keasrian desa.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Berita Desa Section -->
    <section class="max-w-6xl mx-auto px-4 py-12" data-aos="fade-up">
        <!-- Heading -->
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-green-700">Berita Desa</h2>
            <p class="text-gray-600 mt-2 text-sm md:text-base">
                Menyajikan informasi terbaru tentang peristiwa, berita terkini, dan artikel-artikel jurnalistik dari
                Desa
            </p>
        </div>

        <!-- Grid Utama -->
        <div class="grid md:grid-cols-3 gap-8 items-stretch">
            <!-- Artikel Utama -->
            <div class="md:col-span-2 relative rounded-xl overflow-hidden shadow-lg group flex flex-col h-[390px]"
                data-aos="fade-right" data-aos-delay="500">
                <!-- Gambar -->
                <img src="img/potensi1.jpg" alt="Berita Utama"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                <!-- Overlay Judul + Gradient -->
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-6 text-white">
                    <h3 class="font-semibold text-lg md:text-xl group-hover:text-white transition">
                        Hasil Panen Ikan Kerapu Melimpah Membantu Perekonomian Masyarakat Desa Mentuda
                    </h3>

                    <!-- Box Metadata -->
                    <div class="absolute bottom-0 right-0 right-0 flex justify-start">
                        <div
                            class="bg-white text-green-700 px-4 py-2 rounded-tl-2xl flex items-center gap-4 text-sm shadow-md">

                            <!-- Bagian Berita Utama -->
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                Berita utama
                            </span>

                            <!-- Bagian Tanggal -->
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                12-12-2024
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Artikel Lainnya -->
            <div class="space-y-5 flex flex-col" data-aos="fade-left" data-aos-delay="600">
                <!-- Item -->
                <div class="flex items-center space-x-4 p-2 rounded-lg hover:bg-gray-50 transition group cursor-pointer">
                    <img src="img/potensi1.jpg" alt="thumb"
                        class="w-20 h-16 object-cover rounded-lg shadow-sm transition-transform duration-300 group-hover:scale-105">
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-2">
                            Pembangunan Balai Desa Mentuda Resmi Dimulai, Fasilitas Baru untuk Masyarakat
                        </h4>
                        <div class="flex items-center text-xs text-gray-500 mt-1 space-x-3">
                            <!-- Bagian Berita Utama -->
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                Berita utama
                            </span>

                            <!-- Bagian Tanggal -->
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                12-12-2024
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Item -->
                <div class="flex items-center space-x-4 p-2 rounded-lg hover:bg-gray-50 transition group cursor-pointer">
                    <img src="img/potensi2.jpg" alt="thumb"
                        class="w-20 h-16 object-cover rounded-lg shadow-sm transition-transform duration-300 group-hover:scale-105">
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-2">
                            Tradisi Adat Desa Mentuda Tetap Dilestarikan di Era Modern
                        </h4>
                        <div class="flex items-center text-xs text-gray-500 mt-1 space-x-3">
                            <!-- Bagian Berita Utama -->
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                Berita utama
                            </span>

                            <!-- Bagian Tanggal -->
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                12-12-2024
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Item -->
                <div class="flex items-center space-x-4 p-2 rounded-lg hover:bg-gray-50 transition group cursor-pointer">
                    <img src="img/potensi1.jpg" alt="thumb"
                        class="w-20 h-16 object-cover rounded-lg shadow-sm transition-transform duration-300 group-hover:scale-105">
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-2">
                            Pelatihan UMKM di Desa Mentuda: Dorong Perekonomian Lokal
                        </h4>
                        <div class="flex items-center text-xs text-gray-500 mt-1 space-x-3">
                            <!-- Bagian Berita Utama -->
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                Berita utama
                            </span>

                            <!-- Bagian Tanggal -->
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                12-12-2024
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Item -->
                <div class="flex items-center space-x-4 p-2 rounded-lg hover:bg-gray-50 transition group cursor-pointer">
                    <img src="img/potensi1.jpg" alt="thumb"
                        class="w-20 h-16 object-cover rounded-lg shadow-sm transition-transform duration-300 group-hover:scale-105">
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-2">
                            Gotong Royong Warga Desa Mentuda, Wujudkan Jalan Desa yang Lebih Baik
                        </h4>
                        <div class="flex items-center text-xs text-gray-500 mt-1 space-x-3">
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                Berita utama
                            </span>

                            <!-- Bagian Tanggal -->
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                12-12-2024
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol -->
        <div class="text-center mt-10" data-aos="zoom-in" data-aos-delay="200">
            <a href="{{ route('berita') }}"
                class="px-6 py-2 border border-green-700 text-green-700 rounded-full 
              hover:bg-green-700 hover:text-white transition">
                Lihat Berita Lainnya
            </a>
        </div>

    </section>

    <!-- Pengumuman Resmi Section -->
    <section class="max-w-6xl mx-auto px-4 py-12" data-aos="fade-up">
        <!-- Heading -->
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-green-700">Pengumuman Resmi</h2>
            <p class="text-gray-600 mt-2 text-sm md:text-base">
                Lihat Pengumuman Resmi Dari Pemerintahan Desa Mentuda
            </p>
        </div>


        <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5 transition hover:shadow-md">
            <div class="p-5 md:p-6 flex flex-col sm:flex-row sm:items-start gap-4">
                {{-- Tanggal badge --}}
                <div class="shrink-0">
                    <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-2 text-center">
                        <p class="text-xs font-medium text-green-700">Sabtu</p>
                        <p class="text-lg font-extrabold text-green-700 leading-none">20</p>
                        <p class="text-xs font-medium text-green-700">Sep 2025</p>
                    </div>
                </div>

                {{-- Isi --}}
                <div class="flex-1 min-w-0">
                    <div class="mb-1 flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                            <x-heroicon-o-bell class="size-4" /> Pengumuman
                        </span>
                        <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                            <x-heroicon-o-clock class="size-4" /> 20 September 2025 • 08:00
                        </time>
                    </div>

                    <h2 class="text-base md:text-lg font-semibold text-gray-900 leading-snug">
                        Gotong Royong Bersama
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Diharapkan seluruh warga ikut serta dalam kegiatan gotong royong membersihkan lingkungan
                        desa pada hari Minggu.
                    </p>

                    {{-- Meta lokasi/penanggung jawab (opsional) --}}
                    <div class="mt-3 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                        <span class="inline-flex items-center gap-1"><x-heroicon-o-map-pin class="size-4" />
                            Balai Desa</span>
                        <span class="inline-flex items-center gap-1"><x-heroicon-o-user class="size-4" /> Kasi
                            Pemerintahan</span>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="sm:self-center">
                    <a href="#"
                        class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                        <x-heroicon-o-eye class="size-4" /> Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>


        <!-- Tombol -->
        <div class="text-center mt-10" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('pengumuman') }}"
                class="px-6 py-2 border border-green-700 text-green-700 rounded-full hover:bg-green-700 hover:text-white transition">
                Lihat Pengumuman Lainnya
            </a>
        </div>
    </section>

@endsection
