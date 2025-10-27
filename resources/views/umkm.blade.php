@extends('layouts.app2')

@section('title', 'UMKM Desa')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb (selaras) --}}
        <nav class="mb-6 mt-6 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Ekonomi</li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">UMKM</li>
            </ol>
        </nav>

        {{-- Heading (selaras) --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                UMKM Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Halaman ini sedang dalam pengembangan. Nantikan informasi produk unggulan dan usaha masyarakat Desa Mentuda.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-8">

                {{-- Status Pengembangan --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="p-6 md:p-8">
                        <div class="flex items-start gap-4">
                            <span
                                class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 ring-1 ring-amber-200 shrink-0">
                                <x-heroicon-o-cog-6-tooth class="size-7 text-amber-600" />
                            </span>
                            <div class="min-w-0">
                                <h2 class="text-lg md:text-xl font-semibold text-gray-900">
                                    Sedang Disiapkan
                                </h2>
                                <p class="mt-1 text-gray-700">
                                    Kami sedang menyiapkan direktori UMKM, profil usaha, katalog produk, dan informasi
                                    kontak.
                                    Sementara ini, silakan lihat contoh tata letak di bawah sebagai pratayang.
                                </p>
                            </div>
                        </div>

                        {{-- Ilustrasi sederhana --}}
                        <div class="mt-6 flex items-center justify-center">
                            <div class="rounded-2xl border border-dashed border-gray-300 p-6 md:p-8 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto size-16 text-green-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 7h18M5 7V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m-1 0v11a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7m2 4h10m-10 4h6" />
                                </svg>
                                <p class="mt-3 text-sm text-gray-600">
                                    Area pratayang katalog UMKM (kartu produk, foto, harga, & kontak).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pratayang Katalog (statik, placeholder) --}}
                <div>
                    <h3 class="mb-4 text-base md:text-lg font-semibold text-gray-900">Contoh Katalog UMKM</h3>
                    <div class="grid gap-6 sm:grid-cols-2">
                        @for ($i = 0; $i < 2; $i++)
                            <div class="rounded-2xl bg-white shadow ring-1 ring-black/5 overflow-hidden group">
                                <div class="aspect-[16/9] bg-gray-100">
                                    <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=1200&auto=format&fit=crop"
                                        alt="Foto produk UMKM"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale"
                                        loading="lazy" decoding="async">
                                </div>
                                <div class="p-4">
                                    <div class="mb-1 flex flex-wrap items-center gap-2">
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                            <x-heroicon-o-tag class="size-4" /> Makanan &amp; Minuman
                                        </span>
                                    </div>
                                    <h4 class="text-sm md:text-base font-semibold text-gray-900">Nama Produk UMKM</h4>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">Deskripsi singkat produk/layanan
                                        UMKM.</p>

                                    <div class="mt-3 flex items-center justify-between">
                                        <span class="text-sm font-semibold text-green-700">Rp 00.000</span>
                                        <a href="#"
                                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-1.5 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                            <x-heroicon-o-eye class="size-4" /> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- CTA Kirim Data UMKM --}}
                <div class="rounded-2xl border border-green-200 bg-green-50/60 p-5 md:p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900">Punya UMKM di Mentuda?</h3>
                            <p class="text-sm text-gray-700">Kirim data usahamu untuk ditampilkan di direktori.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="#"
                                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                <x-heroicon-o-paper-airplane class="size-4" /> Formulir Pendaftaran
                            </a>
                            <a href="#"
                                class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                <x-heroicon-o-inbox class="size-4" /> Kontak Admin
                            </a>
                        </div>
                    </div>
                </div>

            </article>

            {{-- SIDEBAR (opsional, selaras gaya) --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                {{-- Filter Kategori (placeholder) --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Kategori</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border bg-green-600 border-green-600 text-white">Semua</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Makanan</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Minuman</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Kerajinan</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Jasa</a>
                    </div>
                </div>

                {{-- Informasi Kontak (placeholder) --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Informasi</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2"><x-heroicon-o-envelope class="size-4 text-green-700" />
                            umkm@desamentuda.id</li>
                        <li class="flex items-center gap-2"><x-heroicon-o-phone class="size-4 text-green-700" /> +62 812
                            3456 7890</li>
                        <li class="flex items-center gap-2"><x-heroicon-o-map-pin class="size-4 text-green-700" /> Balai
                            Desa Mentuda</li>
                    </ul>
                </div>

                {{-- Tombol Kembali --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <a href="#"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                        <x-heroicon-o-arrow-left class="size-4" /> Kembali ke Beranda
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection
