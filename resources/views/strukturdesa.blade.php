@extends('layouts.app2')

@section('title', 'Struktur Organisasi')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb (selaras) --}}
        <nav class="mb-6 mt-6 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="#" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Profil Desa</li>
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
            <article class="lg:col-span-2 space-y-8">

                {{-- Kepala Desa --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="p-6 md:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                                    <x-heroicon-o-user class="size-6 text-green-700" />
                                </span>
                                <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Kepala Desa</h2>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-green-600 px-3 py-1 text-xs font-medium text-white">
                                Pimpinan
                            </span>
                        </div>

                        <div class="flex justify-center">
                            <div class="text-center">
                                <div class="mx-auto mb-4 h-28 w-28 overflow-hidden rounded-full ring-1 ring-black/5">
                                    <img src="{{ asset('img/user/user1.jpg') }}" alt="Kepala Desa"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <h3 class="text-lg font-semibold text-green-700">Kepala Desa</h3>
                                <p class="text-gray-600">Nama Kepala Desa</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sekretaris & Bendahara --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="p-6 md:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                                    <x-heroicon-o-briefcase class="size-6 text-green-700" />
                                </span>
                                <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Sekretariat & Keuangan</h2>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-emerald-400 px-3 py-1 text-xs font-medium text-white">
                                Struktural
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                                <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                                    <img src="{{ asset('images/sekretaris.jpg') }}" alt="Sekretaris Desa"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <h3 class="text-base font-semibold text-green-700">Sekretaris Desa</h3>
                                <p class="text-gray-600">Nama Sekretaris</p>
                            </div>

                            <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                                <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                                    <img src="{{ asset('images/bendahara.jpg') }}" alt="Bendahara Desa"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <h3 class="text-base font-semibold text-green-700">Bendahara Desa</h3>
                                <p class="text-gray-600">Nama Bendahara</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kepala Urusan --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="p-6 md:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                                    <x-heroicon-o-clipboard-document-list class="size-6 text-green-700" />
                                </span>
                                <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Kepala Urusan</h2>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-emerald-400 px-3 py-1 text-xs font-medium text-white">
                                Struktural
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                                <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                                    <img src="{{ asset('images/kaur-umum.jpg') }}" alt="Kaur Umum"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <h3 class="text-base font-semibold text-green-700">Kaur Umum</h3>
                                <p class="text-gray-600">Nama Kaur Umum</p>
                            </div>

                            <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                                <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                                    <img src="{{ asset('images/kaur-keuangan.jpg') }}" alt="Kaur Keuangan"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <h3 class="text-base font-semibold text-green-700">Kaur Keuangan</h3>
                                <p class="text-gray-600">Nama Kaur Keuangan</p>
                            </div>

                            <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                                <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                                    <img src="{{ asset('images/kaur-pembangunan.jpg') }}" alt="Kaur Pembangunan"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <h3 class="text-base font-semibold text-green-700">Kaur Pembangunan</h3>
                                <p class="text-gray-600">Nama Kaur Pembangunan</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ketua RT & RW --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="p-6 md:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                                    <x-heroicon-o-home-modern class="size-6 text-green-700" />
                                </span>
                                <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Ketua RT &amp; RW</h2>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-lime-400 px-3 py-1 text-xs font-medium text-white">
                                Kewilayahan
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                                <div class="mx-auto mb-3 h-16 w-16 overflow-hidden rounded-full ring-1 ring-black/5">
                                    <img src="{{ asset('images/rw01.jpg') }}" alt="RW 01"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <h3 class="text-sm font-semibold text-green-700">Ketua RW 01</h3>
                                <p class="text-gray-600">Nama RW 01</p>
                            </div>

                            <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                                <div class="mx-auto mb-3 h-16 w-16 overflow-hidden rounded-full ring-1 ring-black/5">
                                    <img src="{{ asset('images/rw02.jpg') }}" alt="RW 02"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <h3 class="text-sm font-semibold text-green-700">Ketua RW 02</h3>
                                <p class="text-gray-600">Nama RW 02</p>
                            </div>

                            <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                                <div class="mx-auto mb-3 h-16 w-16 overflow-hidden rounded-full ring-1 ring-black/5">
                                    <img src="{{ asset('images/rt01.jpg') }}" alt="RT 01"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <h3 class="text-sm font-semibold text-green-700">Ketua RT 01</h3>
                                <p class="text-gray-600">Nama RT 01</p>
                            </div>

                            <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                                <div class="mx-auto mb-3 h-16 w-16 overflow-hidden rounded-full ring-1 ring-black/5">
                                    <img src="{{ asset('images/rt02.jpg') }}" alt="RT 02"
                                        class="h-full w-full object-cover" loading="lazy" decoding="async">
                                </div>
                                <h3 class="text-sm font-semibold text-green-700">Ketua RT 02</h3>
                                <p class="text-gray-600">Nama RT 02</p>
                            </div>
                        </div>
                    </div>
                </div>

            </article>

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
                            <span class="h-2 w-2 rounded-full bg-lime-400"></span> Kewilayahan (RT/RW)
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Tautan Terkait</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-user-group class="size-4" /> Struktur Organisasi</a></li>
                        <li><a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-newspaper class="size-4" /> Berita Desa</a></li>
                        <li><a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-map class="size-4" /> Profil Wilayah</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </section>
@endsection
