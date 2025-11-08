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

                @livewire('content.content-hub', ['mode' => 'announcement'])
            </article>

            {{-- SIDEBAR (opsional, selaras gaya contoh) --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                {{-- Pencarian (placeholder) --}}
                <form action="#" method="GET" class="bg-white rounded-xl shadow p-4">
                    <label for="q" class="sr-only">Cari Pengumuman</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model.live="q" type="text" placeholder="Cari judul / ringkasan…"
                            class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                    </div>
                </form>

                {{-- Filter cepat (placeholder) --}}
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

                {{-- Agenda terdekat (statik contoh) --}}
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
