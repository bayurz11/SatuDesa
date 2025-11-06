@extends('layouts.app2')

@section('title', 'Potensi Desa')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="#" class="hover:text-green-700">Informasi</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Potensi Desa</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Potensi Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Gambaran potensi ekonomi, pariwisata, pertanian, perikanan, industri kreatif, hingga lingkungan
                yang menjadi kekuatan Desa Mentuda.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-8">

                {{-- Highlight / Hero Potensi --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="grid md:grid-cols-12 gap-0">
                        <figure class="md:col-span-7 h-56 md:h-72 overflow-hidden">
                            <img src="public/img/potensi2.jpg" alt="Panorama Pariwisata" class="h-full w-full object-cover"
                                loading="lazy" decoding="async">
                        </figure>
                        <div class="md:col-span-5 p-6 md:p-8 flex flex-col justify-center">
                            <span
                                class="inline-flex items-center gap-1 w-fit rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                <x-heroicon-o-sparkles class="size-4" /> Sorotan
                            </span>
                            <h2 class="mt-3 text-xl md:text-2xl font-semibold text-gray-900">
                                Wisata Alam & Bahari
                            </h2>
                            <p class="mt-2 text-gray-700">
                                Garis pantai, pasir putih, dan perairan yang kaya biota laut menjadi peluang pariwisata
                                edukasi dan konservasi.
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('potensi-desa-detail') }}"
                                    class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                    <x-heroicon-o-eye class="size-4" /> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter kategori (placeholder) --}}
                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <div class="flex flex-wrap gap-2">
                        @foreach (['Semua', 'Ekonomi', 'Pariwisata', 'Pertanian', 'Perikanan', 'Industri Kreatif', 'Lingkungan'] as $k)
                            <a href="#"
                                class="px-3 py-1.5 rounded-lg text-sm border {{ $k === 'Semua' ? 'bg-green-600 border-green-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition' }}">
                                {{ $k }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Grid Potensi --}}
                @php
                    $potensi = [
                        [
                            'img' => 'public/img/potensi1.jpg',
                            'judul' => 'Perikanan: Ikan Bilis & Kerapu',
                            'desc' => 'Komoditas unggulan yang menopang pendapatan warga dan bahan baku olahan lokal.',
                            'tag' => 'Perikanan',
                        ],
                        [
                            'img' => 'public/img/potensi2.jpg',
                            'judul' => 'Pariwisata Alam',
                            'desc' => 'Pantai & teluk yang potensial untuk wisata bahari, edukasi, dan fotografi alam.',
                            'tag' => 'Pariwisata',
                        ],
                        [
                            'img' => 'public/img/potensi1.jpg',
                            'judul' => 'Pertanian Kelapa & Hortikultura',
                            'desc' => 'Kelapa, sayur, dan buah lokal sebagai penopang ketahanan pangan desa.',
                            'tag' => 'Pertanian',
                        ],
                        [
                            'img' => 'public/img/potensi2.jpg',
                            'judul' => 'Industri Kreatif',
                            'desc' => 'Kerajinan tangan, kuliner khas, dan produk kreatif yang bernilai jual.',
                            'tag' => 'Industri Kreatif',
                        ],
                        [
                            'img' => 'public/img/potensi1.jpg',
                            'judul' => 'Ekonomi UMKM',
                            'desc' => 'Unit usaha skala rumahan berkembang dengan dukungan pemasaran digital.',
                            'tag' => 'Ekonomi',
                        ],
                        [
                            'img' => 'public/img/potensi2.jpg',
                            'judul' => 'Konservasi & Lingkungan',
                            'desc' => 'Upaya menjaga ekosistem pesisir dan hutan mangrove untuk keberlanjutan.',
                            'tag' => 'Lingkungan',
                        ],
                    ];
                @endphp

                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ($potensi as $p)
                        <div x-data="{ open: false }"
                            class="group rounded-2xl bg-white shadow ring-1 ring-black/5 overflow-hidden">
                            <div class="aspect-[16/9] bg-gray-100">
                                <img src="{{ $p['img'] }}" alt="{{ $p['judul'] }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale"
                                    loading="lazy" decoding="async">
                            </div>
                            <div class="p-4">
                                <div class="mb-1 flex flex-wrap items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                        <x-heroicon-o-tag class="size-4" /> {{ $p['tag'] }}
                                    </span>
                                </div>
                                <h3 class="text-sm md:text-base font-semibold text-gray-900">{{ $p['judul'] }}</h3>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $p['desc'] }}</p>

                                <div class="mt-3 flex items-center justify-between">
                                    <a href="#"
                                        class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-1.5 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                        <x-heroicon-o-eye class="size-4" /> Detail
                                    </a>
                                    <button @click="open=true"
                                        class="inline-flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-green-700 transition">
                                        <x-heroicon-o-arrows-pointing-out class="size-4" /> Pratayang
                                    </button>
                                </div>
                            </div>

                            {{-- Modal Preview --}}
                            <div x-show="open" x-transition x-cloak @click.self="open=false"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
                                <div class="relative max-w-xl w-full bg-white rounded-2xl shadow ring-1 ring-black/5 p-6">
                                    <button @click="open=false" aria-label="Tutup"
                                        class="absolute right-3 top-3 inline-flex items-center justify-center rounded-full bg-gray-100 p-1.5 text-gray-600 hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-600">✕</button>
                                    <img src="{{ $p['img'] }}" alt="{{ $p['judul'] }}"
                                        class="w-full h-64 object-cover rounded-lg">
                                    <h4 class="mt-4 text-lg font-semibold text-gray-900">{{ $p['judul'] }}</h4>
                                    <p class="mt-1 text-sm text-gray-600">{{ $p['desc'] }}</p>
                                    <div class="mt-4 flex items-center gap-2">
                                        <a href="#"
                                            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                            <x-heroicon-o-link class="size-4" /> Buka Halaman
                                        </a>
                                        <a href="#"
                                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                            <x-heroicon-o-share class="size-4" /> Bagikan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- CTA --}}
                <div class="rounded-2xl border border-green-200 bg-green-50/60 p-5 md:p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900">Punya data potensi tambahan?</h3>
                            <p class="text-sm text-gray-700">Kirimkan informasi untuk memperkaya basis data potensi desa.
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="#"
                                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                <x-heroicon-o-paper-airplane class="size-4" /> Kirim Data
                            </a>
                            <a href="#"
                                class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                <x-heroicon-o-inbox class="size-4" /> Kontak Admin
                            </a>
                        </div>
                    </div>
                </div>

            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-3">Ringkasan Cepat</h3>
                    <ul class="space-y-2 text-sm text-gray-700">

                        <li class="flex items-center gap-2">
                            {{-- chart-bar --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 19.5h18M6 17V9m6 8V5m6 12v-6" />
                            </svg>
                            Ekonomi &amp; UMKM
                        </li>

                        <li class="flex items-center gap-2">
                            {{-- map --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 20.25l-6-2.25V5.25l6 2.25m0 12.75l6-2.25m-6 2.25V7.5m6 10.5l6 2.25V8.25l-6-2.25m0 12.75V6" />
                            </svg>
                            Pariwisata Alam
                        </li>

                        <li class="flex items-center gap-2">
                            {{-- globe-alt --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3 7.5 7.03 7.5 12s2.015 9 4.5 9zm-7.5-9h15" />
                            </svg>
                            Pertanian &amp; Lingkungan
                        </li>

                        <li class="flex items-center gap-2">
                            {{-- camera (sebagai ikon “kreatif”) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8.25h3.75L8.25 6h7.5l1.5 2.25H21A1.5 1.5 0 0122.5 9.75v8.25A1.5 1.5 0 0121 19.5H3a1.5 1.5 0 01-1.5-1.5V9.75A1.5 1.5 0 013 8.25zm9 9a4.5 4.5 0 100-9 4.5 4.5 0 000 9z" />
                            </svg>
                            Industri Kreatif
                        </li>

                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-3">Tautan Terkait</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('berita') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-newspaper class="size-4" /> Berita Desa</a></li>
                        <li><a href="{{ route('umkm') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-building-storefront class="size-4" /> UMKM Desa</a></li>
                        <li><a href="{{ route('peta-desa') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-map-pin class="size-4" /> Profil Wilayah</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </section>
@endsection
