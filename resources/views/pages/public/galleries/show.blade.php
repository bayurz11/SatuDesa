@php
    $metaTitle = $gallery->title . ' | Galeri Desa ' . $village->name;
    $metaDescription = $gallery->excerpt ?: ($gallery->description ?: 'Album dokumentasi kegiatan dan foto publik Desa ' . $village->name . '.');
    $photoItems = $galleryPhotos->map(fn ($photo, $index) => [
        'src' => $photo->image_url,
        'alt' => $photo->alt_text ?: ($gallery->title . ' foto ' . ($index + 1)),
        'caption' => $photo->caption ?: $gallery->title,
    ])->values();
    $coverPreview = $gallery->cover_image_url ?: asset('img/bg.jpg');
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative mt-16 overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-down">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Informasi</li>
                    <li>/</li>
                    <li><a href="{{ route('public.galleries.index') }}" class="transition hover:text-white">Galeri Desa</a></li>
                    <li>/</li>
                    <li class="line-clamp-1 font-semibold text-white">{{ $gallery->title }}</li>
                </ol>
            </nav>

            <div class="mt-6 max-w-4xl" data-aos="fade-up">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex rounded-full bg-white/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-50 ring-1 ring-white/15">
                        Album Dokumentasi
                    </span>
                    <span class="inline-flex rounded-full bg-emerald-300/15 px-4 py-1.5 text-[11px] font-medium text-emerald-50 ring-1 ring-emerald-200/20">
                        {{ $gallery->category ?: 'Galeri Desa' }}
                    </span>
                    <span class="text-sm text-emerald-50/90">{{ $gallery->resolved_photo_count }} foto</span>
                </div>

                <h1 class="mt-5 max-w-4xl text-2xl font-bold tracking-tight text-white sm:text-4xl lg:leading-tight">
                    {{ $gallery->title }}
                </h1>

                <p class="mt-4 max-w-3xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                    {{ $gallery->description ?: ($gallery->excerpt ?: 'Dokumentasi lengkap kegiatan dan momen desa dalam satu album publik.') }}
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-[24px] border border-white/10 bg-white/10 p-5 backdrop-blur-xl">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100/80">Tanggal Kegiatan</p>
                        <p class="mt-2 text-sm font-semibold text-white">{{ optional($gallery->gallery_date)->translatedFormat('d F Y') ?: '-' }}</p>
                    </div>
                    <div class="rounded-[24px] border border-white/10 bg-white/10 p-5 backdrop-blur-xl">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100/80">Lokasi</p>
                        <p class="mt-2 text-sm font-semibold text-white">{{ $gallery->location_name ?: $village->name }}</p>
                    </div>
                    <div class="rounded-[24px] border border-white/10 bg-white/10 p-5 backdrop-blur-xl">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-100/80">Total Foto</p>
                        <p class="mt-2 text-sm font-semibold text-white">{{ $gallery->resolved_photo_count }} dokumentasi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <main class="space-y-8">
                <article class="overflow-hidden rounded-[32px] border border-gray-200 bg-white shadow-xl shadow-gray-200/70" data-aos="fade-up">
                    <div class="relative aspect-[16/9] overflow-hidden bg-gray-100">
                        <img src="{{ $coverPreview }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white sm:p-8">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/85">{{ $gallery->category ?: 'Galeri Desa' }}</p>
                            <h2 class="mt-3 text-2xl font-bold sm:text-3xl">{{ $gallery->title }}</h2>
                            @if ($gallery->excerpt)
                                <p class="mt-3 max-w-3xl text-sm leading-7 text-white/85">{{ $gallery->excerpt }}</p>
                            @endif
                        </div>
                    </div>
                </article>

                <section class="rounded-[32px] border border-gray-200 bg-white p-5 shadow-lg shadow-gray-200/60 sm:p-7" data-aos="fade-up" data-aos-delay="80">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-[0.24em] text-green-700">Seluruh Foto</span>
                            <h2 class="mt-2 text-2xl font-bold text-gray-900">Dokumentasi Kegiatan</h2>
                            <p class="mt-3 text-sm leading-7 text-gray-600">
                                Klik salah satu foto untuk membuka tampilan penuh dan lihat seluruh dokumentasi kegiatan dalam lightbox.
                            </p>
                        </div>
                        <div class="inline-flex items-center rounded-full bg-green-50 px-4 py-2 text-sm font-semibold text-green-800 ring-1 ring-green-100">
                            {{ $photoItems->count() }} foto tersedia
                        </div>
                    </div>

                    @if ($photoItems->isNotEmpty())
                        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach ($photoItems as $photo)
                                <button type="button"
                                    class="gallery-lightbox-trigger group relative overflow-hidden rounded-[24px] border border-gray-200 bg-gray-100 text-left shadow-sm transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-xl hover:shadow-green-100/60"
                                    data-gallery-src="{{ $photo['src'] }}"
                                    data-gallery-alt="{{ $photo['alt'] }}"
                                    data-gallery-caption="{{ $photo['caption'] }}">
                                    <div class="aspect-[4/3] overflow-hidden">
                                        <img src="{{ $photo['src'] }}" alt="{{ $photo['alt'] }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                    </div>
                                    <div class="p-4">
                                        <p class="line-clamp-2 text-sm font-semibold leading-6 text-gray-900">{{ $photo['caption'] }}</p>
                                        <p class="mt-2 text-xs font-semibold uppercase tracking-[0.18em] text-green-700">Klik untuk perbesar</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-8 rounded-[28px] border border-dashed border-green-200 bg-gradient-to-br from-green-50 to-white p-8 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-green-700 ring-1 ring-green-100 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16l4-4a2 2 0 012.828 0L13 15.172l2-2A2 2 0 0117.828 13L21 16M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z" />
                                </svg>
                            </div>
                            <h3 class="mt-5 text-xl font-bold text-gray-900">Foto Album Belum Tersedia</h3>
                            <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                                Album ini sudah tampil di publik, tetapi foto kegiatannya belum ditambahkan dari admin.
                            </p>
                        </div>
                    @endif
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60" data-aos="fade-left">
                    <h2 class="text-lg font-bold text-gray-900">Ringkasan Album</h2>
                    <div class="mt-5 space-y-4 text-sm">
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-4">
                            <p class="font-semibold text-emerald-700">Kategori</p>
                            <p class="mt-2 text-emerald-950">{{ $gallery->category ?: 'Galeri Desa' }}</p>
                        </div>
                        <div class="rounded-2xl border border-sky-100 bg-sky-50 px-4 py-4">
                            <p class="font-semibold text-sky-700">Lokasi</p>
                            <p class="mt-2 text-sky-950">{{ $gallery->location_name ?: $village->name }}</p>
                        </div>
                        <div class="rounded-2xl border border-amber-100 bg-amber-50 px-4 py-4">
                            <p class="font-semibold text-amber-700">Dipublikasikan</p>
                            <p class="mt-2 text-amber-950">{{ optional($gallery->published_at)->translatedFormat('d F Y') ?: '-' }}</p>
                        </div>
                    </div>
                </div>

                @if ($relatedAlbums->isNotEmpty())
                    <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60" data-aos="fade-left" data-aos-delay="100">
                        <h2 class="text-lg font-bold text-gray-900">Album Lainnya</h2>
                        <div class="mt-5 space-y-4">
                            @foreach ($relatedAlbums as $relatedAlbum)
                                <a href="{{ route('public.galleries.show', $relatedAlbum->slug) }}"
                                    class="group flex gap-4 rounded-2xl bg-white p-3 ring-1 ring-gray-100 transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-green-100/60 hover:ring-green-200">
                                    <img src="{{ $relatedAlbum->cover_image_url ?: asset('img/bg.jpg') }}" alt="{{ $relatedAlbum->title }}"
                                        class="h-20 w-24 shrink-0 rounded-xl object-cover transition duration-300 group-hover:scale-105">
                                    <div class="min-w-0">
                                        <h3 class="line-clamp-2 text-sm font-bold leading-snug text-gray-900 transition group-hover:text-green-700">
                                            {{ $relatedAlbum->title }}
                                        </h3>
                                        <div class="mt-2 space-y-1 text-xs text-gray-500">
                                            <p>{{ $relatedAlbum->category ?: 'Galeri Desa' }}</p>
                                            <p>{{ $relatedAlbum->resolved_photo_count }} foto</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20" data-aos="fade-left" data-aos-delay="180">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-12 -left-12 h-36 w-36 rounded-full bg-black/10"></div>
                    <div class="relative">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16l4-4a2 2 0 012.828 0L13 15.172l2-2A2 2 0 0117.828 13L21 16M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold">Lihat Dokumentasi Lengkap</h2>
                        <p class="mt-3 text-sm leading-6 text-white/85">
                            Setiap album galeri kini menampilkan seluruh foto kegiatan agar warga dan pengunjung bisa melihat dokumentasi secara utuh.
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <dialog id="galleryLightbox" class="m-0 h-screen w-screen max-h-none max-w-none border-0 bg-black/90 p-0 text-left backdrop:bg-black/90">
        <div class="mx-auto flex h-full max-w-6xl flex-col justify-center px-4 py-6 sm:px-6">
            <div class="mb-4 flex items-center justify-between gap-4 text-white">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/70">Preview Foto</p>
                    <p id="galleryLightboxCaption" class="mt-1 text-sm font-medium text-white/90"></p>
                </div>
                <button type="button" id="galleryLightboxClose"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white transition hover:bg-white/20">
                    <span class="sr-only">Tutup</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="relative overflow-hidden rounded-[28px] bg-white/5 ring-1 ring-white/10">
                <img id="galleryLightboxImage" src="" alt="" class="max-h-[78vh] w-full object-contain bg-black/20">
                <button type="button" id="galleryLightboxPrev"
                    class="absolute left-3 top-1/2 inline-flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-black/35 text-white transition hover:bg-black/55">
                    <span class="sr-only">Foto sebelumnya</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button type="button" id="galleryLightboxNext"
                    class="absolute right-3 top-1/2 inline-flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-black/35 text-white transition hover:bg-black/55">
                    <span class="sr-only">Foto berikutnya</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5 15.75 12l-7.5 7.5" />
                    </svg>
                </button>
            </div>
        </div>
    </dialog>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const triggers = Array.from(document.querySelectorAll('.gallery-lightbox-trigger'));
            const lightbox = document.getElementById('galleryLightbox');
            const image = document.getElementById('galleryLightboxImage');
            const caption = document.getElementById('galleryLightboxCaption');
            const closeButton = document.getElementById('galleryLightboxClose');
            const prevButton = document.getElementById('galleryLightboxPrev');
            const nextButton = document.getElementById('galleryLightboxNext');

            if (!lightbox || !image || triggers.length === 0) {
                return;
            }

            const items = triggers.map((trigger) => ({
                src: trigger.dataset.gallerySrc,
                alt: trigger.dataset.galleryAlt || '',
                caption: trigger.dataset.galleryCaption || '',
            }));

            let activeIndex = 0;

            const render = () => {
                const item = items[activeIndex];

                image.src = item.src;
                image.alt = item.alt;
                caption.textContent = item.caption;
            };

            const open = (index) => {
                activeIndex = index;
                render();
                document.body.classList.add('overflow-hidden');
                if (typeof lightbox.showModal === 'function') {
                    lightbox.showModal();
                } else {
                    lightbox.setAttribute('open', 'open');
                }
            };

            const close = () => {
                document.body.classList.remove('overflow-hidden');
                if (typeof lightbox.close === 'function') {
                    lightbox.close();
                } else {
                    lightbox.removeAttribute('open');
                }
            };

            const showPrev = () => {
                activeIndex = activeIndex === 0 ? items.length - 1 : activeIndex - 1;
                render();
            };

            const showNext = () => {
                activeIndex = activeIndex === items.length - 1 ? 0 : activeIndex + 1;
                render();
            };

            triggers.forEach((trigger, index) => {
                trigger.addEventListener('click', () => open(index));
            });

            closeButton?.addEventListener('click', close);
            prevButton?.addEventListener('click', showPrev);
            nextButton?.addEventListener('click', showNext);

            lightbox.addEventListener('click', (event) => {
                const bounds = lightbox.getBoundingClientRect();
                const clickedOutside =
                    event.clientX < bounds.left ||
                    event.clientX > bounds.right ||
                    event.clientY < bounds.top ||
                    event.clientY > bounds.bottom;

                if (event.target === lightbox || clickedOutside) {
                    close();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (!lightbox.hasAttribute('open')) {
                    return;
                }

                if (event.key === 'Escape') {
                    close();
                }

                if (event.key === 'ArrowLeft') {
                    showPrev();
                }

                if (event.key === 'ArrowRight') {
                    showNext();
                }
            });

            lightbox.addEventListener('close', () => {
                document.body.classList.remove('overflow-hidden');
            });
        });
    </script>
@endpush
