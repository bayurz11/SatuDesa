@php
    $metaTitle = $profile->vision_mission_title ?: 'Visi & Misi Desa';
    $metaDescription = $profile->vision_mission_description ?: 'Halaman visi dan misi desa.';
    $missionItems = collect($profile->vision_mission_mission_items ?? [])->values();
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative mt-16 overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-down">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Profil Desa</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Visi &amp; Misi</li>
                </ol>
            </nav>

            <div class="mt-8 max-w-4xl" data-aos="fade-up" data-aos-delay="100">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100 ring-1 ring-white/15">
                    {{ $profile->vision_mission_hero_badge }}
                </span>

                <h1 class="mt-6 text-2xl font-bold tracking-tight sm:text-3xl">
                    {{ $profile->vision_mission_title }}
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                    {{ $profile->vision_mission_description }}
                </p>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <main class="space-y-8">
                <article data-aos="fade-up" data-aos-delay="100"
                    class="relative overflow-hidden rounded-[32px] border border-gray-200 bg-white p-8 shadow-lg shadow-gray-200/70">
                    <div class="absolute -right-16 -top-16 h-44 w-44 rounded-full bg-green-50"></div>

                    <div class="relative">
                        <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M12 3l7 4v5c0 5-3 8-7 9-4-1-7-4-7-9V7l7-4z" />
                            </svg>
                        </div>

                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">
                            {{ $profile->vision_mission_vision_badge }}
                        </span>

                        <h2 class="mt-3 text-2xl font-bold tracking-tight text-gray-900">
                            {{ $profile->vision ?: 'Visi Desa Sedang Disiapkan' }}
                        </h2>

                        <p class="mt-5 text-sm leading-8 text-gray-600 sm:text-base">
                            {{ $profile->vision_mission_vision_description ?: 'Pernyataan visi desa belum ditambahkan. Halaman ini akan diperbarui setelah konten visi resmi tersedia.' }}
                        </p>
                    </div>
                </article>

                <section data-aos="fade-up" data-aos-delay="150"
                    class="rounded-[32px] border border-gray-200 bg-white p-8 shadow-md shadow-gray-200/60">
                    <div class="max-w-3xl">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">
                            {{ $profile->vision_mission_mission_badge }}
                        </span>

                        <h2 class="mt-3 text-2xl font-bold text-gray-900">
                            {{ $profile->vision_mission_mission_title }}
                        </h2>
                    </div>

                    <div class="mt-6 grid gap-5">
                        @forelse ($missionItems as $index => $mission)
                            <div data-aos="fade-up" data-aos-delay="{{ 200 + $index * 100 }}"
                                class="group flex gap-4 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm shadow-gray-200/50 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:bg-green-50/50 hover:shadow-lg hover:shadow-green-100/60">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100 transition duration-300 group-hover:bg-green-700 group-hover:text-white">
                                    @if (($mission['icon'] ?? 'service') === 'service')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                        </svg>
                                    @elseif (($mission['icon'] ?? 'service') === 'chart')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M8 16v-5M12 16V8M16 16v-8" />
                                        </svg>
                                    @elseif (($mission['icon'] ?? 'service') === 'users')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11a4 4 0 100-8 4 4 0 000 8zM4 21a8 8 0 0116 0M17 11a3 3 0 100-6" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h8M8 10h8M8 14h5M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                        </svg>
                                    @endif
                                </div>

                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">
                                        Misi {{ $index + 1 }}
                                    </p>

                                    <h3 class="mt-1 text-lg font-bold text-gray-900">
                                        {{ $mission['title'] ?? '-' }}
                                    </h3>

                                    <p class="mt-2 text-sm leading-7 text-gray-600">
                                        {{ $mission['desc'] ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-green-200 bg-gradient-to-br from-green-50 to-white p-6 text-center">
                                <p class="text-sm font-semibold text-gray-900">Daftar Misi Belum Ditambahkan</p>
                                <p class="mt-2 text-sm leading-7 text-gray-600">
                                    Misi strategis desa masih dalam tahap penyusunan. Setelah admin menambahkan daftar misi, bagian ini akan tampil otomatis.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div data-aos="fade-left" data-aos-delay="200"
                    class="overflow-hidden rounded-[28px] border border-gray-200 bg-white p-5 shadow-md shadow-gray-200/60">

                    <div class="mb-5 flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">Navigasi</p>
                            <h2 class="text-lg font-bold text-gray-900">Bagian Profil</h2>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('public.history') }}"
                            class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60">
                            <span class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-50 text-green-700 ring-1 ring-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                    </svg>
                                </span>
                                Sejarah Desa
                            </span>
                            <span class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-700">&rarr;</span>
                        </a>

                        <a href="{{ route('public.vision-mission') }}"
                            class="group relative flex items-center justify-between overflow-hidden rounded-2xl bg-green-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-green-700/20 transition duration-300 hover:-translate-y-0.5 hover:bg-green-800 hover:shadow-xl hover:shadow-green-700/30">
                            <span class="absolute inset-y-0 left-0 w-1 bg-white/70"></span>
                            <span class="relative flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M12 3l7 4v5c0 5-3 8-7 9-4-1-7-4-7-9V7l7-4z" />
                                    </svg>
                                </span>
                                Visi &amp; Misi
                            </span>
                            <span class="relative transition duration-300 group-hover:translate-x-1">&rarr;</span>
                        </a>

                        <a href="{{ route('public.organization-structure') }}"
                            class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60">
                            <span class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-50 text-green-700 ring-1 ring-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6a3 3 0 110 6 3 3 0 010-6zM5 21a7 7 0 0114 0M4 8a2 2 0 114 0M16 8a2 2 0 114 0" />
                                    </svg>
                                </span>
                                Struktur Organisasi
                            </span>
                            <span class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-700">&rarr;</span>
                        </a>

                        <a href="{{ route('public.village-map') }}"
                            class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60">
                            <span class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-50 text-green-700 ring-1 ring-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l-6 3V6l6-3 6 3 6-3v15l-6 3-6-3zM9 3v15M15 6v15" />
                                    </svg>
                                </span>
                                Peta Desa
                            </span>
                            <span class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-700">&rarr;</span>
                        </a>
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="300"
                    class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-12 -left-12 h-36 w-36 rounded-full bg-black/10"></div>

                    <div class="relative">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M12 3l7 4v5c0 5-3 8-7 9-4-1-7-4-7-9V7l7-4z" />
                            </svg>
                        </div>

                        <h2 class="text-lg font-bold">{{ $profile->vision_mission_sidebar_title ?: 'Arah Pembangunan Desa' }}</h2>

                        <p class="mt-3 text-sm leading-6 text-white/85">
                            {{ $profile->vision_mission_sidebar_description ?: 'Catatan pendukung mengenai visi, misi, dan arah pembangunan desa akan ditampilkan di panel ini setelah kontennya dilengkapi.' }}
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
