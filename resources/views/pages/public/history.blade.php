@php
    $metaTitle = 'Sejarah Desa';
    $metaDescription = 'Menyusuri jejak perjalanan panjang Desa Mentuda dari masa lampau hingga kini.';
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative mt-16 overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]">
        </div>
        <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-white/10 to-transparent"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-24 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li class="text-emerald-100/50">/</li>
                    <li>Profil Desa</li>
                    <li class="text-emerald-100/50">/</li>
                    <li class="font-semibold text-white">Sejarah Desa</li>
                </ol>
            </nav>

            <div class="mt-10 max-w-4xl" data-aos="fade-up">
                <span
                    class="inline-flex items-center rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-emerald-50 ring-1 ring-white/20 backdrop-blur">
                    Profil Desa
                </span>

                <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Sejarah Desa Mentuda
                </h1>

                <p class="mt-5 max-w-2xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                    Menyusuri jejak perjalanan panjang Desa Mentuda dari masa lampau hingga kini.
                </p>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-14 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px]">
            <main class="space-y-8">

                <article class="overflow-hidden rounded-[34px] border border-gray-200 bg-white shadow-xl shadow-gray-200/70"
                    data-aos="fade-up">
                    <div
                        class="relative h-[340px] overflow-hidden bg-gradient-to-br from-green-800 via-green-700 to-emerald-600">
                        <img src="{{ asset('img/bg.jpg') }}" alt="Sejarah Desa Mentuda"
                            class="h-full w-full object-cover transition duration-700 hover:scale-105">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/35 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-white/90 px-4 py-1.5 text-xs font-semibold text-green-700 shadow-sm">
                                <span class="h-2 w-2 rounded-full bg-green-700"></span>
                                Arsip Desa
                            </span>

                            <h2 class="mt-4 max-w-2xl text-2xl font-bold leading-tight text-white sm:text-3xl">
                                Jejak Perjalanan Desa dari Masa ke Masa
                            </h2>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <p class="text-sm leading-8 text-gray-600 sm:text-base">
                            Desa Mentuda tumbuh dari komunitas masyarakat pesisir yang memiliki hubungan erat
                            dengan laut, pertanian, dan tradisi gotong royong. Dalam lintasan sejarahnya,
                            desa ini berkembang menjadi ruang hidup yang menghubungkan warisan budaya lama
                            dengan kebutuhan masyarakat modern.
                        </p>
                    </div>
                </article>

                <section class="grid gap-6 md:grid-cols-2">
                    <article
                        class="group rounded-[30px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-xl hover:shadow-gray-200/80"
                        data-aos="fade-up">
                        <div
                            class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 21h18M4 21V9l8-6 8 6v12M9 21v-6h6v6" />
                            </svg>
                        </div>

                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">
                            Awal Mula
                        </span>

                        <h3 class="mt-3 text-xl font-bold text-gray-900">
                            Asal-Usul Pemukiman
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-gray-600">
                            Kawasan Mentuda dipercaya mulai dihuni oleh kelompok masyarakat yang menetap
                            di sekitar jalur pesisir dan memanfaatkan sumber daya alam secara turun-temurun.
                        </p>
                    </article>

                    <article
                        class="group rounded-[30px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-xl hover:shadow-gray-200/80"
                        data-aos="fade-up" data-aos-delay="100">
                        <div
                            class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                            </svg>
                        </div>

                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">
                            Perkembangan
                        </span>

                        <h3 class="mt-3 text-xl font-bold text-gray-900">
                            Pertumbuhan Sosial dan Ekonomi
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-gray-600">
                            Seiring waktu, aktivitas masyarakat meluas pada sektor perikanan, perdagangan lokal,
                            dan usaha rumah tangga yang memperkuat fondasi ekonomi desa.
                        </p>
                    </article>
                </section>

                <section class="rounded-[34px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 sm:p-8"
                    data-aos="fade-up">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div class="max-w-3xl">
                            <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">
                                Linimasa
                            </span>
                            <h3 class="mt-3 text-2xl font-bold text-gray-900">
                                Tonggak Sejarah Desa
                            </h3>
                        </div>
                    </div>

                    <div class="mt-8 space-y-5">
                        @foreach ([
            [
                'no' => '1',
                'periode' => 'Periode Awal',
                'judul' => 'Pembentukan Komunitas Permukiman',
                'isi' => 'Masyarakat mulai membentuk kawasan hunian tetap dan mengembangkan pola hidup berbasis kebersamaan.',
            ],
            [
                'no' => '2',
                'periode' => 'Periode Penguatan',
                'judul' => 'Pengembangan Wilayah dan Kelembagaan',
                'isi' => 'Infrastruktur dasar dan tata kelola desa berkembang untuk menjawab kebutuhan warga yang semakin beragam.',
            ],
            [
                'no' => '3',
                'periode' => 'Periode Modern',
                'judul' => 'Transformasi Pelayanan dan Informasi Publik',
                'isi' => 'Desa mulai beradaptasi dengan kebutuhan digital, transparansi informasi, dan peningkatan kualitas layanan publik.',
            ],
        ] as $index => $item)
                            <div
                                class="relative flex gap-4 rounded-3xl border border-gray-100 bg-gray-50/70 p-5 transition duration-300 hover:border-green-100 hover:bg-green-50/40">
                                <div class="flex flex-col items-center">
                                    <span
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-green-700 text-sm font-bold text-white shadow-md shadow-green-700/20">
                                        {{ $item['no'] }}
                                    </span>

                                    @if (!$loop->last)
                                        <span class="mt-3 h-full min-h-10 w-px bg-green-100"></span>
                                    @endif
                                </div>

                                <div class="pb-1">
                                    <p class="text-sm font-semibold text-green-700">
                                        {{ $item['periode'] }}
                                    </p>

                                    <h4 class="mt-1 text-lg font-bold text-gray-900">
                                        {{ $item['judul'] }}
                                    </h4>

                                    <p class="mt-2 text-sm leading-7 text-gray-600">
                                        {{ $item['isi'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-[30px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60"
                    data-aos="fade-left">
                    <h2 class="text-lg font-bold text-gray-900">Bagian Profil</h2>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Jelajahi informasi utama mengenai profil Desa Mentuda.
                    </p>

                    <div class="mt-5 space-y-3">
                        <a href="{{ route('public.history') }}"
                            class="flex items-center justify-between rounded-2xl bg-green-700 px-4 py-3 text-sm font-semibold text-white shadow-md shadow-green-700/20 transition hover:-translate-y-0.5">
                            <span>Sejarah Desa</span>
                            <span>&rarr;</span>
                        </a>

                        <a href="{{ route('public.vision-mission') }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700">
                            <span>Visi &amp; Misi</span>
                            <span>&rarr;</span>
                        </a>

                        <a href="{{ route('public.organization-structure') }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700">
                            <span>Struktur Organisasi</span>
                            <span>&rarr;</span>
                        </a>

                        <a href="{{ route('public.village-map') }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700">
                            <span>Peta Desa</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-hidden rounded-[30px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20"
                    data-aos="fade-left" data-aos-delay="100">
                    <div
                        class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                        </svg>
                    </div>

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
