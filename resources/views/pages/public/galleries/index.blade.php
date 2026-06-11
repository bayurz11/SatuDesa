@php
    $metaTitle = 'Galeri Desa Mentuda';
    $metaDescription = 'Galeri publik Desa Mentuda yang menampilkan kegiatan warga, pembangunan desa, dan suasana kawasan.';

    $albumCategories = [
        ['label' => 'Semua Album', 'count' => 31],
        ['label' => 'Kegiatan Desa', 'count' => 12],
        ['label' => 'Pembangunan', 'count' => 8],
        ['label' => 'Wisata & Kawasan', 'count' => 6],
        ['label' => 'Pelayanan Publik', 'count' => 5],
    ];

    $galleryHighlights = [
        ['label' => 'Foto Pilihan', 'value' => '48'],
        ['label' => 'Album Aktif', 'value' => '6'],
        ['label' => 'Lokasi Dokumentasi', 'value' => '9'],
    ];

    $galleryAlbums = [
        [
            'title' => 'Gotong Royong Lingkungan',
            'category' => 'Kegiatan Desa',
            'meta' => '18 foto',
            'description' => 'Dokumentasi pembersihan jalan lingkungan, saluran air, dan area fasilitas umum oleh warga.',
            'image' => asset('img/bg.jpg'),
        ],
        [
            'title' => 'Peningkatan Jalan Desa',
            'category' => 'Pembangunan',
            'meta' => '12 foto',
            'description' => 'Potret progres pembangunan jalan desa dari tahap awal hingga penyelesaian lapangan.',
            'image' => asset('img/bg.jpg'),
        ],
        [
            'title' => 'Suasana Pesisir Mentuda',
            'category' => 'Wisata & Kawasan',
            'meta' => '15 foto',
            'description' => 'Album visual yang menampilkan garis pantai, aktivitas nelayan, dan panorama sore hari.',
            'image' => asset('img/bg.jpg'),
        ],
        [
            'title' => 'Posyandu dan Layanan Warga',
            'category' => 'Pelayanan Publik',
            'meta' => '10 foto',
            'description' => 'Dokumentasi pelayanan kesehatan dasar, antrean warga, dan pendampingan kader desa.',
            'image' => asset('img/bg.jpg'),
        ],
    ];

    $recentAlbums = [
        ['title' => 'Pelatihan UMKM Rumah Tangga', 'category' => 'Kegiatan Desa', 'date' => '08 Juni 2026', 'image' => asset('img/bg.jpg')],
        ['title' => 'Monitoring Drainase Lingkungan', 'category' => 'Pembangunan', 'date' => '02 Juni 2026', 'image' => asset('img/bg.jpg')],
        ['title' => 'Pasar Pagi Warga', 'category' => 'Wisata & Kawasan', 'date' => '28 Mei 2026', 'image' => asset('img/bg.jpg')],
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
                    <li>Informasi</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Galeri Desa</li>
                </ol>
            </nav>

            <div class="max-w-4xl" data-aos="fade-up">
                <span
                    class="mt-5 inline-flex items-center rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-50 ring-1 ring-white/15">
                    Dokumentasi Visual
                </span>

                <h1 class="mt-5 max-w-2xl text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-[2rem] lg:leading-tight">
                    Galeri Desa Mentuda
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-50/90">
                    Kumpulan dokumentasi kegiatan desa, hasil pembangunan, potret kawasan, dan momen kebersamaan warga
                    yang disusun agar mudah dijelajahi pengunjung.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto -mt-10 max-w-7xl px-4 pb-14 sm:px-6 lg:px-8 z-10 relative">
        <div class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-xl shadow-gray-200/60 sm:p-6"
            data-aos="fade-up" data-aos-delay="150">
            <div class="grid gap-4 lg:grid-cols-[1.4fr_1fr]">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Arah Halaman Galeri</h2>
                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Fokus halaman ini adalah album visual. Karena itu blok utamanya menonjolkan dokumentasi unggulan,
                        ringkasan album, dan susunan kartu foto per kategori.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-3">
                    @foreach ($galleryHighlights as $highlight)
                        <div class="rounded-2xl bg-green-50 px-4 py-4">
                            <p class="text-xl font-bold text-green-800">{{ $highlight['value'] }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.2em] text-green-700">{{ $highlight['label'] }}</p>
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
                        <img src="{{ asset('img/bg.jpg') }}" alt="Festival pesisir Desa Mentuda"
                            class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/35 to-black/10"></div>

                        <div class="absolute left-5 right-5 bottom-5 text-white md:left-8 md:right-8 md:bottom-8">
                            <div class="mb-4 flex flex-wrap items-center gap-3">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                                    Album Unggulan
                                </span>

                                <span class="inline-flex items-center gap-1.5 text-sm text-white/90">
                                    Kegiatan Desa
                                </span>

                                <span class="inline-flex items-center gap-1.5 text-sm text-white/90">
                                    24 Mei 2026
                                </span>
                            </div>

                            <h2
                                class="max-w-3xl text-2xl font-bold leading-tight text-white transition-all duration-300 group-hover:text-green-300 group-hover:drop-shadow-lg md:text-4xl">
                                Festival Pesisir dan Kebersamaan Warga
                            </h2>

                            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/85 md:text-sm">
                                Album utama ini menampilkan rangkaian kegiatan festival, persiapan warga, panggung seni,
                                dan suasana kebersamaan di ruang publik desa.
                            </p>
                        </div>
                    </div>
                </article>

                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    @foreach ($galleryAlbums as $album)
                        <article data-aos="fade-up" data-aos-delay="{{ min(($loop->index % 2) * 80, 160) }}"
                            class="group overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-md shadow-gray-200/60 transition hover:-translate-y-1 hover:shadow-xl">
                            <div class="block">
                                <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                    <img src="{{ $album['image'] }}" alt="{{ $album['title'] }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-105">

                                    <span
                                        class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                                        {{ $album['category'] }}
                                    </span>
                                </div>

                                <div class="p-5">
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                        <span>{{ $album['meta'] }}</span>
                                    </div>

                                    <h3 class="mt-3 line-clamp-2 text-lg font-bold tracking-tight text-gray-900 transition group-hover:text-green-700">
                                        {{ $album['title'] }}
                                    </h3>

                                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">
                                        {{ $album['description'] }}
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
                    <h2 class="text-lg font-bold text-gray-900">Kategori Album</h2>

                    <div class="mt-5 flex flex-wrap gap-3">
                        @foreach ($albumCategories as $category)
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
                    <h2 class="text-lg font-bold text-gray-900">Album Terbaru</h2>

                    <div class="mt-5 space-y-4">
                        @foreach ($recentAlbums as $album)
                            <div data-aos="fade-left" data-aos-delay="{{ 60 + $loop->index * 50 }}"
                                class="group flex gap-4 rounded-2xl bg-white p-3 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-green-200">
                                <img src="{{ $album['image'] }}" alt="{{ $album['title'] }}"
                                    class="h-20 w-24 shrink-0 rounded-xl object-cover transition-transform duration-300 group-hover:scale-105">

                                <div class="min-w-0">
                                    <h3 class="line-clamp-2 text-sm font-bold leading-snug text-gray-900 transition-colors duration-300 group-hover:text-green-700 md:text-base">
                                        {{ $album['title'] }}
                                    </h3>

                                    <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                        <span>{{ $album['category'] }}</span>
                                        <span>{{ $album['date'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="220"
                    class="rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <h2 class="text-lg font-bold">Galeri siap dikembangkan</h2>
                    <p class="mt-3 text-sm leading-6 text-white/85">
                        Struktur ini sudah siap untuk dilanjutkan ke album dinamis, lightbox foto, dan filter kategori dari admin.
                    </p>
                    <a href="{{ route('home') }}"
                        class="mt-6 inline-flex items-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-green-800 transition hover:bg-emerald-50">
                        Kembali ke Beranda
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection
