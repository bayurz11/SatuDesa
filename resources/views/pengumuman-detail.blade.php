@extends('layouts.app2')

@section('title', ($item->title ?? 'Pengumuman') . ' — Pengumuman Desa')

@section('content')
    @php
        use Illuminate\Support\Carbon;

        $start = $item->start_at ?? $item->published_at;
        $start = $start ? Carbon::parse($start) : now();

        $end = $item->end_at ? Carbon::parse($item->end_at) : null;

        $badgeHari = $start->translatedFormat('l');
        $badgeTgl = $start->format('d');
        $badgeBlnTh = $start->translatedFormat('M Y');
        $jamRange = $end ? $start->format('H:i') . '–' . $end->format('H:i') : $start->format('H:i');

        $cover =
            !empty($item->cover_path) && file_exists(public_path($item->cover_path))
                ? asset($item->cover_path)
                : asset('public/img/potensi2.jpg');

        // Ambil tags (jika ada relasi tags di model Post)
        $tags = $item->tags?->pluck('name') ?? collect();
    @endphp


    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="#" class="hover:text-green-700">Informasi</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="{{ route('pengumuman') }}" class="hover:text-green-700">Pengumuman</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium line-clamp-1">{{ $item->title }}</li>
            </ol>
        </nav>

        {{-- HERO --}}
        <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
            <div class="grid md:grid-cols-12 gap-0">
                <figure class="md:col-span-7 h-56 md:h-80 overflow-hidden rounded-lg">
                    <img src="{{ asset($item->cover_path) }}" alt="{{ $item->title }}" class="h-full w-full object-cover"
                        loading="lazy" decoding="async" onerror="this.src='{{ asset('public/img/bg-desa.jpg') }}';">
                </figure>


                <div class="md:col-span-5 p-6 md:p-8 flex flex-col justify-center">
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                            <x-heroicon-o-bell class="size-4" />
                            {{ $item->category?->name ?? 'Pengumuman' }}
                        </span>
                        @foreach ($tags as $t)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700 ring-1 ring-emerald-200">
                                #{{ $t }}
                            </span>
                        @endforeach
                    </div>

                    <h1 class="mt-3 text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">
                        {{ $item->title }}
                    </h1>

                    <p class="mt-2 text-sm text-gray-600">{{ $item->summary }}</p>

                    <div class="mt-4 grid grid-cols-[auto,1fr] gap-x-3 gap-y-2 text-sm text-gray-700">
                        <span class="inline-flex items-center gap-2 text-gray-600">
                            <x-heroicon-o-calendar class="size-5 text-green-700" /> Tanggal
                        </span>
                        <span>{{ $start->translatedFormat('d F Y') }}
                            @if ($end)
                                ({{ $jamRange }} WIB)
                            @else
                                • {{ $jamRange }}
                            @endif
                        </span>

                        <span class="inline-flex items-center gap-2 text-gray-600">
                            <x-heroicon-o-map-pin class="size-5 text-green-700" /> Lokasi
                        </span>
                        <span>{{ $item->location ?: '—' }}</span>

                        <span class="inline-flex items-center gap-2 text-gray-600">
                            <x-heroicon-o-user class="size-5 text-green-700" /> Penanggung Jawab
                        </span>
                        <span>{{ $item->organizer ?: '—' }}</span>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="#detail"
                            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                            <x-heroicon-o-eye class="size-5" /> Baca Detail
                        </a>
                        <a href="{{ route('pengumuman') }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                            <x-heroicon-o-arrow-left class="size-5" /> Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Badge tanggal di pojok --}}
            <div class="absolute left-4 top-4">
                <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-2 text-center shadow-sm">
                    <p class="text-xs font-medium text-green-700">{{ $badgeHari }}</p>
                    <p class="text-lg font-extrabold text-green-700 leading-none">{{ $badgeTgl }}</p>
                    <p class="text-xs font-medium text-green-700">{{ $badgeBlnTh }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-3 items-start mt-8">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-8">
                {{-- Isi Detail --}}
                <section id="detail" class="rounded-2xl bg-white shadow ring-1 ring-black/5 p-6 md:p-8">
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Detail Pengumuman</h2>
                    <div class="mx-auto my-4 h-1 w-20 rounded-full bg-green-600"></div>

                    <div class="prose max-w-none">
                        {!! $item->body_html !!}
                    </div>
                </section>

                {{-- CTA --}}
                <section class="rounded-2xl border border-green-200 bg-green-50/60 p-5 md:p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900">Aksi</h3>
                            <p class="text-sm text-gray-700">Sebarkan informasi ini agar lebih banyak warga yang hadir.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="#"
                                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                <x-heroicon-o-share class="size-4" /> Bagikan
                            </a>
                            <a href="#"
                                class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                <x-heroicon-o-printer class="size-4" /> Cetak
                            </a>
                        </div>
                    </div>
                </section>
            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-3">Ringkasan Cepat</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-calendar class="h-4 w-4 text-green-700" />
                            {{ $start->translatedFormat('d F Y') }}
                            {{ $end ? '• ' . $jamRange . ' WIB' : '• ' . $jamRange }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-map-pin class="h-4 w-4 text-green-700" />
                            {{ $item->location ?: '—' }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-user class="h-4 w-4 text-green-700" />
                            {{ $item->organizer ?: '—' }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-clock class="h-4 w-4 text-green-700" />
                            Diposting {{ $item->created_at?->diffForHumans() }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-pencil-square class="h-4 w-4 text-green-700" />
                            Diperbarui {{ $item->updated_at?->diffForHumans() }}
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-3">Tautan Terkait</h3>
                    <ul class="space-y-2 text-sm">
                        <li>
                            <a href="{{ route('pengumuman') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-list-bullet class="size-4" /> Semua Pengumuman
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </section>
@endsection
