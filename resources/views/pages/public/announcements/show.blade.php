@php
    $metaTitle = $announcement->meta_title ?: $announcement->title;
    $metaDescription = $announcement->meta_description ?: ($announcement->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($announcement->content), 160));
@endphp

@extends('layouts.public')

@section('content')
    <style>
        .article-content .ql-ui {
            display: none;
        }
    </style>

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
                    <li><a href="{{ route('public.announcements.index') }}" class="transition hover:text-white">Pengumuman</a></li>
                    <li>/</li>
                    <li class="line-clamp-1 font-semibold text-white">{{ $announcement->title }}</li>
                </ol>
            </nav>

            <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px] lg:items-start">
                <div data-aos="fade-up">
                    <div class="flex flex-wrap items-center gap-3">
                        <span
                            class="inline-flex rounded-full bg-white/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-50 ring-1 ring-white/15">
                            Pengumuman Resmi
                        </span>
                        @if ($announcement->category)
                            <span
                                class="inline-flex rounded-full bg-emerald-300/15 px-4 py-1.5 text-[11px] font-medium text-emerald-50 ring-1 ring-emerald-200/20">
                                {{ $announcement->category->name }}
                            </span>
                        @endif
                    </div>

                    <h1 class="mt-5 max-w-4xl text-2xl font-bold tracking-tight text-white sm:text-4xl lg:leading-tight">
                        {{ $announcement->title }}
                    </h1>

                    @if ($announcement->excerpt)
                        <p class="mt-4 max-w-3xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                            {{ $announcement->excerpt }}
                        </p>
                    @endif
                </div>

                <aside class="rounded-[24px] border border-white/10 bg-white/10 p-5 shadow-xl shadow-teal-950/20 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:bg-white/15"
                    data-aos="fade-left">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100">
                        Ringkasan
                    </p>

                    <dl class="mt-4 space-y-3 text-sm text-white/90">
                        <div class="rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                            <dt class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100/80">Tanggal</dt>
                            <dd class="mt-2">{{ optional($announcement->published_at)->translatedFormat('d F Y, H:i') }}</dd>
                        </div>
                        @if ($announcement->event_at)
                            <div class="rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100/80">Pelaksanaan</dt>
                                <dd class="mt-2">{{ $announcement->event_at->locale('id')->translatedFormat('l, d F Y H:i') }}</dd>
                            </div>
                        @endif
                        @if ($announcement->event_location)
                            <div class="rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100/80">Lokasi</dt>
                                <dd class="mt-2">{{ $announcement->event_location }}</dd>
                            </div>
                        @endif
                        @if ($announcement->author)
                            <div class="rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100/80">Penulis</dt>
                                <dd class="mt-2">{{ $announcement->author->name }}</dd>
                            </div>
                        @endif
                        <div class="rounded-2xl bg-white/5 px-4 py-3 ring-1 ring-white/10">
                            <dt class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100/80">Status</dt>
                            <dd class="mt-2">{{ $announcement->is_featured ? 'Pengumuman prioritas' : 'Pengumuman publik' }}</dd>
                        </div>
                    </dl>
                </aside>
            </div>
        </div>
    </section>

    <section class="relative z-10 bg-gradient-to-b from-emerald-50/60 via-white to-white">
        <div class="mx-auto mt-6 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
                <main>
                    <article class="overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-xl shadow-gray-200/60"
                        data-aos="fade-up">
                        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-100 via-white to-sky-100"
                            data-aos="zoom-in" data-aos-delay="100">
                            @if ($announcement->cover_image_url)
                                <img src="{{ $announcement->cover_image_url }}"
                                    alt="{{ $announcement->cover_image_alt ?: $announcement->title }}"
                                    class="max-h-[560px] w-full object-cover">
                            @else
                                <div class="flex min-h-[320px] items-end bg-gradient-to-br from-emerald-800 via-green-700 to-cyan-700 p-8 text-white">
                                    <div>
                                        <span
                                            class="inline-flex rounded-full bg-white/15 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-white/90 ring-1 ring-white/20">
                                            Pengumuman Desa Mentuda
                                        </span>
                                        <h2 class="mt-4 max-w-3xl text-3xl font-bold leading-tight">
                                            {{ $announcement->title }}
                                        </h2>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($announcement->cover_image_caption)
                            <p class="border-b border-gray-100 bg-gray-50 px-6 py-3 text-center text-sm text-gray-500"
                                data-aos="fade-up">
                                {{ $announcement->cover_image_caption }}
                            </p>
                        @endif

                        <div class="p-6 sm:p-10" data-aos="fade-up" data-aos-delay="120">
                            @if ($announcement->event_at || $announcement->event_location)
                                <div class="mb-8 grid gap-4 rounded-[24px] border border-emerald-100 bg-gradient-to-r from-emerald-50 to-white p-5 sm:grid-cols-2">
                                    @if ($announcement->event_at)
                                        <div>
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-700">Jadwal Pelaksanaan</p>
                                            <p class="mt-2 text-base font-semibold text-gray-900">{{ $announcement->event_at->locale('id')->translatedFormat('l, d F Y H:i') }}</p>
                                        </div>
                                    @endif
                                    @if ($announcement->event_location)
                                        <div>
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-700">Lokasi Pelaksanaan</p>
                                            <p class="mt-2 text-base font-semibold text-gray-900">{{ $announcement->event_location }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="article-content prose prose-lg max-w-none
                                prose-headings:font-bold prose-headings:text-gray-900 prose-p:leading-8 prose-p:text-gray-700
                                prose-a:font-semibold prose-a:text-green-700 prose-strong:text-gray-900
                                prose-ul:list-disc prose-ol:list-decimal prose-li:my-1 prose-li:marker:text-green-600
                                prose-img:rounded-2xl prose-img:shadow-lg prose-blockquote:border-l-4
                                prose-blockquote:border-green-700 prose-blockquote:bg-green-50 prose-blockquote:px-5
                                prose-blockquote:py-3 prose-blockquote:text-gray-700">
                                {!! $announcement->content !!}
                            </div>
                        </div>
                    </article>
                </main>

                <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                    @if ($relatedAnnouncements->isNotEmpty())
                        <div class="rounded-[24px] border border-gray-200 bg-white p-6 shadow-lg shadow-gray-100/60"
                            data-aos="fade-left">
                            <h2 class="text-lg font-bold text-gray-900">Pengumuman Terkait</h2>
                            <div class="mt-5 space-y-4">
                                @foreach ($relatedAnnouncements as $relatedAnnouncement)
                                    <a href="{{ route('public.announcements.show', $relatedAnnouncement->slug) }}"
                                        class="group block rounded-2xl bg-gradient-to-br from-emerald-50 via-white to-sky-50 p-4 ring-1 ring-emerald-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                                        data-aos="fade-left" data-aos-delay="{{ 50 + ($loop->index * 50) }}">
                                        <h3 class="text-sm font-bold leading-6 text-gray-900 transition group-hover:text-emerald-700">
                                            {{ $relatedAnnouncement->title }}
                                        </h3>
                                        <p class="mt-2 text-xs text-gray-500">
                                            {{ optional($relatedAnnouncement->announcement_date)->translatedFormat('d F Y') }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="rounded-[24px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20"
                        data-aos="fade-left" data-aos-delay="120">
                        <h2 class="text-lg font-bold">Perlu melihat arsip lainnya?</h2>
                        <p class="mt-3 text-sm leading-6 text-white/85">
                            Buka daftar pengumuman untuk melihat pemberitahuan resmi lain dari Pemerintah Desa Mentuda.
                        </p>
                        <a href="{{ route('public.announcements.index') }}"
                            class="mt-6 inline-flex items-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-green-800 transition hover:bg-emerald-50">
                            Lihat Semua Pengumuman
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
