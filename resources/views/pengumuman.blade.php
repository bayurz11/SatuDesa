@extends('layouts.app2')

@section('title', 'Pengumuman Desa ')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb (selaras) --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="#" class="hover:text-green-700">Informasi</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Pengumuman</li>
            </ol>
        </nav>

        {{-- Heading (selaras) --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Pengumuman Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Informasi dan pengumuman terbaru untuk masyarakat Desa Mentuda.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KOLOM UTAMA --}}
            <article class="lg:col-span-2 space-y-4">

                {{-- Card Pengumuman (statik) --}}
                @for ($i = 0; $i < 3; $i++)
                    <div
                        class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5 transition hover:shadow-md">
                        <div class="p-5 md:p-6 flex flex-col sm:flex-row sm:items-start gap-4">
                            {{-- Tanggal badge --}}
                            <div class="shrink-0">
                                <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-2 text-center">
                                    <p class="text-xs font-medium text-green-700">Sabtu</p>
                                    <p class="text-lg font-extrabold text-green-700 leading-none">20</p>
                                    <p class="text-xs font-medium text-green-700">Sep 2025</p>
                                </div>
                            </div>

                            {{-- Isi --}}
                            <div class="flex-1 min-w-0">
                                <div class="mb-1 flex flex-wrap items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                        <x-heroicon-o-bell class="size-4" /> Pengumuman
                                    </span>
                                    <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                                        <x-heroicon-o-clock class="size-4" /> 20 September 2025 • 08:00
                                    </time>
                                </div>

                                <h2 class="text-base md:text-lg font-semibold text-gray-900 leading-snug">
                                    Gotong Royong Bersama
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    Diharapkan seluruh warga ikut serta dalam kegiatan gotong royong membersihkan lingkungan
                                    desa pada hari Minggu.
                                </p>

                                {{-- Meta lokasi/penanggung jawab (opsional) --}}
                                <div class="mt-3 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                    <span class="inline-flex items-center gap-1"><x-heroicon-o-map-pin class="size-4" />
                                        Balai Desa</span>
                                    <span class="inline-flex items-center gap-1"><x-heroicon-o-user class="size-4" /> Kasi
                                        Pemerintahan</span>
                                </div>
                            </div>

                            {{-- CTA --}}
                            <div class="sm:self-center">
                                <a href="#"
                                    class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                    <x-heroicon-o-eye class="size-4" /> Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @endfor

                {{-- Pagination (placeholder) --}}
                <nav class="pt-2 flex justify-center" aria-label="Pagination">
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
            </article>

            {{-- SIDEBAR (opsional, selaras gaya) --}}
            <aside class="space-y-6 lg:sticky lg:top-20">

                {{-- Pencarian --}}
                <form action="#" method="GET" class="bg-white rounded-xl shadow p-4">
                    <label for="q" class="sr-only">Cari Pengumuman</label>
                    <div class="relative">
                        <input id="q" name="q" type="search" placeholder="Cari pengumuman…"
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

                {{-- Kategori / Filter cepat --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Filter</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border bg-green-600 border-green-600 text-white">Semua</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Umum</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Kesehatan</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Pendidikan</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Agenda</a>
                    </div>
                </div>

                {{-- Agenda terdekat (statik) --}}
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Agenda Terdekat</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3">
                            <x-heroicon-o-calendar class="mt-0.5 size-5 text-green-700" />
                            <div>
                                <p class="font-medium text-gray-900">Musyawarah Desa</p>
                                <p class="text-gray-500">25 September 2025 — Balai Desa</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <x-heroicon-o-megaphone class="mt-0.5 size-5 text-green-700" />
                            <div>
                                <p class="font-medium text-gray-900">Sosialisasi Kesehatan</p>
                                <p class="text-gray-500">27 September 2025 — Posyandu</p>
                            </div>
                        </li>
                    </ul>
                </div>

            </aside>
        </div>
    </section>
@endsection
