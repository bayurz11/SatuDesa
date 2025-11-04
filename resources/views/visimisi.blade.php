@extends('layouts.app2')

@section('title', 'Visi & Misi')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb (selaras) --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Profil Desa</li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Visi &amp; Misi</li>
            </ol>
        </nav>

        {{-- Heading (selaras) --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Visi &amp; Misi Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Komitmen Desa Mentuda untuk membangun masyarakat yang sejahtera, maju, dan berbudaya.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-8">
                <livewire:visi-misi.visi-misi-show />
            </article>

            {{-- SIDEBAR (opsional, konsisten gaya) --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
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

                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Kontak</h3>
                    <div class="text-sm text-gray-700 space-y-1">
                        <p>Jl. Raya Desa Mentuda, Kab. Lingga</p>
                        <p>Email: info@desamentuda.id</p>
                        <p>Telp: +62 812 3456 7890</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
