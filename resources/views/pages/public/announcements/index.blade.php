@php
    $metaTitle = 'Pengumuman Desa';
    $metaDescription =
        'Pusat pengumuman resmi Desa Mentuda untuk informasi layanan, agenda penting, dan pemberitahuan terbaru.';

    $summaryCards = [
        [
            'label' => 'Total Terbit',
            'value' => $featuredAnnouncement ? $announcements->total() + 1 : $announcements->total(),
            'icon' => 'document',
        ],
        [
            'label' => 'Kategori Aktif',
            'value' => $categories->count(),
            'icon' => 'category',
        ],
        [
            'label' => 'Sorotan',
            'value' => $featuredAnnouncement ? '1 utama' : 'Belum ada',
            'icon' => 'star',
        ],
    ];
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative mt-16 overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]">
        </div>
        <div class="absolute -left-24 top-24 h-72 w-72 rounded-full bg-emerald-300/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-green-300/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-down">
                <ol class="flex flex-wrap items-center gap-2">
                    <li>
                        <a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a>
                    </li>
                    <li>/</li>
                    <li class="font-semibold text-white">Pengumuman</li>
                </ol>
            </nav>

            <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px] lg:items-start">
                <div data-aos="fade-up" data-aos-delay="100">
                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100 ring-1 ring-white/15">
                        Pengumuman Resmi
                    </span>

                    <h1 class="mt-6 max-w-3xl text-4xl font-bold tracking-tight text-white sm:text-5xl">
                        Pusat Pengumuman Desa Mentuda
                    </h1>

                    <p class="mt-4 max-w-2xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                        Informasi resmi seputar layanan desa, agenda masyarakat, kegiatan pemerintahan,
                        dan pemberitahuan penting untuk warga Desa Mentuda.
                    </p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        @foreach ($summaryCards as $card)
                            <div data-aos="fade-up" data-aos-delay="{{ 180 + $loop->index * 80 }}"
                                class="rounded-[24px] border border-white/10 bg-white/10 p-5 shadow-lg shadow-black/10 backdrop-blur transition duration-300 hover:-translate-y-1 hover:bg-white/15">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/15">
                                    @if ($card['icon'] === 'document')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 6h8M8 10h8M8 14h5M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                        </svg>
                                    @elseif ($card['icon'] === 'category')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 4h7v7H4V4zm9 0h7v7h-7V4zM4 13h7v7H4v-7zm9 0h7v7h-7v-7z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 3l2.4 5 5.6.8-4 3.9.9 5.5L12 15.6 7.1 18.2l.9-5.5-4-3.9 5.6-.8L12 3z" />
                                        </svg>
                                    @endif
                                </div>

                                <p class="mt-4 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-50/80">
                                    {{ $card['label'] }}
                                </p>

                                <p class="mt-2 text-2xl font-bold text-white">
                                    {{ is_numeric($card['value']) ? number_format($card['value'], 0, ',', '.') : $card['value'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <aside data-aos="fade-left" data-aos-delay="200"
                    class="rounded-[28px] border border-white/10 bg-white/10 p-6 shadow-xl shadow-black/10 backdrop-blur-xl">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5h10M11 12h10M11 19h10M4 6h.01M4 12h.01M4 18h.01" />
                        </svg>
                    </div>

                    <h2 class="mt-4 text-lg font-bold text-white">Fokus Halaman</h2>

                    <div class="mt-4 space-y-3 text-sm leading-6 text-white/85">
                        <p class="rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                            Pengumuman unggulan akan tampil lebih besar agar informasi penting mudah dilihat.
                        </p>
                        <p class="rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                            Gunakan pencarian dan kategori untuk menemukan informasi lebih cepat.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div data-aos="fade-up" data-aos-delay="150"
            class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-xl shadow-gray-200/60 sm:p-6">
            <form method="GET" action="{{ route('public.announcements.index') }}"
                class="grid gap-4 lg:grid-cols-[minmax(0,1.6fr)_minmax(0,0.8fr)_auto]">

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-gray-700">Cari pengumuman</span>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 110-15 7.5 7.5 0 010 15z" />
                            </svg>
                        </span>

                        <input type="text" name="q" value="{{ $search }}"
                            placeholder="Cari judul, ringkasan, atau isi pengumuman..."
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 py-3 pl-12 pr-4 text-sm text-gray-700 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-100">
                    </div>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-gray-700">Kategori</span>
                    <select name="category"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-100">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $postCategory)
                            <option value="{{ $postCategory->slug }}" @selected($category === $postCategory->slug)>
                                {{ $postCategory->name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-green-800 hover:shadow-lg hover:shadow-green-700/20 lg:w-auto">
                        Tampilkan
                    </button>

                    @if ($search !== '' || $category !== '')
                        <a href="{{ route('public.announcements.index') }}"
                            class="inline-flex w-full items-center justify-center rounded-2xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 lg:w-auto">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <main class="space-y-6">
                @if ($featuredAnnouncement)
                    <article data-aos="fade-up"
                        class="overflow-hidden rounded-[30px] border border-emerald-100 bg-white shadow-xl shadow-emerald-100/60">
                        <div class="grid lg:grid-cols-[1.05fr_0.95fr]">
                            <div
                                class="relative min-h-[300px] overflow-hidden bg-gradient-to-br from-emerald-100 via-white to-green-50">
                                @if ($featuredAnnouncement->cover_image_url)
                                    <img src="{{ $featuredAnnouncement->cover_image_url }}"
                                        alt="{{ $featuredAnnouncement->cover_image_alt ?: $featuredAnnouncement->title }}"
                                        class="absolute inset-0 h-full w-full object-cover transition duration-700 hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                                    </div>
                                @else
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-green-700 via-emerald-600 to-green-500">
                                    </div>
                                @endif

                                <div class="absolute left-6 top-6">
                                    <span
                                        class="inline-flex items-center rounded-full bg-white/90 px-4 py-1.5 text-[11px] font-bold uppercase tracking-[0.18em] text-green-700 ring-1 ring-white/70">
                                        Pengumuman Utama
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 sm:p-8">
                                <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                    <span
                                        class="rounded-full bg-green-50 px-3 py-1 font-semibold text-green-700 ring-1 ring-green-100">
                                        {{ $featuredAnnouncement->category?->name ?? 'Pengumuman Desa' }}
                                    </span>
                                    <span>
                                        {{ optional($featuredAnnouncement->announcement_date)->translatedFormat('d F Y') }}
                                    </span>
                                </div>

                                <h2 class="mt-4 text-2xl font-bold tracking-tight text-gray-900">
                                    {{ $featuredAnnouncement->title }}
                                </h2>

                                <p class="mt-4 text-sm leading-7 text-gray-600">
                                    {{ $featuredAnnouncement->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($featuredAnnouncement->content), 190) }}
                                </p>

                                @if ($featuredAnnouncement->event_at || $featuredAnnouncement->event_location)
                                    <div class="mt-5 grid gap-3 text-xs text-gray-600">
                                        @if ($featuredAnnouncement->event_at)
                                            <span
                                                class="rounded-2xl bg-green-50 px-4 py-3 font-semibold text-green-700 ring-1 ring-green-100">
                                                {{ $featuredAnnouncement->event_at->locale('id')->translatedFormat('l, d F Y H:i') }}
                                            </span>
                                        @endif

                                        @if ($featuredAnnouncement->event_location)
                                            <span
                                                class="rounded-2xl bg-gray-50 px-4 py-3 font-medium text-gray-700 ring-1 ring-gray-100">
                                                {{ $featuredAnnouncement->event_location }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <div class="mt-6">
                                    <a href="{{ route('public.announcements.show', $featuredAnnouncement->slug) }}"
                                        class="inline-flex items-center gap-2 rounded-full bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-green-800 hover:shadow-lg hover:shadow-green-700/20">
                                        Baca Detail
                                        <span>&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endif

                <section class="grid gap-5 md:grid-cols-2">
                    @forelse ($announcements as $announcement)
                        <article data-aos="fade-up" data-aos-delay="{{ min(($loop->index % 2) * 80, 160) }}"
                            class="group rounded-[26px] border border-gray-200 bg-white p-5 shadow-md shadow-gray-100/70 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-xl hover:shadow-green-100/60">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                                    <span class="text-[10px] font-bold uppercase">
                                        {{ optional($announcement->announcement_date)->translatedFormat('M') }}
                                    </span>
                                    <strong class="text-2xl leading-none">
                                        {{ optional($announcement->announcement_date)->format('d') }}
                                    </strong>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span
                                            class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700 ring-1 ring-green-100">
                                            {{ $announcement->category?->name ?? 'Pengumuman' }}
                                        </span>

                                        @if ($announcement->is_featured)
                                            <span
                                                class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-amber-100">
                                                Prioritas
                                            </span>
                                        @endif
                                    </div>

                                    <h3
                                        class="mt-3 text-lg font-bold leading-snug text-gray-900 transition group-hover:text-green-700">
                                        {{ $announcement->title }}
                                    </h3>

                                    <p class="mt-3 text-sm leading-6 text-gray-600">
                                        {{ $announcement->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($announcement->content), 120) }}
                                    </p>

                                    <div class="mt-4">
                                        <a href="{{ route('public.announcements.show', $announcement->slug) }}"
                                            class="inline-flex items-center gap-2 text-sm font-semibold text-green-700 transition group-hover:gap-3">
                                            Lihat detail
                                            <span>&rarr;</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div data-aos="fade-up"
                            class="md:col-span-2 rounded-[26px] border border-dashed border-gray-300 bg-white px-6 py-12 text-center">
                            <h3 class="text-lg font-semibold text-gray-900">Belum ada pengumuman ditemukan</h3>
                            <p class="mt-2 text-sm text-gray-600">
                                Coba ubah kata kunci pencarian atau pilih kategori lain.
                            </p>
                        </div>
                    @endforelse
                </section>

                @if ($announcements->hasPages())
                    <div data-aos="fade-up">
                        {{ $announcements->links() }}
                    </div>
                @endif
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div data-aos="fade-left"
                    class="rounded-[26px] border border-gray-200 bg-white p-6 shadow-lg shadow-gray-100/70">
                    <h2 class="text-lg font-bold text-gray-900">Kategori Pengumuman</h2>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('public.announcements.index') }}"
                            class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-semibold transition {{ $category === '' ? 'border-green-700 bg-green-700 text-white' : 'border-gray-200 text-gray-700 hover:border-green-200 hover:bg-green-50 hover:text-green-700' }}">
                            Semua
                        </a>

                        @foreach ($categories as $postCategory)
                            <a href="{{ route('public.announcements.index', ['category' => $postCategory->slug]) }}"
                                class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-semibold transition {{ $category === $postCategory->slug ? 'border-green-700 bg-green-700 text-white' : 'border-gray-200 text-gray-700 hover:border-green-200 hover:bg-green-50 hover:text-green-700' }}">
                                {{ $postCategory->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="100"
                    class="rounded-[26px] border border-gray-200 bg-white p-6 shadow-lg shadow-gray-100/70">
                    <h2 class="text-lg font-bold text-gray-900">Pengumuman Terbaru</h2>

                    <div class="mt-5 space-y-3">
                        @foreach ($latestAnnouncements as $latestAnnouncement)
                            <a href="{{ route('public.announcements.show', $latestAnnouncement->slug) }}"
                                class="group block rounded-2xl border border-gray-100 bg-gray-50/70 p-4 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:bg-white hover:shadow-md hover:shadow-green-100/60">
                                <h3
                                    class="text-sm font-bold leading-6 text-gray-900 transition group-hover:text-green-700">
                                    {{ $latestAnnouncement->title }}
                                </h3>

                                <p class="mt-2 text-xs text-gray-500">
                                    {{ optional($latestAnnouncement->announcement_date)->translatedFormat('d F Y') }}
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
