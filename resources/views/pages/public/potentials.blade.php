@php
    $metaTitle = 'Potensi Desa';
    $metaDescription =
        'Jelajahi potensi unggulan Desa Mentuda mulai dari wisata alam, UMKM, perikanan, budaya, hingga hasil pertanian lokal.';
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative mt-16 overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Informasi</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Potensi Desa</li>
                </ol>
            </nav>

            <div class="mt-8 max-w-4xl" data-aos="fade-up" data-aos-duration="700">
                <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl">
                    Potensi Desa Mentuda
                </h1>

                <p class="mt-4 max-w-3xl text-sm leading-7 text-emerald-50/90 sm:text-sm">
                    Temukan potensi alam, budaya, UMKM, pertanian, perikanan, dan lingkungan yang menjadi kekuatan
                    Desa Mentuda untuk mendukung kesejahteraan masyarakat.
                </p>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        @if ($featuredPotential)
            <article
                class="group relative mb-8 overflow-hidden rounded-[2rem] bg-white shadow-xl ring-1 ring-gray-100 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:ring-green-200 lg:grid lg:grid-cols-12"
                data-aos="fade-up" data-aos-duration="750">

                <span
                    class="pointer-events-none absolute -left-24 top-0 z-20 h-full w-16 rotate-12 bg-white/30 blur-xl transition-all duration-1000 group-hover:left-[120%]">
                </span>

                <a href="{{ route('public.potentials.show', $featuredPotential->slug) }}"
                    class="relative block min-h-[320px] overflow-hidden lg:col-span-7 lg:min-h-[460px]">
                    <img src="{{ $featuredPotential->cover_image_url ?: asset('img/bg.jpg') }}"
                        alt="{{ $featuredPotential->cover_image_alt ?: $featuredPotential->title }}"
                        class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/45 to-black/10 transition-all duration-500 group-hover:from-black/95 group-hover:via-black/50">
                    </div>

                    <div class="absolute bottom-6 left-6 right-6 text-white md:bottom-8 md:left-8 md:right-8">
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-white/20 px-3 py-1.5 text-xs font-semibold text-white backdrop-blur ring-1 ring-white/30 transition-all duration-300 group-hover:-translate-y-1 group-hover:bg-green-600 group-hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                stroke="currentColor"
                                class="h-4 w-4 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>

                            <span>{{ $featuredPotential->location_name ?: ($featuredPotential->village?->name ?? 'Desa Mentuda') }}</span>
                        </span>

                        <h3
                            class="mt-4 text-2xl font-bold leading-tight transition-all duration-300 group-hover:translate-x-1 md:text-4xl">
                            {{ $featuredPotential->title }}
                        </h3>

                        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/85">
                            {{ \Illuminate\Support\Str::limit(strip_tags($featuredPotential->excerpt ?: $featuredPotential->content), 190) }}
                        </p>
                    </div>
                </a>

                <div class="relative flex flex-col justify-center p-6 md:p-8 lg:col-span-5 lg:p-10">
                    <span
                        class="mb-4 inline-flex w-fit items-center gap-2 rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700 ring-1 ring-green-200 transition-all duration-300 group-hover:bg-green-700 group-hover:text-white">
                        Sorotan Desa
                    </span>

                    <h3 class="text-2xl font-bold leading-tight text-gray-900 md:text-3xl">
                        {{ $featuredPotential->potential_type ?: ($featuredPotential->category?->name ?: 'Potensi Desa') }}
                    </h3>

                    <p class="mt-4 text-sm leading-relaxed text-gray-600 md:text-base">
                        {{ \Illuminate\Support\Str::limit(strip_tags($featuredPotential->opportunities ?: $featuredPotential->excerpt ?: $featuredPotential->content), 240) }}
                    </p>

                    <div class="mt-7 grid grid-cols-2 gap-3">
                        @forelse ($categories->take(4) as $category)
                            <a href="{{ route('public.potentials.index', ['category' => $category->slug]) }}"
                                class="group/item rounded-2xl {{ $selectedCategory === $category->slug ? 'bg-green-700 text-white' : 'bg-green-50 text-gray-900' }} p-4 transition-all duration-300 hover:-translate-y-1 hover:scale-[1.02] hover:bg-green-700 hover:text-white hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-300"
                                data-aos="zoom-in" data-aos-duration="600" data-aos-delay="{{ 60 + ($loop->index * 70) }}">
                                <p class="text-sm font-bold">{{ $category->name }}</p>
                                <p class="mt-1 text-xs {{ $selectedCategory === $category->slug ? 'text-white/80' : 'text-gray-500' }} group-hover/item:text-white/80">
                                    {{ $category->published_potentials_count }} potensi tersedia
                                </p>
                            </a>
                        @empty
                            <div class="col-span-2 rounded-2xl bg-gray-50 p-4 text-sm text-gray-500">
                                Belum ada kategori potensi yang dipublikasikan.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('public.potentials.show', $featuredPotential->slug) }}"
                            class="group/btn relative inline-flex items-center justify-center gap-2 overflow-hidden rounded-xl bg-green-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-green-700/20 transition-all duration-300 hover:-translate-y-1 hover:bg-green-800 hover:shadow-2xl active:scale-95">
                            <span
                                class="absolute -left-16 top-0 h-full w-10 rotate-12 bg-white/20 blur-md transition-all duration-700 group-hover/btn:left-[120%]">
                            </span>

                            <span class="relative z-10">Lihat Detail</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="relative z-10 h-4 w-4 transition-transform duration-300 group-hover/btn:translate-x-1"
                                fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        @if ($featuredPotential->contact_phone)
                            <a href="https://wa.me/{{ preg_replace('/\\D+/', '', $featuredPotential->contact_phone) }}"
                                target="_blank"
                                class="group/map inline-flex items-center justify-center gap-2 rounded-xl border border-green-700 bg-white px-6 py-3 text-sm font-semibold text-green-700 transition-all duration-300 hover:-translate-y-1 hover:bg-green-700 hover:text-white hover:shadow-xl active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 transition-all duration-300 group-hover/map:scale-110" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15A2.25 2.25 0 0 1 21.75 6.75v10.5A2.25 2.25 0 0 1 19.5 19.5h-15A2.25 2.25 0 0 1 2.25 17.25V6.75Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l9 7 9-7" />
                                </svg>
                                <span>Hubungi Kontak</span>
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        @else
            <div class="mb-8 rounded-[2rem] border border-gray-200 bg-white p-8 text-center shadow-md shadow-gray-200/60"
                data-aos="fade-up" data-aos-duration="700">
                <h3 class="text-2xl font-bold text-gray-900">Belum ada potensi yang dipublikasikan</h3>
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-gray-600">
                    Halaman publik potensi desa sudah siap memakai data asli. Setelah admin mempublish potensi desa,
                    sorotan utama dan daftar potensi akan muncul otomatis di sini.
                </p>
            </div>
        @endif

        <section id="daftar-potensi" class="mt-10 space-y-10">
            <header class="mx-auto max-w-3xl text-center" data-aos="fade-up" data-aos-duration="700" data-aos-delay="80">
                <span
                    class="mb-4 inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-1.5 text-xs font-semibold text-green-700 ring-1 ring-green-200">
                    Potensi Unggulan Desa
                </span>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 md:text-3xl">
                    Jelajahi Kategori Potensi Desa Mentuda
                </h2>
                <p class="mt-4 text-sm leading-relaxed text-gray-600 md:text-base">
                    Semua bagian di bawah ini sudah memakai data potensi desa yang dipublikasikan dari panel admin.
                </p>
            </header>

            @if ($categories->isNotEmpty())
                <div class="flex flex-wrap justify-center gap-3" data-aos="fade-up" data-aos-duration="700" data-aos-delay="120">
                    <a href="{{ route('public.potentials.index') }}"
                        class="{{ $selectedCategory === '' ? 'bg-green-700 text-white' : 'bg-white text-gray-700' }} inline-flex items-center rounded-full border border-gray-200 px-4 py-2 text-sm font-semibold shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-300">
                        Semua Kategori
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('public.potentials.index', ['category' => $category->slug]) }}"
                            class="{{ $selectedCategory === $category->slug ? 'bg-green-700 text-white' : 'bg-white text-gray-700' }} inline-flex items-center rounded-full border border-gray-200 px-4 py-2 text-sm font-semibold shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-300">
                            {{ $category->name }}
                            <span class="ml-2 rounded-full bg-black/5 px-2 py-0.5 text-xs {{ $selectedCategory === $category->slug ? 'text-white/90' : 'text-gray-500' }}">
                                {{ $category->published_potentials_count }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif

            @if ($potentials->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($potentials as $potential)
                        <a href="{{ route('public.potentials.show', $potential->slug) }}"
                            class="group block overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-md shadow-gray-200/60 transition-all duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-xl hover:shadow-green-100/70 focus:outline-none focus:ring-2 focus:ring-green-300"
                            data-aos="fade-up" data-aos-duration="650" data-aos-delay="{{ 70 + (($loop->index % 3) * 80) }}">
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ $potential->cover_image_url ?: asset('img/bg.jpg') }}"
                                    alt="{{ $potential->cover_image_alt ?: $potential->title }}"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                                <span
                                    class="absolute left-4 top-4 inline-flex rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 transition duration-300 group-hover:bg-green-700 group-hover:text-white">
                                    {{ $potential->category?->name ?? ($potential->potential_type ?: 'Potensi Desa') }}
                                </span>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-green-700 transition duration-300 group-hover:text-green-800">
                                        {{ $potential->location_name ?: ($potential->village?->name ?? 'Desa Mentuda') }}
                                    </p>
                                    @if ($potential->is_featured)
                                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700 transition duration-300 group-hover:bg-amber-100">Unggulan</span>
                                    @endif
                                </div>
                                <h3 class="mt-3 text-lg font-bold text-gray-900 transition duration-300 group-hover:text-green-800">{{ $potential->title }}</h3>
                                <p class="mt-3 text-sm leading-6 text-gray-600 transition duration-300 group-hover:text-gray-700">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($potential->excerpt ?: $potential->content), 120) }}
                                </p>
                                <div class="mt-5 flex items-center gap-2 text-sm font-semibold text-green-700 transition duration-300 group-hover:translate-x-1">
                                    <span>Lihat detail</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="rounded-[28px] border border-dashed border-gray-300 bg-white p-10 text-center shadow-sm"
                    data-aos="fade-up" data-aos-duration="700">
                    <h3 class="text-xl font-bold text-gray-900">Belum ada potensi pada kategori ini</h3>
                    <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                        Tidak ada data potensi desa yang dipublikasikan untuk filter saat ini. Coba pilih kategori lain
                        atau publish data potensi dari panel admin.
                    </p>
                </div>
            @endif
        </section>
    </section>
@endsection
