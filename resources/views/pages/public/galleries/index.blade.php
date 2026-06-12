@php
    $metaTitle = 'Galeri Desa ' . $village->name;
    $metaDescription =
        'Galeri publik ' . $village->name . ' yang menampilkan kegiatan warga, pembangunan desa, dan suasana kawasan.';
    $hasGalleryContent = filled($featuredGallery) || $galleryAlbums->isNotEmpty();
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
                    <li>Informasi</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Galeri Desa</li>
                </ol>
            </nav>

            <div class="max-w-4xl" data-aos="fade-up">
                <h1
                    class="mt-5 max-w-2xl text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-[2rem] lg:leading-tight">
                    Galeri Desa {{ $village->name }}
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-50/90">
                    Kumpulan dokumentasi kegiatan desa, hasil pembangunan, potret kawasan, dan momen kebersamaan warga
                    yang disusun agar mudah dijelajahi pengunjung.
                </p>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <main class="space-y-8">
                <section data-aos="fade-up" data-aos-delay="100"
                    class="overflow-hidden rounded-[32px] border border-gray-200 bg-white p-5 shadow-lg shadow-gray-200/70 sm:p-7">

                    <div class="text-center">
                        <span
                            class="inline-flex items-center rounded-full bg-green-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-green-700 ring-1 ring-green-100">
                            Dokumentasi Visual
                        </span>

                        <h2 class="mt-4 text-2xl font-bold text-gray-900 sm:text-3xl">
                            Galeri Kegiatan Desa
                        </h2>

                        <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                            Dokumentasi kegiatan warga, pembangunan, pelayanan publik, dan potensi wilayah {{ $village->name }}.
                        </p>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        @foreach ($galleryHighlights as $highlight)
                            <div
                                class="rounded-[22px] border border-green-100 bg-green-50 p-4 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md hover:shadow-green-100/60">
                                <p class="text-2xl font-bold text-green-800">{{ $highlight['value'] }}</p>
                                <p class="mt-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-green-700">
                                    {{ $highlight['label'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    @if ($featuredGallery)
                        <article
                            class="group relative mt-10 overflow-hidden rounded-[28px] bg-white shadow-lg ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:ring-green-200">
                            <div class="relative h-[340px] overflow-hidden sm:h-[420px] lg:h-[500px]">
                                <img src="{{ $featuredGallery->cover_image_url ?: asset('img/bg.jpg') }}" alt="{{ $featuredGallery->title }}"
                                    class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">

                                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/10"></div>

                                <div class="absolute left-5 right-5 bottom-5 text-white md:left-8 md:right-8 md:bottom-8">
                                    <div class="mb-4 flex flex-wrap items-center gap-3">
                                        <span
                                            class="inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                                            Album Unggulan
                                        </span>

                                        <span class="text-sm text-white/90">{{ $featuredGallery->category ?: 'Galeri Desa' }}</span>
                                        <span class="text-sm text-white/90">{{ $featuredGallery->resolved_photo_count }} foto</span>
                                        <span class="text-sm text-white/90">{{ optional($featuredGallery->gallery_date)->translatedFormat('d M Y') ?: '-' }}</span>
                                    </div>

                                    <h3
                                        class="max-w-3xl text-2xl font-bold leading-tight text-white transition duration-300 group-hover:text-green-300 md:text-4xl">
                                        {{ $featuredGallery->title }}
                                    </h3>

                                    <p class="mt-3 max-w-2xl text-sm leading-7 text-white/85">
                                        {{ $featuredGallery->description ?: $featuredGallery->excerpt }}
                                    </p>
                                </div>
                            </div>
                        </article>
                    @endif

                    @if ($galleryAlbums->isNotEmpty())
                        <div class="mt-8 grid gap-5 md:grid-cols-2">
                            @foreach ($galleryAlbums as $album)
                                <article data-aos="fade-up" data-aos-delay="{{ min(($loop->index % 2) * 80, 160) }}"
                                    class="group overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-xl hover:shadow-green-100/60">

                                    <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
                                        <img src="{{ $album->cover_image_url ?: asset('img/bg.jpg') }}" alt="{{ $album->title }}"
                                            class="h-full w-full object-cover transition duration-700 group-hover:scale-105">

                                        <span
                                            class="absolute left-4 top-4 inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                                            {{ $album->category ?: 'Galeri Desa' }}
                                        </span>
                                    </div>

                                    <div class="p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-green-700">
                                            {{ $album->resolved_photo_count }} Foto
                                        </p>

                                        <h3
                                            class="mt-3 line-clamp-2 text-lg font-bold text-gray-900 transition group-hover:text-green-700">
                                            {{ $album->title }}
                                        </h3>

                                        <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">
                                            {{ $album->excerpt ?: $album->description }}
                                        </p>

                                        @if ($album->photos->isNotEmpty())
                                            <div class="mt-4 grid grid-cols-3 gap-2">
                                                @foreach ($album->photos->take(3) as $photo)
                                                    <div class="aspect-[4/3] overflow-hidden rounded-xl bg-gray-100">
                                                        <img src="{{ $photo->image_url }}" alt="{{ $photo->alt_text ?: $album->title }}"
                                                            class="h-full w-full object-cover">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @elseif (! $featuredGallery)
                        <div class="mt-8 rounded-[28px] border border-dashed border-green-200 bg-gradient-to-br from-green-50 to-white p-8 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-green-700 ring-1 ring-green-100 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16l4-4a2 2 0 012.828 0L13 15.172l2-2A2 2 0 0117.828 13L21 16M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z" />
                                </svg>
                            </div>
                            <h3 class="mt-5 text-xl font-bold text-gray-900">Galeri Belum Tersedia</h3>
                            <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                                Album dokumentasi untuk {{ $village->name }} masih dalam proses penyiapan. Setelah admin menambahkan foto kegiatan, halaman ini akan otomatis menampilkan album publik.
                            </p>
                        </div>
                    @endif

                    <div
                        class="mt-8 rounded-2xl bg-green-50 px-4 py-3 text-sm leading-6 text-green-800 ring-1 ring-green-100">
                        {{ $hasGalleryContent
                            ? 'Galeri ini kini tersambung langsung dengan dashboard admin sehingga album yang dipublikasikan akan tampil otomatis di halaman publik.'
                            : 'Saat ini belum ada album publik yang ditampilkan. Begitu data galeri diisi dari admin, kontennya akan langsung muncul di halaman ini.' }}
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div data-aos="fade-left" data-aos-delay="200"
                    class="overflow-hidden rounded-[28px] border border-gray-200 bg-white p-5 shadow-md shadow-gray-200/60">
                    <div class="mb-5 flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">
                                Filter
                            </p>
                            <h2 class="text-lg font-bold text-gray-900">Kategori Album</h2>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach ($albumCategories as $category)
                            <button type="button"
                                class="group flex w-full items-center justify-between rounded-2xl px-4 py-3 text-left text-sm font-semibold transition duration-300
                                {{ $loop->first
                                    ? 'bg-green-700 text-white shadow-lg shadow-green-700/20 hover:bg-green-800'
                                    : 'border border-gray-200 bg-white text-gray-700 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60' }}">
                                <span>{{ $category['label'] }}</span>
                                <span
                                    class="{{ $loop->first ? 'text-white/80' : 'text-gray-400 group-hover:text-green-700' }}">
                                    {{ $category['count'] }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="300"
                    class="overflow-hidden rounded-[28px] border border-gray-200 bg-white p-5 shadow-md shadow-gray-200/60">
                    <div class="mb-5 flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">
                                Terbaru
                            </p>
                            <h2 class="text-lg font-bold text-gray-900">Album Terbaru</h2>
                        </div>
                    </div>

                    @if ($recentAlbums->isNotEmpty())
                        <div class="space-y-4">
                            @foreach ($recentAlbums as $album)
                                <div
                                    class="group flex gap-4 rounded-2xl bg-white p-3 ring-1 ring-gray-100 transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-green-100/60 hover:ring-green-200">
                                    <img src="{{ $album->cover_image_url ?: asset('img/bg.jpg') }}" alt="{{ $album->title }}"
                                        class="h-20 w-24 shrink-0 rounded-xl object-cover transition duration-300 group-hover:scale-105">

                                    <div class="min-w-0">
                                        <h3
                                            class="line-clamp-2 text-sm font-bold leading-snug text-gray-900 transition group-hover:text-green-700">
                                            {{ $album->title }}
                                        </h3>

                                        <div class="mt-2 space-y-1 text-xs text-gray-500">
                                            <p>{{ $album->category ?: 'Galeri Desa' }}</p>
                                            <p>{{ optional($album->gallery_date)->translatedFormat('d M Y') ?: '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 px-4 py-5 text-sm leading-6 text-gray-500">
                            Belum ada album terbaru yang bisa ditampilkan.
                        </div>
                    @endif
                </div>

                <div data-aos="fade-left" data-aos-delay="400"
                    class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-12 -left-12 h-36 w-36 rounded-full bg-black/10"></div>

                    <div class="relative">
                        <div
                            class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16l4-4a2 2 0 012.828 0L13 15.172l2-2A2 2 0 0117.828 13L21 16M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z" />
                            </svg>
                        </div>

                        <h2 class="text-lg font-bold">Dokumentasi Desa</h2>

                        <p class="mt-3 text-sm leading-6 text-white/85">
                            Galeri membantu masyarakat melihat perkembangan, aktivitas, dan potensi {{ $village->name }} secara visual.
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
