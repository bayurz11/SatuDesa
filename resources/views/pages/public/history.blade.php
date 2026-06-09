@php
    $metaTitle = 'Sejarah Desa';
    $metaDescription = 'Menyusuri jejak perjalanan panjang Desa Mentuda dari masa lampau hingga kini.';
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white mt-16">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Profil Desa</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Sejarah Desa</li>
                </ol>
            </nav>

            <div class="mt-8 max-w-4xl">

                <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl">
                    Sejarah Desa Mentuda
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-7 text-emerald-50/90 sm:text-sm">
                    Menyusuri jejak perjalanan panjang Desa Mentuda dari masa lampau hingga kini.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8 relative z-10">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <main class="space-y-8">
                <article
                    class="overflow-hidden rounded-[32px] border border-gray-200 bg-white shadow-lg shadow-gray-200/70">
                    <div
                        class="relative h-[320px] overflow-hidden bg-gradient-to-br from-green-800 via-green-700 to-emerald-600">
                        <img src="{{ asset('img/bg.jpg') }}" alt="Sejarah Desa Mentuda" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>

                        <div class="absolute left-6 bottom-6 right-6 text-white">
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700">
                                Arsip Desa
                            </span>
                            <h2 class="mt-4 text-2xl font-bold sm:text-3xl">
                                Jejak Perjalanan Desa dari Masa ke Masa
                            </h2>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <p class="text-sm leading-7 text-gray-600 sm:text-sm">
                            Desa Mentuda tumbuh dari komunitas masyarakat pesisir yang memiliki hubungan erat
                            dengan laut, pertanian, dan tradisi gotong royong. Dalam lintasan sejarahnya,
                            desa ini berkembang menjadi ruang hidup yang menghubungkan warisan budaya lama
                            dengan kebutuhan masyarakat modern.
                        </p>
                    </div>
                </article>

                <section class="grid gap-6 md:grid-cols-2">
                    <article class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Awal Mula</span>
                        <h3 class="mt-3 text-xl font-bold text-gray-900">Asal-Usul Pemukiman</h3>
                        <p class="mt-4 text-sm leading-7 text-gray-600">
                            Kawasan Mentuda dipercaya mulai dihuni oleh kelompok masyarakat yang menetap
                            di sekitar jalur pesisir dan memanfaatkan sumber daya alam secara turun-temurun.
                        </p>
                    </article>

                    <article class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Perkembangan</span>
                        <h3 class="mt-3 text-xl font-bold text-gray-900">Pertumbuhan Sosial dan Ekonomi</h3>
                        <p class="mt-4 text-sm leading-7 text-gray-600">
                            Seiring waktu, aktivitas masyarakat meluas pada sektor perikanan, perdagangan lokal,
                            dan usaha rumah tangga yang memperkuat fondasi ekonomi desa.
                        </p>
                    </article>
                </section>

                <section class="rounded-[32px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 sm:p-8">
                    <div class="max-w-3xl">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Linimasa</span>
                        <h3 class="mt-3 text-2xl font-bold text-gray-900">Tonggak Sejarah Desa</h3>
                    </div>

                    <div class="mt-8 space-y-6">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-green-700 text-sm font-bold text-white">1</span>
                                <span class="mt-2 h-full w-px bg-green-100"></span>
                            </div>
                            <div class="pb-6">
                                <p class="text-sm font-semibold text-green-700">Periode Awal</p>
                                <h4 class="mt-1 text-lg font-bold text-gray-900">Pembentukan Komunitas Permukiman</h4>
                                <p class="mt-2 text-sm leading-7 text-gray-600">
                                    Masyarakat mulai membentuk kawasan hunian tetap dan mengembangkan pola hidup berbasis
                                    kebersamaan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-green-700 text-sm font-bold text-white">2</span>
                                <span class="mt-2 h-full w-px bg-green-100"></span>
                            </div>
                            <div class="pb-6">
                                <p class="text-sm font-semibold text-green-700">Periode Penguatan</p>
                                <h4 class="mt-1 text-lg font-bold text-gray-900">Pengembangan Wilayah dan Kelembagaan</h4>
                                <p class="mt-2 text-sm leading-7 text-gray-600">
                                    Infrastruktur dasar dan tata kelola desa berkembang untuk menjawab kebutuhan warga yang
                                    semakin beragam.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-green-700 text-sm font-bold text-white">3</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-green-700">Periode Modern</p>
                                <h4 class="mt-1 text-lg font-bold text-gray-900">Transformasi Pelayanan dan Informasi Publik
                                </h4>
                                <p class="mt-2 text-sm leading-7 text-gray-600">
                                    Desa mulai beradaptasi dengan kebutuhan digital, transparansi informasi, dan peningkatan
                                    kualitas layanan publik.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60">
                    <h2 class="text-lg font-bold text-gray-900">Bagian Profil</h2>
                    <div class="mt-5 space-y-3">
                        <a href="{{ route('public.history') }}"
                            class="flex items-center justify-between rounded-2xl bg-green-700 px-4 py-3 text-sm font-semibold text-white">
                            <span>Sejarah Desa</span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('public.vision-mission') }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-green-200 hover:bg-green-50 hover:text-green-700">
                            <span>Visi &amp; Misi</span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('public.organization-structure') }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-green-200 hover:bg-green-50 hover:text-green-700">
                            <span>Struktur Organisasi</span>
                            <span>&rarr;</span>
                        </a>
                        <a href="{{ route('public.village-map') }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-green-200 hover:bg-green-50 hover:text-green-700">
                            <span>Peta Desa</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>

                <div
                    class="rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <h2 class="text-lg font-bold">Catatan Desain</h2>
                    <p class="mt-3 text-sm leading-6 text-white/85">
                        Bagian ini bisa dipakai untuk menguji layout narasi panjang, blok timeline, quote,
                        foto arsip, atau fakta sejarah sebelum dihubungkan ke data dinamis.
                    </p>
                </div>
            </aside>
        </div>
    </section>
@endsection
