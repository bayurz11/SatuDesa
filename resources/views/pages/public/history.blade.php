@php
    $metaTitle = $profile->history_title ?: 'Sejarah Desa';
    $metaDescription = $profile->history_description ?: 'Menyusuri jejak perjalanan desa dari masa lampau hingga kini.';
    $historyCards = collect($profile->history_cards ?? [])->values();
    $timelineItems = collect($profile->history_timeline_items ?? [])->values();
    $hasHistoryCards = $historyCards->isNotEmpty();
    $hasTimelineItems = $timelineItems->isNotEmpty();
    $resolveTimelineIconUrl = function ($item) {
        $path = $item['icon_image_path'] ?? null;

        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'img/')) {
            return asset($path);
        }

        return \App\Support\UploadStorage::url($path);
    };
    $resolveHistoryCardImageUrl = function ($card) {
        $path = $card['image_path'] ?? null;

        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'img/')) {
            return asset($path);
        }

        return \App\Support\UploadStorage::url($path);
    };
    $coverImage = filled($profile->history_cover_image_path)
        ? (str_starts_with($profile->history_cover_image_path, 'http://') ||
        str_starts_with($profile->history_cover_image_path, 'https://')
            ? $profile->history_cover_image_path
            : (str_starts_with($profile->history_cover_image_path, 'img/')
                ? asset($profile->history_cover_image_path)
                : \App\Support\UploadStorage::url($profile->history_cover_image_path)))
        : asset('img/bg.jpg');
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative mt-16 overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-down">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Profil Desa</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Sejarah Desa</li>
                </ol>
            </nav>

            <div class="mt-8 max-w-4xl" data-aos="fade-up" data-aos-delay="100">
                <span
                    class="inline-flex items-center rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-50 ring-1 ring-white/15">
                    Profil Desa
                </span>

                <h1 class="mt-6 text-2xl font-bold tracking-tight sm:text-3xl">
                    {{ $profile->history_title }}
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-7 text-emerald-50/90">
                    {{ $profile->history_description }}
                </p>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="public-sidebar-grid public-sidebar-grid--320">
            <main class="space-y-8">
                <article data-aos="fade-up" data-aos-delay="100"
                    class="overflow-hidden rounded-[32px] border border-gray-200 bg-white shadow-lg shadow-gray-200/70">
                    <div
                        class="relative h-[320px] overflow-hidden bg-gradient-to-br from-green-800 via-green-700 to-emerald-600">
                        <img src="{{ $coverImage }}" alt="{{ $profile->history_title }}"
                            class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>

                        <div class="absolute bottom-6 left-6 right-6 text-white">
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                </svg>
                                {{ $profile->history_cover_badge }}
                            </span>

                            <h2 class="mt-4 text-2xl font-bold sm:text-3xl">
                                {{ $profile->history_cover_title }}
                            </h2>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <p class="text-sm leading-7 text-gray-600">
                            {{ $profile->history_intro_text }}
                        </p>
                    </div>
                </article>

                <section class="grid gap-6 md:grid-cols-2">
                    @forelse ($historyCards as $index => $card)
                        @php
                            $historyCardImageUrl = $resolveHistoryCardImageUrl($card);
                        @endphp
                        <article data-aos="fade-up" data-aos-delay="{{ 150 + $index * 100 }}"
                            class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-lg hover:shadow-green-100/60">
                            @if ($historyCardImageUrl)
                                <div class="mb-5 overflow-hidden rounded-3xl border border-green-100 bg-green-50">
                                    <img src="{{ $historyCardImageUrl }}"
                                        alt="{{ $card['title'] ?? 'Foto kartu sejarah' }}"
                                        class="h-48 w-full object-cover">
                                </div>
                            @else
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                                    @if (($card['icon'] ?? 'home') === 'building')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6" />
                                        </svg>
                                    @elseif (($card['icon'] ?? 'home') === 'spark')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 3l1.8 5.4L19 10l-5.2 1.6L12 17l-1.8-5.4L5 10l5.2-1.6L12 3z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 11l9-7 9 7M5 10v10h14V10M9 20v-6h6v6" />
                                        </svg>
                                    @endif
                                </div>
                            @endif

                            <span
                                class="mt-5 inline-block text-xs font-semibold uppercase tracking-[0.24em] text-green-700">
                                {{ $card['badge'] ?? '-' }}
                            </span>

                            <h3 class="mt-3 text-xl font-bold text-gray-900">
                                {{ $card['title'] ?? '-' }}
                            </h3>

                            <p class="mt-4 text-sm leading-7 text-gray-600">
                                {{ $card['description'] ?? '-' }}
                            </p>
                        </article>
                    @empty
                        <div class="md:col-span-2 rounded-[28px] border border-dashed border-green-200 bg-gradient-to-br from-green-50 to-white p-8 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-green-700 ring-1 ring-green-100 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-5 text-xl font-bold text-gray-900">Ringkasan Sejarah Belum Ditambahkan</h3>
                            <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                                Admin belum menambahkan kartu sejarah desa. Narasi utama di atas tetap bisa dibaca, dan bagian ringkasan ini akan muncul otomatis setelah data diisi.
                            </p>
                        </div>
                    @endforelse
                </section>

                <section data-aos="fade-up" data-aos-delay="150"
                    class="rounded-[32px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60 sm:p-8">
                    <div class="max-w-3xl">
                        <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">
                            {{ $profile->history_timeline_badge }}
                        </span>

                        <h3 class="mt-3 text-2xl font-bold text-gray-900">
                            {{ $profile->history_timeline_title }}
                        </h3>
                    </div>

                    <div class="mt-6 grid gap-5">
                        @forelse ($timelineItems as $index => $item)
                            @php
                                $timelineIconUrl = $resolveTimelineIconUrl($item);
                            @endphp

                            <div data-aos="fade-up" data-aos-delay="{{ 200 + $index * 100 }}"
                                class="group flex gap-4 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm shadow-gray-200/50 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:bg-green-50/50 hover:shadow-lg hover:shadow-green-100/60">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100 transition duration-300 group-hover:bg-green-700 group-hover:text-white">

                                    @if ($timelineIconUrl)
                                        <img src="{{ $timelineIconUrl }}" alt="{{ $item['title'] ?? 'Ikon Linimasa' }}"
                                            class="h-full w-full object-cover">
                                    @elseif (($item['icon'] ?? 'home') === 'building')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 21V5a2 2 0 012-2h8a2 2 0 012 2v16M9 7h2M9 11h2M9 15h2M18 21v-8h2v8" />
                                        </svg>
                                    @elseif (($item['icon'] ?? 'home') === 'spark')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 3l1.8 5.4L19 10l-5.2 1.6L12 17l-1.8-5.4L5 10l5.2-1.6L12 3z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 11l9-7 9 7M5 10v10h14V10M9 20v-6h6v6" />
                                        </svg>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">
                                        {{ $item['label'] ?? 'Linimasa ' . ($index + 1) }}
                                    </p>

                                    <h3 class="mt-1 text-lg font-bold text-gray-900">
                                        {{ $item['title'] ?? '-' }}
                                    </h3>

                                    <p class="mt-2 text-sm leading-7 text-gray-600">
                                        {{ $item['desc'] ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-green-200 bg-gradient-to-br from-green-50 to-white p-6 text-center">
                                <p class="text-sm font-semibold text-gray-900">Linimasa Belum Tersedia</p>
                                <p class="mt-2 text-sm leading-7 text-gray-600">
                                    Urutan peristiwa sejarah desa masih dalam proses penyusunan. Bagian ini akan menampilkan tahapan perjalanan desa setelah datanya ditambahkan.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                @include('pages.public.partials.profile-sidebar-nav', ['active' => 'history', 'delay' => 200])

                <div data-aos="fade-left" data-aos-delay="300"
                    class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-12 -left-12 h-36 w-36 rounded-full bg-black/10"></div>

                    <div class="relative">
                        <div
                            class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                            </svg>
                        </div>

                        <h2 class="text-lg font-bold">{{ $profile->history_sidebar_title ?: 'Catatan Sejarah Desa' }}</h2>

                        <p class="mt-3 text-sm leading-6 text-white/85">
                            {{ $profile->history_sidebar_description ?: 'Halaman ini akan terus diperbarui seiring penambahan narasi sejarah, dokumentasi, dan linimasa perjalanan desa.' }}
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
