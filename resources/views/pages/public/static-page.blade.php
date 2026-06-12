@php
    $metaTitle = $title;
    $metaDescription = $description;
    $eyebrow = $eyebrow ?? 'Halaman Publik';
    $metrics = $metrics ?? [];
    $featurePoints = $feature_points ?? [];
    $cards = $cards ?? [];
    $contentBlocks = $content_blocks ?? [];
    $sidebarItems = $sidebar_items ?? [];
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative mt-16 overflow-hidden bg-[linear-gradient(135deg,_#052e16_0%,_#14532d_45%,_#166534_100%)] text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.18),_transparent_28%)]"></div>
        <div class="absolute -left-20 top-24 h-64 w-64 rounded-full bg-emerald-400/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-72 w-72 rounded-full bg-lime-300/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li class="font-semibold text-white">{{ $title }}</li>
                </ol>
            </nav>

            <div class="public-sidebar-grid public-sidebar-grid--360 mt-8 lg:items-start">
                <div class="max-w-4xl">
                    <div class="flex flex-wrap items-center gap-3">
                        <span
                            class="inline-flex items-center rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-50 ring-1 ring-white/15">
                            {{ $eyebrow }}
                        </span>
                        @if (!empty($hero_badge))
                            <span
                                class="inline-flex items-center rounded-full bg-emerald-300/15 px-4 py-1 text-xs font-semibold text-emerald-50 ring-1 ring-emerald-200/20">
                                {{ $hero_badge }}
                            </span>
                        @endif
                    </div>

                    <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl sm:leading-tight">
                        {{ $title }}
                    </h1>

                    <p class="mt-4 max-w-3xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                        {{ $description }}
                    </p>

                    @if (!empty($metrics))
                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            @foreach ($metrics as $metric)
                                <div class="rounded-[24px] border border-white/10 bg-white/10 p-4 backdrop-blur">
                                    <p class="text-2xl font-bold text-white sm:text-3xl">{{ $metric['value'] }}</p>
                                    <p class="mt-2 text-sm text-emerald-50/80">{{ $metric['label'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="rounded-[32px] border border-white/10 bg-white/10 p-6 backdrop-blur-xl shadow-2xl shadow-green-950/20">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100">Arah Desain</p>
                    <h2 class="mt-3 text-2xl font-bold text-white">{{ $feature_title }}</h2>
                    <p class="mt-3 text-sm leading-7 text-emerald-50/85">
                        {{ $feature_body }}
                    </p>

                    @if (!empty($hero_note))
                        <div class="mt-5 rounded-2xl bg-black/15 px-4 py-3 text-sm text-emerald-50/85 ring-1 ring-white/10">
                            {{ $hero_note }}
                        </div>
                    @endif

                    @if (!empty($featurePoints))
                        <div class="mt-5 grid gap-3">
                            @foreach ($featurePoints as $point)
                                <div class="flex items-start gap-3 rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                                    <span class="mt-1 h-2.5 w-2.5 flex-shrink-0 rounded-full bg-lime-300"></span>
                                    <span class="text-sm text-white/90">{{ $point }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="public-sidebar-grid public-sidebar-grid--320">
            <main class="space-y-8">
                <article class="overflow-hidden rounded-[32px] border border-gray-200 bg-white shadow-xl shadow-gray-200/70">
                    <div class="grid gap-0 lg:grid-cols-[1.1fr_0.9fr]">
                        <div class="bg-[linear-gradient(160deg,_#ecfdf5_0%,_#d1fae5_48%,_#fefce8_100%)] p-8 sm:p-10">
                            <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Blok Utama</span>
                            <h2 class="mt-4 text-3xl font-bold text-gray-900">{{ $content_title }}</h2>
                            <p class="mt-4 text-sm leading-7 text-gray-600">
                                {{ $content_body }}
                            </p>
                        </div>

                        <div class="bg-gray-950 p-8 text-white sm:p-10">
                            <span class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-200/80">Struktur Halaman</span>
                            <div class="mt-6 space-y-4">
                                @foreach ($contentBlocks as $block)
                                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                                        <p class="text-sm font-semibold text-white">{{ $block['title'] }}</p>
                                        <p class="mt-2 text-sm leading-6 text-white/70">{{ $block['body'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </article>

                <section class="grid gap-6 md:grid-cols-3">
                    @foreach ($cards as $card)
                        <article class="group rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-100/80">
                            <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">{{ $card['eyebrow'] }}</span>
                            <h3 class="mt-3 text-xl font-bold text-gray-900">{{ $card['title'] }}</h3>
                            <p class="mt-4 text-sm leading-7 text-gray-600">
                                {{ $card['body'] }}
                            </p>
                            <div class="mt-6 h-1 w-16 rounded-full bg-gradient-to-r from-green-600 to-lime-400 transition-all duration-300 group-hover:w-24"></div>
                        </article>
                    @endforeach
                </section>

                <section class="rounded-[32px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 sm:p-8">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                        <div class="max-w-3xl">
                            <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Mode Pengembangan</span>
                            <h3 class="mt-3 text-2xl font-bold text-gray-900">{{ $cta_title }}</h3>
                            <p class="mt-4 text-sm leading-7 text-gray-600">
                                {{ $cta_body }}
                            </p>
                        </div>

                        <div class="rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-5 text-white shadow-lg shadow-green-900/20 lg:max-w-xs">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100">Status</p>
                            <p class="mt-3 text-lg font-bold">Template awal siap dipoles</p>
                            <p class="mt-2 text-sm leading-6 text-white/85">
                                Konten placeholder sudah diarahkan sesuai fungsi halaman agar proses review lebih cepat.
                            </p>
                        </div>
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60">
                    <h2 class="text-lg font-bold text-gray-900">{{ $sidebar_title }}</h2>
                    <div class="mt-5 space-y-3">
                        @foreach ($sidebarItems as $item)
                            <div class="flex items-start gap-3 rounded-2xl bg-gray-50 px-4 py-3 text-sm text-gray-600">
                                <span class="mt-1 h-2.5 w-2.5 flex-shrink-0 rounded-full bg-green-600"></span>
                                <span>{{ $item }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[28px] border border-emerald-100 bg-emerald-50/80 p-6 shadow-sm shadow-emerald-100/70">
                    <h2 class="text-lg font-bold text-gray-900">Catatan Editor</h2>
                    <p class="mt-3 text-sm leading-6 text-gray-600">
                        Halaman ini sudah dibentuk mengikuti fungsi utamanya, jadi berikutnya tinggal mengganti placeholder dengan konten aktual atau data dinamis.
                    </p>
                </div>
            </aside>
        </div>
    </section>
@endsection
