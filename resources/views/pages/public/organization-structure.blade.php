@php
    $metaTitle = 'Struktur Organisasi Desa';
    $metaDescription = 'Halaman struktur organisasi Desa Mentuda versi statis untuk kebutuhan desain.';
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative mt-16 overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-down">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Profil Desa</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Struktur Organisasi</li>
                </ol>
            </nav>

            <div class="mt-8 max-w-4xl" data-aos="fade-up" data-aos-delay="100">
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100 ring-1 ring-white/15">
                    Profil Desa
                </span>

                <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl">
                    Struktur Organisasi Desa Mentuda
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                    Susunan pemerintahan desa yang menggambarkan pembagian tugas, fungsi pelayanan,
                    dan tata kelola administrasi Desa Mentuda.
                </p>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <main class="space-y-8">
                <section data-aos="fade-up" data-aos-delay="100"
                    class="overflow-hidden rounded-[32px] border border-gray-200 bg-white p-5 shadow-lg shadow-gray-200/70 sm:p-7">

                    <div class="text-center">
                        <span
                            class="inline-flex items-center rounded-full bg-green-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-green-700 ring-1 ring-green-100">
                            Bagan Organisasi
                        </span>

                        <h2 class="mt-4 text-2xl font-bold text-gray-900 sm:text-3xl">
                            Struktur Organisasi Desa Mentuda
                        </h2>

                        <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                            Susunan pemerintahan desa yang menggambarkan pembagian tugas, fungsi pelayanan,
                            dan tata kelola administrasi Desa Mentuda.
                        </p>
                    </div>

                    @php
                        $photoPlaceholder = asset('img/avatar-placeholder.png');

                        $kaurItems = [
                            [
                                'label' => 'Kaur',
                                'title' => 'Kaur Tata Usaha & Umum',
                                'name' => 'Nama Kaur',
                                'photo' => $photoPlaceholder,
                            ],
                            [
                                'label' => 'Kaur',
                                'title' => 'Kaur Keuangan',
                                'name' => 'Nama Kaur',
                                'photo' => $photoPlaceholder,
                            ],
                            [
                                'label' => 'Kaur',
                                'title' => 'Kaur Perencanaan',
                                'name' => 'Nama Kaur',
                                'photo' => $photoPlaceholder,
                            ],
                        ];

                        $kasiItems = [
                            [
                                'label' => 'Kasi',
                                'title' => 'Kasi Pemerintahan',
                                'name' => 'Nama Kasi',
                                'photo' => $photoPlaceholder,
                            ],
                            [
                                'label' => 'Kasi',
                                'title' => 'Kasi Kesejahteraan',
                                'name' => 'Nama Kasi',
                                'photo' => $photoPlaceholder,
                            ],
                            [
                                'label' => 'Kasi',
                                'title' => 'Kasi Pelayanan',
                                'name' => 'Nama Kasi',
                                'photo' => $photoPlaceholder,
                            ],
                        ];

                        $dusunItems = [
                            [
                                'label' => 'Kadus',
                                'title' => 'Kepala Dusun I',
                                'name' => 'Nama Kadus',
                                'photo' => $photoPlaceholder,
                            ],
                            [
                                'label' => 'Kadus',
                                'title' => 'Kepala Dusun II',
                                'name' => 'Nama Kadus',
                                'photo' => $photoPlaceholder,
                            ],
                            [
                                'label' => 'Kadus',
                                'title' => 'Kepala Dusun III',
                                'name' => 'Nama Kadus',
                                'photo' => $photoPlaceholder,
                            ],
                        ];
                    @endphp

                    <div class="mt-10">
                        <div class="grid items-center gap-4 lg:grid-cols-[1fr_auto_1fr]">
                            <div></div>

                            <div data-aos="zoom-in" data-aos-delay="200"
                                class="mx-auto flex w-full max-w-sm items-center gap-4 rounded-[24px] border-t-4 border-green-700 bg-white p-4 shadow-lg shadow-gray-200/70 ring-1 ring-gray-100">
                                <img src="{{ asset('img/avatar-placeholder.png') }}" alt="Kepala Desa"
                                    class="h-14 w-14 rounded-full border-4 border-green-50 object-cover">

                                <div class="min-w-0 text-left">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-green-700">
                                        Kepala Desa
                                    </p>
                                    <h3 class="mt-1 truncate text-base font-bold text-gray-900">
                                        Nama Kepala Desa
                                    </h3>
                                    <p class="mt-1 text-xs text-gray-500">Pimpinan Pemerintahan Desa</p>
                                </div>
                            </div>

                            <div data-aos="fade-left" data-aos-delay="250"
                                class="mx-auto flex w-full max-w-xs items-center gap-3 rounded-[20px] border border-green-100 bg-green-50 p-4 shadow-sm">
                                <img src="{{ asset('img/avatar-placeholder.png') }}" alt="BPD"
                                    class="h-12 w-12 rounded-full border-4 border-white object-cover">

                                <div class="min-w-0">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-green-700">
                                        Mitra Desa
                                    </p>
                                    <h4 class="mt-1 truncate text-sm font-bold text-gray-900">BPD</h4>
                                    <p class="mt-1 text-xs text-gray-500">Badan Permusyawaratan Desa</p>
                                </div>
                            </div>
                        </div>

                        <div class="mx-auto my-5 h-8 w-px bg-green-200"></div>

                        <div data-aos="fade-up" data-aos-delay="300"
                            class="mx-auto flex w-full max-w-sm items-center gap-4 rounded-[22px] border border-gray-200 bg-white p-4 shadow-md shadow-gray-200/60">
                            <img src="{{ asset('img/avatar-placeholder.png') }}" alt="Sekretaris Desa"
                                class="h-13 w-13 rounded-full border-4 border-green-50 object-cover">

                            <div class="min-w-0">
                                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-green-700">
                                    Sekretariat Desa
                                </p>
                                <h4 class="mt-1 truncate text-base font-bold text-gray-900">
                                    Nama Sekretaris Desa
                                </h4>
                                <p class="mt-1 text-xs text-gray-500">Sekretaris Desa</p>
                            </div>
                        </div>

                        <div class="mx-auto my-5 h-8 w-px bg-green-200"></div>

                        <div class="grid gap-4 md:grid-cols-3">
                            @foreach ($kaurItems as $index => $item)
                                <div data-aos="fade-up" data-aos-delay="{{ 350 + $index * 80 }}"
                                    class="group flex items-center gap-3 rounded-[22px] border border-gray-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-lg hover:shadow-green-100/60">
                                    <img src="{{ $item['photo'] }}" alt="{{ $item['title'] }}"
                                        class="h-12 w-12 shrink-0 rounded-full border-4 border-green-50 object-cover">

                                    <div class="min-w-0">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-green-700">
                                            {{ $item['label'] }}
                                        </p>
                                        <h4 class="mt-1 text-sm font-bold leading-snug text-gray-900">
                                            {{ $item['title'] }}
                                        </h4>
                                        <p class="mt-1 text-xs text-gray-500">{{ $item['name'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mx-auto my-6 h-px max-w-3xl bg-green-100"></div>

                        <div class="grid gap-4 md:grid-cols-3">
                            @foreach ($kasiItems as $index => $item)
                                <div data-aos="fade-up" data-aos-delay="{{ 450 + $index * 80 }}"
                                    class="group flex items-center gap-3 rounded-[22px] border border-gray-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-lg hover:shadow-green-100/60">
                                    <img src="{{ $item['photo'] }}" alt="{{ $item['title'] }}"
                                        class="h-12 w-12 shrink-0 rounded-full border-4 border-green-50 object-cover">

                                    <div class="min-w-0">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-green-700">
                                            {{ $item['label'] }}
                                        </p>
                                        <h4 class="mt-1 text-sm font-bold leading-snug text-gray-900">
                                            {{ $item['title'] }}
                                        </h4>
                                        <p class="mt-1 text-xs text-gray-500">{{ $item['name'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mx-auto my-6 h-px max-w-3xl bg-green-100"></div>

                        <div class="grid gap-4 md:grid-cols-3">
                            @foreach ($dusunItems as $index => $item)
                                <div data-aos="fade-up" data-aos-delay="{{ 550 + $index * 80 }}"
                                    class="group flex items-center gap-3 rounded-[22px] border border-gray-200 bg-gray-50/70 p-4 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:bg-white hover:shadow-md hover:shadow-green-100/60">
                                    <img src="{{ $item['photo'] }}" alt="{{ $item['title'] }}"
                                        class="h-12 w-12 shrink-0 rounded-full border-4 border-white object-cover">

                                    <div class="min-w-0">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-green-700">
                                            {{ $item['label'] }}
                                        </p>
                                        <h4 class="mt-1 text-sm font-bold leading-snug text-gray-900">
                                            {{ $item['title'] }}
                                        </h4>
                                        <p class="mt-1 text-xs text-gray-500">{{ $item['name'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div
                            class="mt-8 rounded-2xl bg-green-50 px-4 py-3 text-sm leading-6 text-green-800 ring-1 ring-green-100">
                            Struktur organisasi dapat disesuaikan dengan data perangkat desa dan foto masing-masing pejabat.
                        </div>
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div data-aos="fade-left" data-aos-delay="200"
                    class="overflow-hidden rounded-[28px] border border-gray-200 bg-white p-5 shadow-md shadow-gray-200/60">
                    <div class="mb-5 flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">
                                Navigasi
                            </p>
                            <h2 class="text-lg font-bold text-gray-900">Bagian Profil</h2>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('public.history') }}"
                            class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60">
                            <span>Sejarah Desa</span>
                            <span
                                class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-700">&rarr;</span>
                        </a>

                        <a href="{{ route('public.vision-mission') }}"
                            class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60">
                            <span>Visi &amp; Misi</span>
                            <span
                                class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-700">&rarr;</span>
                        </a>

                        <a href="{{ route('public.organization-structure') }}"
                            class="group relative flex items-center justify-between overflow-hidden rounded-2xl bg-green-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-green-700/20 transition duration-300 hover:-translate-y-0.5 hover:bg-green-800 hover:shadow-xl hover:shadow-green-700/30">
                            <span class="absolute inset-y-0 left-0 w-1 bg-white/70"></span>
                            <span class="relative">Struktur Organisasi</span>
                            <span class="relative transition duration-300 group-hover:translate-x-1">&rarr;</span>
                        </a>

                        <a href="{{ route('public.village-map') }}"
                            class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60">
                            <span>Peta Desa</span>
                            <span
                                class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-700">&rarr;</span>
                        </a>
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="300"
                    class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-12 -left-12 h-36 w-36 rounded-full bg-black/10"></div>

                    <div class="relative">
                        <div
                            class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6a3 3 0 110 6 3 3 0 010-6zM5 21a7 7 0 0114 0" />
                            </svg>
                        </div>

                        <h2 class="text-lg font-bold">Tata Kelola Desa</h2>

                        <p class="mt-3 text-sm leading-6 text-white/85">
                            Struktur organisasi membantu masyarakat memahami pembagian tugas,
                            alur koordinasi, dan perangkat desa yang menjalankan pelayanan publik.
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
