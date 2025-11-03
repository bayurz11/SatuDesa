@extends('layouts.app2')

@section('title', 'Berita Desa ')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Informasi</li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Berita</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Berita Desa
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Menyajikan informasi terbaru tentang peristiwa, berita terkini, dan artikel-artikel jurnalistik dari Desa
                Mentuda.
            </p>
        </header>

        <div class="grid gap-8 md:gap-10 lg:grid-cols-3 items-start">
            {{-- MAIN COLUMN --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Featured / Artikel Utama (statik) --}}
                <article class="relative overflow-hidden rounded-2xl shadow ring-1 ring-black/5 group" data-aos="fade-right"
                    data-aos-delay="150">
                    <a href="#" class="block">
                        <img src="{{ asset('public/img/potensi1.jpg') }}" alt="Hasil Panen Ikan Kerapu"
                            class="h-[380px] w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                            loading="lazy" decoding="async">
                    </a>

                    <div
                        class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                    </div>

                    <div class="absolute inset-x-0 bottom-0 p-5 md:p-6">
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-white/95 px-2.5 py-1 text-xs font-medium text-green-700 ring-1 ring-black/5">
                                <x-heroicon-o-tag class="size-4" /> Berita Utama
                            </span>
                            <time
                                class="inline-flex items-center gap-1 rounded-full bg-black/50 px-2.5 py-1 text-xs text-white">
                                <x-heroicon-o-clock class="size-4" />
                                12-12-2024
                            </time>
                        </div>

                        <h2 class="text-white text-2xl md:text-3xl font-extrabold leading-snug line-clamp-2 drop-shadow">
                            <a href="#" class="pointer-events-auto group-hover:text-green-200 transition">
                                Hasil Panen Ikan Kerapu Melimpah Membantu Perekonomian Masyarakat Desa Mentuda
                            </a>
                        </h2>

                        <p class="mt-2 text-white/90 line-clamp-2 pointer-events-auto">
                            Panen ikan kerapu tahun ini meningkat signifikan dan berdampak positif pada pendapatan nelayan
                            setempat.
                        </p>
                    </div>
                </article>

                {{-- Daftar artikel (statik) --}}
                <div class="grid gap-6 md:grid-cols-2">
                    {{-- Card 1 --}}
                    <article class="rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition">
                        <a href="#" class="block">
                            <div class="aspect-[16/9] overflow-hidden rounded-t-xl">
                                <img src="{{ asset('public/img/potensi2.jpg') }}" alt="Pembangunan Balai Desa"
                                    class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.04]"
                                    loading="lazy" decoding="async">
                            </div>
                        </a>
                        <div class="p-4 md:p-5">
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                    <x-heroicon-o-tag class="size-4" /> Berita
                                </span>
                                <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                                    <x-heroicon-o-clock class="size-4" /> 12-12-2024
                                </time>
                            </div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900 leading-snug line-clamp-2">
                                <a href="#"
                                    class="hover:text-green-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 rounded">
                                    Pembangunan Balai Desa Mentuda Resmi Dimulai, Fasilitas Baru untuk Masyarakat
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                                Pembangunan balai desa dimulai sebagai pusat layanan publik dan kegiatan warga.
                            </p>
                        </div>
                    </article>

                    {{-- Card 2 --}}
                    <article class="rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition">
                        <a href="#" class="block">
                            <div class="aspect-[16/9] overflow-hidden rounded-t-xl">
                                <img src="{{ asset('public/img/potensi1.jpg') }}" alt="Tradisi Adat Desa Mentuda"
                                    class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.04]"
                                    loading="lazy" decoding="async">
                            </div>
                        </a>
                        <div class="p-4 md:p-5">
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                    <x-heroicon-o-tag class="size-4" /> Budaya
                                </span>
                                <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                                    <x-heroicon-o-clock class="size-4" /> 12-12-2024
                                </time>
                            </div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900 leading-snug line-clamp-2">
                                <a href="#"
                                    class="hover:text-green-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 rounded">
                                    Tradisi Adat Desa Mentuda Tetap Dilestarikan di Era Modern
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                                Warga desa aktif menjaga tradisi melalui festival tahunan dan kegiatan komunitas.
                            </p>
                        </div>
                    </article>

                    {{-- Card 3 --}}
                    <article class="rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition">
                        <a href="#" class="block">
                            <div class="aspect-[16/9] overflow-hidden rounded-t-xl">
                                <img src="{{ asset('public/img/potensi2.jpg') }}" alt="Pelatihan UMKM"
                                    class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.04]"
                                    loading="lazy" decoding="async">
                            </div>
                        </a>
                        <div class="p-4 md:p-5">
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                    <x-heroicon-o-tag class="size-4" /> UMKM
                                </span>
                                <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                                    <x-heroicon-o-clock class="size-4" /> 12-12-2024
                                </time>
                            </div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900 leading-snug line-clamp-2">
                                <a href="#"
                                    class="hover:text-green-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 rounded">
                                    Pelatihan UMKM: Dorong Perekonomian Lokal
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                                Pelatihan pemasaran digital dan pengemasan produk bagi pelaku UMKM lokal.
                            </p>
                        </div>
                    </article>

                    {{-- Card 4 (opsional) --}}
                    <article class="rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition">
                        <a href="#" class="block">
                            <div class="aspect-[16/9] overflow-hidden rounded-t-xl">
                                <img src="{{ asset('public/img/potensi1.jpg') }}" alt="Agenda Desa"
                                    class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.04]"
                                    loading="lazy" decoding="async">
                            </div>
                        </a>
                        <div class="p-4 md:p-5">
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                    <x-heroicon-o-tag class="size-4" /> Agenda
                                </span>
                                <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                                    <x-heroicon-o-clock class="size-4" /> 13-12-2024
                                </time>
                            </div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900 leading-snug line-clamp-2">
                                <a href="#"
                                    class="hover:text-green-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 rounded">
                                    Jadwal Musyawarah Desa Akhir Tahun
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                                Pembahasan program kerja dan prioritas pembangunan tahun depan.
                            </p>
                        </div>
                    </article>
                </div>

                {{-- Pagination (placeholder) --}}
                <div class="pt-4">
                    <nav class="flex justify-center" aria-label="Pagination">
                        <ul class="inline-flex items-center gap-2 text-sm">
                            <li><a href="#"
                                    class="px-3 py-1 rounded-lg border border-gray-300 text-gray-600 hover:bg-green-600 hover:text-white transition">«</a>
                            </li>
                            <li><a href="#"
                                    class="px-3 py-1 rounded-lg border border-green-600 bg-green-600 text-white">1</a></li>
                            <li><a href="#"
                                    class="px-3 py-1 rounded-lg border border-gray-300 text-gray-600 hover:bg-green-600 hover:text-white transition">2</a>
                            </li>
                            <li><a href="#"
                                    class="px-3 py-1 rounded-lg border border-gray-300 text-gray-600 hover:bg-green-600 hover:text-white transition">3</a>
                            </li>
                            <li><a href="#"
                                    class="px-3 py-1 rounded-lg border border-gray-300 text-gray-600 hover:bg-green-600 hover:text-white transition">»</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <aside class="lg:sticky lg:top-20 space-y-6" data-aos="fade-left" data-aos-delay="200">

                {{-- Search (non-fungsional untuk sekarang) --}}
                <form action="#" method="GET" class="bg-white rounded-xl shadow p-4">
                    <label for="q" class="sr-only">Cari Berita</label>
                    <div class="relative">
                        <input id="q" name="q" type="search" placeholder="Cari berita berdasarkan judul…"
                            class="w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-sm placeholder:text-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500"
                            autocomplete="off">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-3 top-1/2 -translate-y-1/2 size-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                        </svg>
                    </div>
                </form>

                {{-- Kategori (statik) --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Kategori</h4>
                    <div class="flex flex-wrap gap-2">
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border bg-green-600 border-green-600 text-white">Semua</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Berita
                            Utama</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Pengumuman</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Agenda</a>
                    </div>
                </div>

                {{-- Terbaru / Rekomendasi (statik) --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Terbaru</h4>
                    <div class="space-y-3">
                        {{-- Item 1 --}}
                        <a href="#" class="flex items-center gap-3 rounded-lg p-2 hover:bg-gray-50 transition">
                            <img src="{{ asset('public/img/potensi1.jpg') }}" alt="Thumb berita"
                                class="h-16 w-20 rounded-md object-cover ring-1 ring-black/5" loading="lazy"
                                decoding="async">
                            <div class="min-w-0">
                                <h5 class="text-sm font-medium text-gray-900 line-clamp-2 hover:text-green-700">
                                    Pembangunan Balai Desa Mentuda Resmi Dimulai
                                </h5>
                                <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                    <span class="inline-flex items-center gap-1"><x-heroicon-o-tag class="size-4" />
                                        Berita</span>
                                    <time class="inline-flex items-center gap-1"><x-heroicon-o-clock class="size-4" />
                                        12-12-2024</time>
                                </div>
                            </div>
                        </a>
                        {{-- Item 2 --}}
                        <a href="#" class="flex items-center gap-3 rounded-lg p-2 hover:bg-gray-50 transition">
                            <img src="{{ asset('public/img/potensi2.jpg') }}" alt="Thumb berita"
                                class="h-16 w-20 rounded-md object-cover ring-1 ring-black/5" loading="lazy"
                                decoding="async">
                            <div class="min-w-0">
                                <h5 class="text-sm font-medium text-gray-900 line-clamp-2 hover:text-green-700">
                                    Tradisi Adat Tetap Dilestarikan di Era Modern
                                </h5>
                                <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                    <span class="inline-flex items-center gap-1"><x-heroicon-o-tag class="size-4" />
                                        Budaya</span>
                                    <time class="inline-flex items-center gap-1"><x-heroicon-o-clock class="size-4" />
                                        12-12-2024</time>
                                </div>
                            </div>
                        </a>
                        {{-- Item 3 --}}
                        <a href="#" class="flex items-center gap-3 rounded-lg p-2 hover:bg-gray-50 transition">
                            <img src="{{ asset('public/img/potensi1.jpg') }}" alt="Thumb berita"
                                class="h-16 w-20 rounded-md object-cover ring-1 ring-black/5" loading="lazy"
                                decoding="async">
                            <div class="min-w-0">
                                <h5 class="text-sm font-medium text-gray-900 line-clamp-2 hover:text-green-700">
                                    Pelatihan UMKM Dorong Perekonomian Lokal
                                </h5>
                                <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                    <span class="inline-flex items-center gap-1"><x-heroicon-o-tag class="size-4" />
                                        UMKM</span>
                                    <time class="inline-flex items-center gap-1"><x-heroicon-o-clock class="size-4" />
                                        12-12-2024</time>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </aside>
        </div>
    </section>
@endsection
