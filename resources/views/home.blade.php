@extends('layouts.app2')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <section
        class="relative min-h-screen flex flex-col items-center justify-center text-center pt-24 bg-cover bg-center bg-no-repeat"
        style="background-image: url('public/img/bg.jpg');">

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

                    <a href="{{ route('peta-desa') }}"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/worldwide-location.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">Peta Desa</p>
                    </a>


                    <!-- Card -->
                    <a href="{{ route('struktur-desa') }}"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/organization.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">
                            Struktur Organisasi</p>
                    </a>

                    <!-- Card -->
                    <a href="{{ route('umkm') }}"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/shop.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">UMKM</p>
                    </a>

                    <!-- Card -->
                    <a href="{{ route('data-penduduk') }}"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/combo-chart.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">
                            Statistik Penduduk
                        </p>
                    </a>


                    <!-- Card -->
                    <a href="{{ route('pengumuman') }}"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/megaphone.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">
                            Pengumuman
                        </p>
                    </a>

                    <!-- Card -->
                    <a href="{{ route('apbdesa') }}"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/money-bag.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">
                            APBDesa
                        </p>
                    </a>


                    <!-- Card -->
                    <a href="{{ route('potensi-desa') }}"
                        class="bg-white rounded-xl shadow w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex flex-col items-center justify-center hover:shadow-lg hover:scale-105 active:scale-95 transition-transform duration-200 cursor-pointer px-2">
                        <img src="https://img.icons8.com/color/96/000000/village.png"
                            class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 mb-1" />
                        <p class="text-[8px] sm:text-[10px] md:text-xs font-medium text-gray-800 text-center">Potensi Desa
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

    <!-- Potensi Desa Section -->
    <section class="max-w-6xl mx-auto px-4 py-14" data-aos="fade-up">
        <header class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-green-700">Potensi Desa</h2>
            <p class="mt-3 text-gray-600 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
                Potensi dan keunggulan Desa Mentuda dalam bidang pariwisata, ekonomi, dan pelestarian lingkungan.
            </p>
        </header>
        <article
            class="group relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5 transition
           hover:shadow-xl hover:-translate-y-0.5 duration-300">
            <div class="grid md:grid-cols-12 gap-0">
                <!-- Gambar -->
                <figure class="relative md:col-span-7 h-56 md:h-72 overflow-hidden">
                    <img src="{{ asset('public/img/potensi2.jpg') }}" alt="Panorama Pariwisata"
                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy" decoding="async">


                    <div
                        class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/50 to-transparent
                    opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>

                </figure>

                <!-- Konten -->
                <div class="md:col-span-5 p-6 md:p-8 flex flex-col justify-center">
                    <span
                        class="inline-flex items-center gap-1 w-fit rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200
                 transition-colors duration-300 group-hover:bg-green-100">
                        <x-heroicon-o-sparkles class="size-4" /> Sorotan
                    </span>

                    <h2 class="mt-3 text-xl md:text-2xl font-semibold text-gray-900">
                        Wisata Alam &amp; Bahari
                    </h2>

                    <p class="mt-2 text-gray-700">
                        Garis pantai, pasir putih, dan perairan yang kaya biota laut menjadi peluang pariwisata
                        edukasi dan konservasi.
                    </p>

                    <div class="mt-4">
                        <a href="#"
                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-2 text-sm font-medium text-green-700
                    hover:bg-green-600 hover:text-white transition-colors">
                            <x-heroicon-o-eye class="size-4" /> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>

            <div
                class="pointer-events-none absolute inset-0 rounded-2xl ring-1 ring-transparent group-hover:ring-green-200/70 transition duration-300">
            </div>
        </article>

        <!-- Tombol -->
        <div class="text-center mt-10" data-aos="zoom-in" data-aos-delay="200">
            <a href="{{ route('potensi-desa') }}"
                class="px-6 py-2 border border-green-700 text-green-700 rounded-full hover:bg-green-700 hover:text-white transition">
                Lihat Potensi Lainnya
            </a>
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
                <img src="{{ asset('public/img/potensi1.jpg') }}" alt="Berita Utama"
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
                    <img src="{{ asset('public/img/potensi1.jpg') }}" alt="thumb"
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
                    <img src="{{ asset('public/img/potensi2.jpg') }}" alt="thumb"
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
                    <img src="{{ asset('public/img/potensi1.jpg') }}" alt="thumb"
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
                    <img src="{{ asset('public/img/potensi1.jpg') }}" alt="thumb"
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


        {{-- contoh di home.blade.php --}}
        <livewire:content.content-hub mode="announcement" />


        <!-- Tombol -->
        <div class="text-center mt-10" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('pengumuman') }}"
                class="px-6 py-2 border border-green-700 text-green-700 rounded-full hover:bg-green-700 hover:text-white transition">
                Lihat Pengumuman Lainnya
            </a>
        </div>
    </section>

@endsection
