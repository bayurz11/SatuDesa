@extends('layouts.app2')

@section('title', ($item->title ?? 'Berita') . ' — Berita Desa')

@section('content')
    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Carbon;

        // ====== Sumber data dari model Post ======
        $title = $item->title ?? 'Berita';
        $categoryName = optional($item->category)->name ?? 'Tidak berkategori';

        // 🔽 Cover: cek file di public/storage, fallback ke default
        $coverPath = ltrim($item->cover_path ?? '', '/');
        $coverFile = public_path('public/storage/' . $coverPath); // public_path sudah mengarah ke /public
        $cover =
            !empty($coverPath) && file_exists($coverFile)
                ? asset('public/storage/' . $coverPath)
                : asset('public/storage/' . $item->cover_path);

        $publishedAt = $item->published_at ?? $item->created_at;
        $author = $item->author_name ?: optional($item->creator)->name ?: 'Admin';
        $editorName = optional($item->editor)->name; // relasi editor() jika ada
        $updatedAt = $item->updated_at ?? null;

        // Estimasi menit baca: pakai read_minutes kalau ada; jika tidak, hitung ~200 kata/menit
        $readMinutes =
            $item->read_minutes ?? max(1, (int) ceil(str_word_count(strip_tags($item->body_html ?? '')) / 200));

        // Tags: ambil sampai 5
        $tags = $item->relationLoaded('tags') ? $item->tags->pluck('name')->take(5) : collect();
    @endphp

    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="#" class="hover:text-green-700">Informasi</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="{{ route('berita') }}" class="hover:text-green-700">Berita</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium line-clamp-1">{{ $title }}</li>
            </ol>
        </nav>

        {{-- HERO / Featured Cover --}}
        <article class="relative overflow-hidden rounded-2xl shadow ring-1 ring-black/5 group">
            <figure class="h-[320px] md:h-[420px] overflow-hidden">
                <img src="{{ $cover }}" alt="{{ $title }}"
                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.02]"
                    loading="lazy" decoding="async">
            </figure>

            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-black/25 to-transparent">
            </div>

            <div class="absolute inset-x-0 bottom-0 p-5 md:p-6">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-white/95 px-2.5 py-1 text-xs font-medium text-green-700 ring-1 ring-black/5">
                        <x-heroicon-o-tag class="size-4" /> {{ $categoryName }}
                    </span>
                    @if ($publishedAt)
                        <time
                            class="inline-flex items-center gap-1 rounded-full bg-black/50 px-2.5 py-1 text-xs text-white">
                            <x-heroicon-o-clock class="size-4" />
                            {{ Carbon::parse($publishedAt)->translatedFormat('d M Y') }}
                        </time>
                    @endif
                    @if ($readMinutes)
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-black/50 px-2.5 py-1 text-xs text-white">
                            <x-heroicon-o-book-open class="size-4" /> {{ $readMinutes }} menit baca
                        </span>
                    @endif
                </div>

                <h1 class="text-white text-2xl md:text-3xl font-extrabold leading-snug drop-shadow">
                    {{ $title }}
                </h1>

                @if (!blank($item->summary))
                    <p class="mt-2 text-white/90 line-clamp-2">{{ $item->summary }}</p>
                @endif
            </div>
        </article>

        <div class="grid gap-8 md:gap-10 lg:grid-cols-3 items-start mt-8">
            {{-- KONTEN UTAMA --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Meta atas --}}
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                    <span class="inline-flex items-center gap-2">
                        <x-heroicon-o-user class="size-5 text-green-700" /> {{ $author }}
                    </span>
                    @if ($publishedAt)
                        <span class="inline-flex items-center gap-2">
                            <x-heroicon-o-calendar class="size-5 text-green-700" />
                            {{ Carbon::parse($publishedAt)->translatedFormat('d F Y, H:i') }} WIB
                        </span>
                    @endif
                    @if ($updatedAt)
                        <span class="inline-flex items-center gap-2">
                            <x-heroicon-o-pencil-square class="size-5 text-green-700" />
                            Diperbarui {{ Carbon::parse($updatedAt)->diffForHumans() }}
                            @if ($editorName)
                                oleh {{ $editorName }}
                            @endif
                        </span>
                    @endif
                </div>

                {{-- Tag --}}
                @if ($tags->count())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($tags as $t)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700 ring-1 ring-emerald-200">
                                #{{ $t }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Isi Berita --}}
                <section class="rounded-2xl bg-white shadow ring-1 ring-black/5 p-6 md:p-8">
                    <div class="prose max-w-none">
                        {!! $item->body_html !!}
                    </div>

                    {{-- Share / Print (dummy) --}}
                    <div class="mt-6 flex flex-wrap gap-2">
                        <a href="#"
                            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                            <x-heroicon-o-share class="size-4" /> Bagikan
                        </a>
                        <a href="#"
                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                            <x-heroicon-o-printer class="size-4" /> Cetak
                        </a>
                    </div>
                </section>

                {{-- Navigasi Sebelumnya / Berikutnya (opsional: diisi dari controller) --}}
                @php
                    // Contoh pencarian prev/next sederhana (berdasarkan published_at)
                    $prev = \App\Domains\Post\Models\Post::query()
                        ->where('content_type', 'news')
                        ->published()
                        ->where('published_at', '<', $publishedAt)
                        ->orderByDesc('published_at')
                        ->first();

                    $next = \App\Domains\Post\Models\Post::query()
                        ->where('content_type', 'news')
                        ->published()
                        ->where('published_at', '>', $publishedAt)
                        ->orderBy('published_at')
                        ->first();
                @endphp
                <nav class="flex items-center justify-between text-sm">
                    <a href="{{ $prev ? route('berita.show', $prev->slug) : '#' }}"
                        class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 {{ $prev ? '' : 'opacity-50 pointer-events-none' }}">
                        <x-heroicon-o-arrow-left class="size-4" /> Berita sebelumnya
                    </a>
                    <a href="{{ $next ? route('berita.show', $next->slug) : '#' }}"
                        class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 {{ $next ? '' : 'opacity-50 pointer-events-none' }}">
                        Berita berikutnya <x-heroicon-o-arrow-right class="size-4" />
                    </a>
                </nav>
            </div>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                {{-- Info Ringkas --}}
                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-3">Ringkasan</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-tag class="h-4 w-4 text-green-700" /> {{ $categoryName }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-user class="h-4 w-4 text-green-700" /> {{ $author }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-clock class="h-4 w-4 text-green-700" /> {{ $readMinutes }} menit baca
                        </li>
                    </ul>
                </div>

                {{-- Terbaru (pakai $related dari route; fallback ambil 3 terbaru) --}}
                @php
                    $latestList =
                        isset($related) && $related instanceof \Illuminate\Support\Collection && $related->count()
                            ? $related
                            : \App\Domains\Post\Models\Post::query()
                                ->news()
                                ->published()
                                ->orderByDesc('published_at')
                                ->take(3)
                                ->get();
                @endphp
                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <h4 class="font-semibold text-gray-900 mb-3">Terbaru</h4>
                    <div class="space-y-3">
                        @foreach ($latestList as $lp)
                            @php
                                $ldate = $lp->published_at ?? $lp->created_at;
                                $lcat = optional($lp->category)->name ?? 'Tidak berkategori';
                            @endphp
                            <a href="{{ route('berita.show', $lp->slug) }}"
                                class="flex items-center gap-3 rounded-lg p-2 hover:bg-gray-50 transition">
                                <img src="{{ $lp->cover_url }}" alt="Thumb {{ $lp->title }}"
                                    class="h-16 w-20 rounded-md object-cover ring-1 ring-black/5" loading="lazy"
                                    decoding="async">
                                <div class="min-w-0">
                                    <h5 class="text-sm font-medium text-gray-900 line-clamp-2 hover:text-green-700">
                                        {{ $lp->title }}
                                    </h5>
                                    <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                        <span class="inline-flex items-center gap-1">
                                            <x-heroicon-o-tag class="size-4" /> {{ $lcat }}
                                        </span>
                                        <time class="inline-flex items-center gap-1">
                                            <x-heroicon-o-clock class="size-4" />
                                            {{ optional($ldate)->translatedFormat('d-m-Y') }}
                                        </time>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>

        {{-- Berita Terkait --}}
        @if (isset($related) && $related->count())
            <section class="mt-10 md:mt-14">
                <h3 class="text-lg md:text-xl font-semibold text-gray-900">Berita Terkait</h3>
                <div class="mx-auto my-4 h-1 w-20 rounded-full bg-green-600"></div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $rp)
                        @php
                            $rDate = $rp->published_at ?? $rp->created_at;
                            $rcat = optional($rp->category)->name ?? 'Berita';
                        @endphp
                        <a href="{{ route('berita.show', $rp->slug) }}"
                            class="group rounded-2xl bg-white shadow ring-1 ring-black/5 overflow-hidden">
                            <div class="aspect-[16/9] bg-gray-100">
                                <img src="{{ $rp->cover_url }}" alt="{{ $rp->title }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale"
                                    loading="lazy" decoding="async">
                            </div>
                            <div class="p-4">
                                <div class="mb-1 flex flex-wrap items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                        <x-heroicon-o-tag class="size-4" /> {{ $rcat }}
                                    </span>
                                    <time class="inline-flex items-center gap-1 text-[11px] text-gray-500">
                                        <x-heroicon-o-clock class="size-4" />
                                        {{ optional($rDate)->translatedFormat('d M Y') }}
                                    </time>
                                </div>
                                <h4 class="text-sm md:text-base font-semibold text-gray-900 line-clamp-2">
                                    {{ $rp->title }}
                                </h4>
                                @if (!blank($rp->summary))
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ Str::limit($rp->summary, 110) }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {});
    </script>
@endpush
