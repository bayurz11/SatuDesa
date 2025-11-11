@extends('layouts.app2')

@section('title', 'Potensi Desa')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="#" class="hover:text-green-700">Informasi</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Potensi Desa</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Potensi Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Gambaran potensi ekonomi, pariwisata, pertanian, perikanan, industri kreatif, hingga lingkungan.
            </p>
        </header>

        {{-- Hero Highlight: 1 potensi terbaru --}}
        @php
            /** @var \App\Domains\Post\Models\Post|null $highlight */
            $highlight = \App\Domains\Post\Models\Post::query()
                ->where('content_type', 'potensi')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->first();
        @endphp

        @if ($highlight)
            <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5 mb-8">
                <div class="grid md:grid-cols-12 gap-0">
                    <figure class="md:col-span-7 h-56 md:h-72 overflow-hidden">
                        <img src="{{ $highlight->cover_url }}" alt="{{ $highlight->title }}"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </figure>
                    <div class="md:col-span-5 p-6 md:p-8 flex flex-col justify-center">
                        <span
                            class="inline-flex items-center gap-1 w-fit rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                            <x-heroicon-o-sparkles class="size-4" /> Sorotan
                        </span>
                        <h2 class="mt-3 text-xl md:text-2xl font-semibold text-gray-900">
                            {{ $highlight->title }}
                        </h2>
                        <p class="mt-2 text-gray-700 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($highlight->summary ?: $highlight->body_html), 220) }}
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('potensi-desa-detail', $highlight->slug ?? $highlight->id) }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                <x-heroicon-o-eye class="size-4" /> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Grid Potensi (dinamis dari Livewire) --}}
        <livewire:content.content-hub mode="potensi" />
    </section>
@endsection
