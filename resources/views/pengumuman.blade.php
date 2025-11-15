@extends('layouts.app2')

@section('title', 'Pengumuman Desa ')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb (selaras) --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
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


            <livewire:content.content-hub mode="announcement" :show-pagination="true" />



            {{-- SIDEBAR (opsional, selaras gaya contoh) --}}

        </div>


    </section>
@endsection
