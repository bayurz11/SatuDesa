@extends('layouts.app2')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')

    <section class="relative bg-gradient-to-b from-white to-green-50 py-20 mt-12 overflow-hidden">
        <div class="absolute top-0 left-0 w-40 h-40 bg-green-100 rounded-full blur-3xl opacity-40 animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-52 h-52 bg-yellow-100 rounded-full blur-2xl opacity-40 animate-ping"></div>

        <div class="max-w-5xl mx-auto px-4 relative z-10 text-center" data-aos="zoom-in">

            <!-- Angka besar 404 -->
            <h1 class="text-7xl md:text-9xl font-extrabold text-green-600 mb-4 animate-bounce">404</h1>

            <!-- Judul -->
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
                Halaman Tidak Ditemukan
            </h2>
            <p class="text-gray-600 mb-10">
                Oops! Sepertinya halaman yang Anda cari belum tersedia atau sudah dipindahkan.
            </p>


            <!-- Tombol kembali -->
            <a href="{{ url('/') }}"
                class="inline-block px-6 py-3 bg-green-600 text-white rounded-full shadow-md hover:bg-green-700 transition">
                Kembali ke Beranda
            </a>
        </div>
    </section>

@endsection
