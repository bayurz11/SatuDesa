@php
    $metaTitle = 'UMKM Desa Mentuda';
    $metaDescription = 'Etalase UMKM Desa Mentuda berisi profil usaha lokal, produk unggulan, dan kontak pemesanan.';

    $businessCategories = [
        ['label' => 'Semua Kategori', 'count' => 25],
        ['label' => 'Kuliner', 'count' => 9],
        ['label' => 'Kerajinan', 'count' => 5],
        ['label' => 'Perdagangan', 'count' => 7],
        ['label' => 'Jasa', 'count' => 4],
    ];

    $businessStats = [
        ['label' => 'Pelaku Usaha', 'value' => '36'],
        ['label' => 'Produk Unggulan', 'value' => '18'],
        ['label' => 'Kategori Usaha', 'value' => '5'],
    ];

    $businessItems = [
        [
            'title' => 'Mentuda Snack House',
            'category' => 'Kuliner',
            'meta' => 'Kerupuk ikan, kue kering, sambal',
            'description' => 'Produksi camilan rumahan dengan fokus pada oleh-oleh khas desa dan paket acara.',
            'image' => asset('img/bg.jpg'),
        ],
        [
            'title' => 'Anyaman Bahari',
            'category' => 'Kerajinan',
            'meta' => 'Tas anyaman, dekorasi rumah',
            'description' => 'Usaha kerajinan tangan berbasis bahan lokal dengan model yang cocok untuk pasar wisata.',
            'image' => asset('img/bg.jpg'),
        ],
        [
            'title' => 'Warung Pagi Ibu Rina',
            'category' => 'Perdagangan',
            'meta' => 'Sarapan, kopi, kebutuhan harian',
            'description' => 'Warung warga yang melayani sarapan pagi dan kebutuhan praktis masyarakat sekitar.',
            'image' => asset('img/bg.jpg'),
        ],
        [
            'title' => 'Servis Mesin Nelayan',
            'category' => 'Jasa',
            'meta' => 'Perawatan mesin tempel',
            'description' => 'Layanan teknis untuk perawatan dan perbaikan ringan mesin kapal nelayan desa.',
            'image' => asset('img/bg.jpg'),
        ],
    ];

    $businessHighlights = [
        ['title' => 'Paket Oleh-Oleh Laut', 'category' => 'Kuliner', 'date' => 'Siap pesan', 'image' => asset('img/bg.jpg')],
        ['title' => 'Souvenir Anyaman Mini', 'category' => 'Kerajinan', 'date' => 'Stok mingguan', 'image' => asset('img/bg.jpg')],
        ['title' => 'Layanan Antar Pesanan', 'category' => 'Jasa', 'date' => 'Area desa', 'image' => asset('img/bg.jpg')],
    ];
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white mt-16">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-up">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Ekonomi Desa</li>
                    <li>/</li>
                    <li class="font-semibold text-white">UMKM</li>
                </ol>
            </nav>

            <div class="max-w-4xl" data-aos="fade-up">
                <span
                    class="mt-5 inline-flex items-center rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-50 ring-1 ring-white/15">
                    Etalase Usaha
                </span>

                <h1 class="mt-5 max-w-2xl text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-[2rem] lg:leading-tight">
                    UMKM Desa Mentuda
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-50/90">
                    Halaman publik untuk memperkenalkan pelaku usaha lokal, produk unggulan, dan akses pemesanan yang
                    mudah bagi warga maupun pengunjung.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto -mt-10 max-w-7xl px-4 pb-14 sm:px-6 lg:px-8 z-10 relative">
        <div class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-xl shadow-gray-200/60 sm:p-6"
            data-aos="fade-up" data-aos-delay="150">
            <div class="grid gap-4 lg:grid-cols-[1.4fr_1fr]">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Arah Halaman UMKM</h2>
                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Modul ini difokuskan menjadi etalase usaha. Karena itu susunannya menonjolkan usaha unggulan,
                        katalog ringkas, dan ruang promosi produk desa.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-3">
                    @foreach ($businessStats as $stat)
                        <div class="rounded-2xl bg-green-50 px-4 py-4">
                            <p class="text-xl font-bold text-green-800">{{ $stat['value'] }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.2em] text-green-700">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px]">
            <main>
                <article data-aos="fade-up" data-aos-delay="80"
                    class="group relative overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:ring-green-200">
                    <div class="relative block h-[360px] md:h-[520px]">
                        <img src="{{ asset('img/bg.jpg') }}" alt="Usaha unggulan Desa Mentuda"
                            class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/35 to-black/10"></div>

                        <div class="absolute left-5 right-5 bottom-5 text-white md:left-8 md:right-8 md:bottom-8">
                            <div class="mb-4 flex flex-wrap items-center gap-3">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                                    Usaha Unggulan
                                </span>

                                <span class="inline-flex items-center gap-1.5 text-sm text-white/90">
                                    Kuliner Olahan
                                </span>

                                <span class="inline-flex items-center gap-1.5 text-sm text-white/90">
                                    Buka setiap hari
                                </span>
                            </div>

                            <h2
                                class="max-w-3xl text-2xl font-bold leading-tight text-white transition-all duration-300 group-hover:text-green-300 group-hover:drop-shadow-lg md:text-4xl">
                                Dapur Laut Mentuda
                            </h2>

                            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/85 md:text-sm">
                                Usaha unggulan yang memproduksi kerupuk ikan, sambal khas pesisir, dan paket oleh-oleh
                                rumahan dengan kemasan yang siap dipromosikan.
                            </p>
                        </div>
                    </div>
                </article>

                <div class="mt-8 rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60" data-aos="fade-up">
                    <div class="grid gap-4 lg:grid-cols-3">
                        <div class="rounded-2xl bg-amber-50 px-5 py-5">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-700">Katalog</p>
                            <p class="mt-2 text-sm leading-6 text-gray-700">Setiap kartu usaha bisa diisi nama usaha, produk, kontak, dan ringkasan singkat.</p>
                        </div>
                        <div class="rounded-2xl bg-emerald-50 px-5 py-5">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-700">Promosi</p>
                            <p class="mt-2 text-sm leading-6 text-gray-700">Blok unggulan cocok dipakai untuk mendorong produk yang paling siap dipasarkan.</p>
                        </div>
                        <div class="rounded-2xl bg-sky-50 px-5 py-5">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-700">Kontak</p>
                            <p class="mt-2 text-sm leading-6 text-gray-700">Tahap berikutnya mudah ditambah tombol WhatsApp, lokasi, atau tautan katalog.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    @foreach ($businessItems as $business)
                        <article data-aos="fade-up" data-aos-delay="{{ min(($loop->index % 2) * 80, 160) }}"
                            class="group overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-md shadow-gray-200/60 transition hover:-translate-y-1 hover:shadow-xl">
                            <div class="block">
                                <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                    <img src="{{ $business['image'] }}" alt="{{ $business['title'] }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-105">

                                    <span
                                        class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                                        {{ $business['category'] }}
                                    </span>
                                </div>

                                <div class="p-5">
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                        <span>{{ $business['meta'] }}</span>
                                    </div>

                                    <h3 class="mt-3 line-clamp-2 text-lg font-bold tracking-tight text-gray-900 transition group-hover:text-green-700">
                                        {{ $business['title'] }}
                                    </h3>

                                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">
                                        {{ $business['description'] }}
                                    </p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60"
                    data-aos="fade-left" data-aos-delay="120">
                    <h2 class="text-lg font-bold text-gray-900">Kategori Usaha</h2>

                    <div class="mt-5 flex flex-wrap gap-3">
                        @foreach ($businessCategories as $category)
                            <span
                                class="inline-flex items-center rounded-full border px-4 py-2 text-sm {{ $loop->first ? 'border-green-700 bg-green-700 text-white' : 'border-gray-200 text-gray-700 hover:border-green-200 hover:bg-green-50 hover:text-green-700' }}">
                                {{ $category['label'] }}
                                <span class="ml-2 text-xs {{ $loop->first ? 'text-white/80' : 'text-gray-400' }}">{{ $category['count'] }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60"
                    data-aos="fade-left" data-aos-delay="180">
                    <h2 class="text-lg font-bold text-gray-900">Produk & Usaha Pilihan</h2>

                    <div class="mt-5 space-y-4">
                        @foreach ($businessHighlights as $highlight)
                            <div data-aos="fade-left" data-aos-delay="{{ 60 + $loop->index * 50 }}"
                                class="group flex gap-4 rounded-2xl bg-white p-3 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-green-200">
                                <img src="{{ $highlight['image'] }}" alt="{{ $highlight['title'] }}"
                                    class="h-20 w-24 shrink-0 rounded-xl object-cover transition-transform duration-300 group-hover:scale-105">

                                <div class="min-w-0">
                                    <h3 class="line-clamp-2 text-sm font-bold leading-snug text-gray-900 transition-colors duration-300 group-hover:text-green-700 md:text-base">
                                        {{ $highlight['title'] }}
                                    </h3>

                                    <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                        <span>{{ $highlight['category'] }}</span>
                                        <span>{{ $highlight['date'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="220"
                    class="rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <h2 class="text-lg font-bold">Etalase UMKM siap diperluas</h2>
                    <p class="mt-3 text-sm leading-6 text-white/85">
                        Nantinya halaman ini bisa dilanjutkan ke detail UMKM, katalog produk, dan tombol pemesanan langsung.
                    </p>
                    <a href="{{ route('home') }}"
                        class="mt-6 inline-flex items-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-green-800 transition hover:bg-emerald-50">
                        Lihat Beranda
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection
