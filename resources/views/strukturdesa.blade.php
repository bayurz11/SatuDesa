@extends('layouts.app2')

@section('title', 'Struktur Organisasi')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb (selaras) --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="#" class="hover:text-green-700">Profil Desa</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Struktur</li>
            </ol>
        </nav>

        {{-- Heading (selaras) --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Struktur Pemerintahan Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Susunan perangkat desa dalam menjalankan roda pemerintahan Desa Mentuda.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KOLOM UTAMA --}}
            <livewire:struktur.struktur-show />

            {{-- SIDEBAR (opsional, konsisten gaya) --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Legenda</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-green-600"></span> Pimpinan
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span> Struktural
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-lime-400"></span> Kewilayahan (Kepala Dusun)
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Tautan Terkait</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('sejarah') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-book-open class="size-4" /> Sejarah</a></li>
                        <li><a href="{{ route('berita') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-newspaper class="size-4" /> Berita Desa</a></li>
                        <li><a href="{{ route('potensi-desa') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-map class="size-4" /> Potensi Desa</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </section>
@endsection
