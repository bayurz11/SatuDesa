@extends('layouts.app2')

@section('title', 'Galeri Desa ')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-6 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Dokumentasi</li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Galeri</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <header class="text-center mb-8 md:mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">Galeri Desa Mentuda</h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Dokumentasi kegiatan, budaya, dan momen penting di Desa Mentuda.
            </p>
        </header>

        {{-- Filter (placeholder) --}}
        <div class="mb-8 flex flex-wrap items-center justify-center gap-2">
            @foreach (['Semua', 'Kegiatan', 'Budaya', 'Lingkungan', 'UMKM'] as $cat)
                <a href="#"
                    class="px-3 py-1.5 rounded-full text-sm border {{ $cat === 'Semua' ? 'bg-green-600 border-green-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- Grid Galeri --}}
        @php
            $items = [
                [
                    'src' => 'https://pagedone.io/asset/uploads/1713942989.png',
                    'alt' => 'Kegiatan masyarakat',
                    'cap' => 'Kegiatan masyarakat',
                ],
                [
                    'src' => 'https://pagedone.io/asset/uploads/1713943004.png',
                    'alt' => 'Ruang publik & acara desa',
                    'cap' => 'Ruang publik & acara desa',
                ],
                [
                    'src' => 'https://pagedone.io/asset/uploads/1713943024.png',
                    'alt' => 'Budaya desa',
                    'cap' => 'Budaya desa',
                ],
                [
                    'src' => 'https://pagedone.io/asset/uploads/1713943039.png',
                    'alt' => 'Lingkungan & kebersihan',
                    'cap' => 'Lingkungan & kebersihan',
                ],
                [
                    'src' => 'https://pagedone.io/asset/uploads/1713943054.png',
                    'alt' => 'UMKM & ekonomi',
                    'cap' => 'UMKM & ekonomi',
                ],
            ];
        @endphp

        <div class="grid gap-6 md:grid-cols-12">
            {{-- Kolom kiri --}}
            <figure class="md:col-span-4 rounded-2xl overflow-hidden bg-white shadow ring-1 ring-black/5 group">
                <img src="{{ $items[0]['src'] }}" alt="{{ $items[0]['alt'] }}"
                    class="h-[280px] md:h-[380px] w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale cursor-zoom-in"
                    loading="lazy" decoding="async" data-gallery-index="0">
                <figcaption class="p-3 text-xs text-gray-500">{{ $items[0]['cap'] }}</figcaption>
            </figure>

            {{-- Kolom kanan besar --}}
            <figure class="md:col-span-8 rounded-2xl overflow-hidden bg-white shadow ring-1 ring-black/5 group">
                <img src="{{ $items[1]['src'] }}" alt="{{ $items[1]['alt'] }}"
                    class="h-[280px] md:h-[380px] w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale cursor-zoom-in"
                    loading="lazy" decoding="async" data-gallery-index="1">
                <figcaption class="p-3 text-xs text-gray-500">{{ $items[1]['cap'] }}</figcaption>
            </figure>
        </div>

        <div class="mt-6 grid gap-6 md:grid-cols-3">
            @foreach ([$items[2], $items[3], $items[4]] as $i => $it)
                <figure class="rounded-2xl overflow-hidden bg-white shadow ring-1 ring-black/5 group">
                    <img src="{{ $it['src'] }}" alt="{{ $it['alt'] }}"
                        class="h-[240px] w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale cursor-zoom-in"
                        loading="lazy" decoding="async" data-gallery-index="{{ $i + 2 }}">
                    <figcaption class="p-3 text-xs text-gray-500">{{ $it['cap'] }}</figcaption>
                </figure>
            @endforeach
        </div>

        {{-- Pagination (placeholder) --}}
        <div class="mt-10 flex justify-center">
            <nav class="inline-flex space-x-2 text-sm" aria-label="Pagination">
                <a href="#"
                    class="px-3 py-1 rounded-lg border border-gray-300 text-gray-600 hover:bg-green-600 hover:text-white transition"
                    aria-label="Sebelumnya">«</a>
                <a href="#" class="px-3 py-1 rounded-lg border border-green-600 bg-green-600 text-white"
                    aria-current="page">1</a>
                <a href="#"
                    class="px-3 py-1 rounded-lg border border-gray-300 text-gray-600 hover:bg-green-600 hover:text-white transition">2</a>
                <a href="#"
                    class="px-3 py-1 rounded-lg border border-gray-300 text-gray-600 hover:bg-green-600 hover:text-white transition"
                    aria-label="Berikutnya">»</a>
            </nav>
        </div>

        {{-- Lightbox --}}
        <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm"
            aria-hidden="true" role="dialog" aria-modal="true">
            {{-- Close --}}
            <button id="lb-close" type="button"
                class="absolute right-4 top-4 inline-flex items-center justify-center rounded-full bg-white/10 p-2 text-white hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Previous --}}
            <button id="lb-prev" type="button"
                class="absolute left-4 md:left-6 inline-flex items-center justify-center rounded-full bg-white/10 p-2 text-white hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                aria-label="Sebelumnya">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            {{-- Next --}}
            <button id="lb-next" type="button"
                class="absolute right-4 md:right-6 inline-flex items-center justify-center rounded-full bg-white/10 p-2 text-white hover:bg-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                aria-label="Berikutnya">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>

            {{-- Counter --}}
            <div id="lb-counter"
                class="absolute bottom-4 md:bottom-6 left-1/2 -translate-x-1/2 text-white/90 text-xs px-2 py-1 rounded bg-white/10 ring-1 ring-white/20">
            </div>

            <img id="lb-img" src="" alt="Pratayang gambar"
                class="max-h-[85vh] max-w-[92vw] object-contain rounded-xl shadow-2xl ring-1 ring-white/20" />
        </div>
    </section>

    {{-- Lightbox Script (aksesibel, keyboard-friendly) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Kumpulkan gambar di grid
            const gallery = Array.from(document.querySelectorAll('[data-gallery-index]'))
                .map((img, i) => ({
                    el: img,
                    src: img.src,
                    alt: img.alt || 'Pratayang gambar',
                    i
                }));

            const lb = document.getElementById('lightbox');
            const imgEl = document.getElementById('lb-img');
            const btnClose = document.getElementById('lb-close');
            const btnPrev = document.getElementById('lb-prev');
            const btnNext = document.getElementById('lb-next');
            const counter = document.getElementById('lb-counter');

            let idx = 0;
            let lastFocused = null;

            const updateCounter = () => {
                counter.textContent = `${idx + 1} / ${gallery.length}`;
            };

            const show = (i) => {
                idx = (i + gallery.length) % gallery.length;
                const item = gallery[idx];
                imgEl.src = item.src;
                imgEl.alt = item.alt;
                updateCounter();
            };

            const open = (i = 0) => {
                lastFocused = document.activeElement;
                show(i);
                lb.classList.remove('hidden');
                lb.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');
                // fokuskan tombol tutup demi aksesibilitas
                btnClose.focus();
            };

            const close = () => {
                lb.classList.add('hidden');
                lb.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
                imgEl.src = '';
                if (lastFocused && lastFocused.focus) lastFocused.focus();
            };

            // Binding click & keyboard pada thumbnail
            gallery.forEach(({
                el,
                i
            }) => {
                el.setAttribute('tabindex', '0');
                el.addEventListener('click', () => open(i));
                el.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        open(i);
                    }
                });
            });

            // Navigasi di lightbox
            btnClose.addEventListener('click', close);
            btnPrev.addEventListener('click', () => show(idx - 1));
            btnNext.addEventListener('click', () => show(idx + 1));
            lb.addEventListener('click', (e) => {
                if (e.target === lb) close();
            });

            window.addEventListener('keydown', (e) => {
                if (lb.classList.contains('hidden')) return;
                if (e.key === 'Escape') close();
                if (e.key === 'ArrowRight') show(idx + 1);
                if (e.key === 'ArrowLeft') show(idx - 1);
            });

            // Preload gambar berikutnya untuk transisi lebih halus
            const preloadNext = () => {
                const nextIdx = (idx + 1) % gallery.length;
                const link = document.createElement('link');
                link.rel = 'prefetch';
                link.href = gallery[nextIdx].src;
                document.head.appendChild(link);
            };
            imgEl.addEventListener('load', preloadNext);
        });
    </script>
@endsection
