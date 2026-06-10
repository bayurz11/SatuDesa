@php
    $metaTitle = 'Pengumuman Desa';
    $metaDescription =
        'Pusat pengumuman resmi Desa Mentuda untuk informasi layanan, agenda penting, dan pemberitahuan terbaru.';

    $summaryCards = [
        [
            'label' => 'Total Terbit',
            'value' => $featuredAnnouncement ? $announcements->total() + 1 : $announcements->total(),
            'tone' => 'from-emerald-500/20 to-green-600/10',
        ],
        [
            'label' => 'Kategori Aktif',
            'value' => $categories->count(),
            'tone' => 'from-sky-500/20 to-cyan-600/10',
        ],
        [
            'label' => 'Sorotan',
            'value' => $featuredAnnouncement ? '1 utama' : 'Belum ada',
            'tone' => 'from-amber-500/20 to-orange-600/10',
        ],
    ];
@endphp

@extends('layouts.public')

@section('content')
    <section
        class="relative mt-16 overflow-hidden bg-[linear-gradient(135deg,_#052e16_0%,_#14532d_45%,_#166534_100%)] text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.18),_transparent_30%)]">
        </div>
        <div class="absolute -left-20 top-20 h-72 w-72 rounded-full bg-emerald-300/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-cyan-300/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-16 pt-8 sm:px-6 lg:px-8">
            <nav class="text-xs text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-up">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li class="font-semibold text-white">Pengumuman</li>
                </ol>
            </nav>

            <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px] lg:items-start">
                <div data-aos="fade-up">
                    <div class="flex flex-wrap items-center gap-3">
                        <span
                            class="inline-flex rounded-full bg-white/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-50 ring-1 ring-white/15">
                            Informasi Resmi
                        </span>
                        <span
                            class="inline-flex rounded-full bg-emerald-300/15 px-4 py-1.5 text-[11px] font-medium text-emerald-50 ring-1 ring-emerald-200/20">
                            Update Berkala Desa Mentuda
                        </span>
                    </div>

                    <h1
                        class="mt-5 max-w-3xl text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-[2rem] lg:leading-tight">
                        Pusat Pengumuman Resmi Desa
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-50/90">
                        Warga dapat memantau pemberitahuan terbaru, perubahan jadwal layanan, agenda penting, dan
                        informasi operasional desa dari satu halaman yang mudah dipindai.
                    </p>

                    <div class="mt-7 grid gap-4 sm:grid-cols-3">
                        @foreach ($summaryCards as $card)
                            <div class="rounded-[22px] border border-white/10 bg-gradient-to-br {{ $card['tone'] }} p-5 shadow-lg shadow-black/5 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:bg-white/15 hover:shadow-xl"
                                data-aos="fade-up" data-aos-delay="{{ 60 + $loop->index * 70 }}">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-50/80">
                                    {{ $card['label'] }}
                                </p>
                                <p class="mt-4 text-2xl font-bold text-white">
                                    {{ is_numeric($card['value']) ? number_format($card['value'], 0, ',', '.') : $card['value'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <aside
                    class="rounded-[24px] border border-white/10 bg-white/10 p-5 shadow-xl shadow-teal-950/20 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:bg-white/15"
                    data-aos="fade-left">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100">
                        Fokus Halaman
                    </p>

                    <div class="mt-4 space-y-3 text-xs leading-6 text-white/90">
                        <div class="rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                            Pengumuman yang ditandai unggulan akan muncul paling depan agar informasi mendesak cepat
                            terlihat.
                        </div>
                        <div class="rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                            Gunakan pencarian dan kategori untuk menyaring pengumuman pelayanan, agenda, atau pemberitahuan
                            umum.
                        </div>
                        <div class="rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                            Arsip terbaru tetap tersedia agar warga bisa menelusuri riwayat informasi desa.
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section class="mx-auto -mt-10 max-w-7xl px-4 pb-14 sm:px-6 lg:px-8 z-10 relative">
        <div class="mx-auto mt-6 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
            <section class="mx-auto -mt-12 max-w-7xl px-4 pb-14 sm:px-6 lg:px-8 z-10 relative">
                <div class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-xl shadow-gray-200/60 sm:p-6"
                    data-aos="fade-up" data-aos-delay="150">
                    <form method="GET" action="{{ route('public.announcements.index') }}"
                        class="grid gap-4 lg:grid-cols-[1.6fr_0.8fr_auto]">

                        <label class="block">
                            <span class="mb-2 block text-sm font-medium text-gray-700">Cari pengumuman</span>
                            <input type="text" name="q" value="{{ $search }}"
                                placeholder="Cari judul, ringkasan, atau isi pengumuman..."
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-100">
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-sm font-medium text-gray-700">Kategori</span>
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
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-green-800 hover:shadow-lg lg:w-auto">
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
            </section>

            <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
                <main class="space-y-6">
                    @if ($featuredAnnouncement)
                        <article
                            class="overflow-hidden rounded-[28px] border border-emerald-100 bg-white shadow-xl shadow-emerald-100/60"
                            data-aos="fade-up">
                            <div class="grid gap-0 lg:grid-cols-[1.1fr_0.9fr]">
                                <div
                                    class="relative min-h-[280px] overflow-hidden bg-gradient-to-br from-emerald-100 via-white to-sky-100">
                                    @if ($featuredAnnouncement->cover_image_url)
                                        <img src="{{ $featuredAnnouncement->cover_image_url }}"
                                            alt="{{ $featuredAnnouncement->cover_image_alt ?: $featuredAnnouncement->title }}"
                                            class="absolute inset-0 h-full w-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/15 to-transparent">
                                        </div>
                                    @else
                                        <div
                                            class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(16,185,129,0.18),_transparent_35%)]">
                                        </div>
                                    @endif

                                    <div class="absolute left-6 top-6">
                                        <span
                                            class="inline-flex items-center rounded-full bg-white/90 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-700 ring-1 ring-white/70">
                                            Pengumuman Utama
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6 sm:p-8">
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 font-semibold text-emerald-700 ring-1 ring-emerald-100">
                                            {{ $featuredAnnouncement->category?->name ?? 'Pengumuman Desa' }}
                                        </span>
                                        <span>{{ optional($featuredAnnouncement->announcement_date)->translatedFormat('d F Y') }}</span>
                                    </div>

                                    <h2 class="mt-4 text-2xl font-bold tracking-tight text-gray-900">
                                        {{ $featuredAnnouncement->title }}
                                    </h2>

                                    <p class="mt-4 text-sm leading-7 text-gray-600">
                                        {{ $featuredAnnouncement->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($featuredAnnouncement->content), 190) }}
                                    </p>

                                    @if ($featuredAnnouncement->event_at || $featuredAnnouncement->event_location)
                                        <div class="mt-4 flex flex-wrap gap-3 text-xs text-gray-600">
                                            @if ($featuredAnnouncement->event_at)
                                                <span
                                                    class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1.5 font-semibold text-emerald-700 ring-1 ring-emerald-100">
                                                    {{ $featuredAnnouncement->event_at->locale('id')->translatedFormat('l, d F Y H:i') }}
                                                </span>
                                            @endif
                                            @if ($featuredAnnouncement->event_location)
                                                <span
                                                    class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1.5 font-medium text-slate-700">
                                                    {{ $featuredAnnouncement->event_location }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="mt-6 flex flex-wrap gap-3">
                                        <a href="{{ route('public.announcements.show', $featuredAnnouncement->slug) }}"
                                            class="inline-flex items-center rounded-full bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-green-800 hover:shadow-lg">
                                            Baca Detail
                                        </a>
                                        <span
                                            class="inline-flex items-center rounded-full bg-slate-100 px-4 py-3 text-sm font-medium text-slate-600">
                                            Diprioritaskan untuk informasi yang perlu cepat diketahui warga
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endif

                    <section class="grid gap-5 md:grid-cols-2">
                        @forelse ($announcements as $announcement)
                            <article
                                class="group relative overflow-hidden rounded-[32px] border border-gray-200 bg-white p-5 shadow-lg shadow-gray-100/70 transition-all duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-2xl"
                                data-aos="fade-up" data-aos-delay="{{ min(($loop->index % 2) * 80, 160) }}">

                                <div
                                    class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-emerald-100/50 blur-2xl transition group-hover:bg-emerald-200/70">
                                </div>

                                <div class="relative flex items-start justify-between gap-4">
                                    <div class="space-y-2">
                                        <span
                                            class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-1.5 text-xs font-bold text-emerald-700 ring-1 ring-emerald-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                            </svg>
                                            {{ $announcement->category?->name ?? 'Pengumuman' }}
                                        </span>


                                    </div>

                                    @if ($announcement->event_at)
                                        <span
                                            class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-emerald-600 px-3 py-1.5 text-xs font-bold text-white shadow-lg shadow-emerald-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            {{ $announcement->event_at->format('H:i') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-5">
                                    <div
                                        class="flex h-[160px] w-full flex-col items-center justify-center rounded-[20px] bg-gradient-to-br from-emerald-50 to-green-100 ring-1 ring-emerald-100 transition duration-300 group-hover:scale-[1.02]">
                                        <span class="text-2xl font-black uppercase text-emerald-700">
                                            {{ optional($announcement->announcement_date)->translatedFormat('M') }}
                                        </span>

                                        <strong class="mt-2 text-4xl font-black leading-none text-emerald-700">
                                            {{ optional($announcement->announcement_date)->format('d') }}
                                        </strong>
                                    </div>

                                    <div class="mt-5">
                                        <h3
                                            class="line-clamp-2 text-2xl font-bold text-center leading-tight text-gray-950 transition group-hover:text-emerald-700">
                                            {{ $announcement->title }}
                                        </h3>

                                        <p class="mt-4 line-clamp-4 text-sm leading-7 text-gray-700">
                                            {{ $announcement->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($announcement->content), 100) }}
                                        </p>
                                    </div>
                                </div>

                                <div
                                    class="relative mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 pt-4">
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>

                                        @if ($announcement->event_location)
                                            {{ \Illuminate\Support\Str::limit($announcement->event_location, 28) }}
                                        @endif

                                    </span>

                                    <a href="{{ route('public.announcements.show', $announcement->slug) }}"
                                        class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-lg shadow-emerald-200 transition hover:-translate-y-0.5 hover:bg-emerald-700">
                                        Lihat detail
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 transition group-hover:translate-x-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="md:col-span-2 rounded-[32px] border border-dashed border-gray-300 bg-white px-6 py-12 text-center"
                                data-aos="fade-up">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Belum ada pengumuman ditemukan
                                </h3>

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
                    <div class="rounded-[24px] border border-gray-200 bg-white p-6 shadow-lg shadow-gray-100/60"
                        data-aos="fade-left">
                        <h2 class="text-lg font-bold text-gray-900">Kategori Pengumuman</h2>
                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="{{ route('public.announcements.index') }}"
                                class="inline-flex items-center rounded-full border px-4 py-2 text-sm transition {{ $category === '' ? 'border-green-700 bg-green-700 text-white' : 'border-gray-200 text-gray-700 hover:border-green-200 hover:bg-green-50 hover:text-green-700' }}">
                                Semua
                            </a>
                            @foreach ($categories as $postCategory)
                                <a href="{{ route('public.announcements.index', ['category' => $postCategory->slug]) }}"
                                    class="inline-flex items-center rounded-full border px-4 py-2 text-sm transition {{ $category === $postCategory->slug ? 'border-green-700 bg-green-700 text-white' : 'border-gray-200 text-gray-700 hover:border-green-200 hover:bg-green-50 hover:text-green-700' }}">
                                    {{ $postCategory->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-[24px] border border-gray-200 bg-white p-6 shadow-lg shadow-gray-100/60"
                        data-aos="fade-left" data-aos-delay="100">
                        <h2 class="text-lg font-bold text-gray-900">Pengumuman Terbaru</h2>
                        <div class="mt-5 space-y-4">
                            @foreach ($latestAnnouncements as $latestAnnouncement)
                                <a href="{{ route('public.announcements.show', $latestAnnouncement->slug) }}"
                                    class="group block rounded-2xl bg-gradient-to-br from-emerald-50 via-white to-sky-50 p-4 ring-1 ring-emerald-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                                    data-aos="fade-left" data-aos-delay="{{ 50 + $loop->index * 50 }}">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3
                                                class="text-sm font-bold leading-6 text-gray-900 transition group-hover:text-emerald-700">
                                                {{ $latestAnnouncement->title }}
                                            </h3>
                                            <p class="mt-2 text-xs text-gray-500">
                                                {{ optional($latestAnnouncement->announcement_date)->translatedFormat('d F Y') }}
                                            </p>
                                        </div>
                                        <span
                                            class="inline-flex rounded-full bg-white px-3 py-1 text-[11px] font-semibold text-emerald-700 ring-1 ring-emerald-100">
                                            {{ $latestAnnouncement->category?->name ?? 'Info' }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
