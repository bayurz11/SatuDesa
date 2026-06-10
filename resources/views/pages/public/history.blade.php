@php
    $metaTitle = 'Sejarah Desa';
    $metaDescription = 'Menyusuri jejak perjalanan panjang Desa Mentuda dari masa lampau hingga kini.';
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative mt-16 overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-down">
                <ol class="flex flex-wrap items-center gap-2">
                    <li>
                        <a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a>
                    </li>
                    <li>/</li>
                    <li>Profil Desa</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Sejarah Desa</li>
                </ol>
            </nav>

            <div class="mt-8 max-w-4xl" data-aos="fade-up" data-aos-delay="100">
                <span
                    class="inline-flex items-center rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-50 ring-1 ring-white/15">
                    Profil Desa
                </span>

                <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl">
                    Sejarah Desa Mentuda
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-7 text-emerald-50/90">
                    Menyusuri jejak perjalanan panjang Desa Mentuda dari masa lampau hingga kini.
                </p>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <main class="space-y-8">
                <article data-aos="fade-up" data-aos-delay="100"
                    class="overflow-hidden rounded-[32px] border border-gray-200 bg-white shadow-lg shadow-gray-200/70">
                    <div
                        class="relative h-[320px] overflow-hidden bg-gradient-to-br from-green-800 via-green-700 to-emerald-600">
                        <img src="{{ asset('img/bg.jpg') }}" alt="Sejarah Desa Mentuda" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>

                        <div class="absolute bottom-6 left-6 right-6 text-white">
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                </svg>
                                Arsip Desa
                            </span>

                            <h2 class="mt-4 text-2xl font-bold sm:text-3xl">
                                Jejak Perjalanan Desa dari Masa ke Masa
                            </h2>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <p class="text-sm leading-7 text-gray-600">
                            Desa Mentuda tumbuh dari komunitas masyarakat pesisir yang memiliki hubungan erat
                            dengan laut, pertanian, dan tradisi gotong royong. Dalam lintasan sejarahnya,
                            desa ini berkembang menjadi ruang hidup yang menghubungkan warisan budaya lama
                            dengan kebutuhan masyarakat modern.
                        </p>
                    </div>
                </article>

                <section class="grid gap-6 md:grid-cols-2">
                    <article data-aos="fade-up" data-aos-delay="150"
                        class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-lg hover:shadow-green-100/60">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 11l9-7 9 7M5 10v10h14V10M9 20v-6h6v6" />
                            </svg>
                        </div>

                        <span class="mt-5 inline-block text-xs font-semibold uppercase tracking-[0.24em] text-green-700">
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

                    <article data-aos="fade-up" data-aos-delay="250"
                        class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-lg hover:shadow-green-100/60">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6" />
                            </svg>
                        </div>

                        <span class="mt-5 inline-block text-xs font-semibold uppercase tracking-[0.24em] text-green-700">
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

                <section data-aos="fade-up" data-aos-delay="150"
                    class="rounded-[32px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 sm:p-8">
                    <div class="max-w-3xl">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">
                            Linimasa
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-gray-900">
                            Tonggak Sejarah Desa
                        </h3>
                    </div>

                    <div class="mt-8 space-y-6">
                        @foreach ([
            [
                'label' => 'Periode Awal',
                'title' => 'Pembentukan Komunitas Permukiman',
                'desc' => 'Masyarakat mulai membentuk kawasan hunian tetap dan mengembangkan pola hidup berbasis kebersamaan.',
                'icon' => 'home',
            ],
            [
                'label' => 'Periode Penguatan',
                'title' => 'Pengembangan Wilayah dan Kelembagaan',
                'desc' => 'Infrastruktur dasar dan tata kelola desa berkembang untuk menjawab kebutuhan warga yang semakin beragam.',
                'icon' => 'building',
            ],
            [
                'label' => 'Periode Modern',
                'title' => 'Transformasi Pelayanan dan Informasi Publik',
                'desc' => 'Desa mulai beradaptasi dengan kebutuhan digital, transparansi informasi, dan peningkatan kualitas layanan publik.',
                'icon' => 'spark',
            ],
        ] as $index => $item)
                            <div class="group flex gap-4" data-aos="fade-up" data-aos-delay="{{ 200 + $index * 100 }}">
                                <div class="flex flex-col items-center">
                                    <span
                                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-700 text-white shadow-lg shadow-green-700/25 transition duration-300 group-hover:bg-emerald-600">
                                        @if ($item['icon'] === 'home')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 11l9-7 9 7M5 10v10h14V10M9 20v-6h6v6" />
                                            </svg>
                                        @elseif ($item['icon'] === 'building')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 21V5a2 2 0 012-2h8a2 2 0 012 2v16M9 7h2M9 11h2M9 15h2M18 21v-8h2v8" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 3l1.8 5.4L19 10l-5.2 1.6L12 17l-1.8-5.4L5 10l5.2-1.6L12 3z" />
                                            </svg>
                                        @endif
                                    </span>

                                    @if (!$loop->last)
                                        <span class="mt-3 h-full w-px bg-green-100"></span>
                                    @endif
                                </div>

                                <div
                                    class="flex-1 rounded-[24px] border border-gray-100 bg-gray-50/60 p-5 transition duration-300 group-hover:border-green-200 group-hover:bg-white group-hover:shadow-md group-hover:shadow-green-100/60">
                                    <p class="text-sm font-semibold text-green-700">
                                        {{ $item['label'] }}
                                    </p>

                                    <h4 class="mt-1 text-lg font-bold text-gray-900">
                                        {{ $item['title'] }}
                                    </h4>

                                    <p class="mt-2 text-sm leading-7 text-gray-600">
                                        {{ $item['desc'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div data-aos="fade-left" data-aos-delay="200"
                    class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60">
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

                <div data-aos="fade-left" data-aos-delay="300"
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
