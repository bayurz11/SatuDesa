@extends('layouts.app2')

@section('title', 'Sejarah Desa')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb (selaras dengan Berita) --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Profil Desa</li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Sejarah Desa</li>
            </ol>
        </nav>

        {{-- Heading (selaras) --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Sejarah Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Menyusuri jejak perjalanan panjang Desa Mentuda dari masa lampau hingga kini.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">

            {{-- KONTEN UTAMA --}}
            <livewire:sejarah.sejarah-show />

            {{-- SIDEBAR (selaras gaya Berita, opsional konten statik) --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Fakta Singkat</h3>
                    <dl class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <dt class="text-gray-500">Lokasi</dt>
                            <dd class="font-medium text-gray-800">Kab. Lingga</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Julukan</dt>
                            <dd class="font-medium text-gray-800">“Tempat yang Subur”</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Mata Pencaharian</dt>
                            <dd class="font-medium text-gray-800">Pertanian & Perikanan</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Karakter</dt>
                            <dd class="font-medium text-gray-800">Ramah & Gotong Royong</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Tautan Terkait</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('struktur-desa') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-user-group class="size-4" /> Struktur Organisasi</a></li>
                        <li><a href="{{ route('pengumuman') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-calendar class="size-4" /> Agenda Desa</a></li>
                        <li><a href="{{ route('berita') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-newspaper class="size-4" /> Berita Desa</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </section>
@endsection
