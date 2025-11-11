@extends('layouts.app2')

@section('title', ($post->title ?? 'Potensi Desa') . ' — Potensi')

@section('content')
    @php
        use Illuminate\Support\Str;

        /** @var \App\Domains\Post\Models\Post $item */
        $post = $item;

        $cover = $post?->cover_url ?? asset('public/img/potensi1.jpg');
        $kategori = $post?->potensi_category ?: optional($post?->category)->name ?: 'Potensi';

        $tags = collect();
        if ($post) {
            $tags = $post->relationLoaded('tags') ? $post->tags->pluck('name') : $post->tags()->pluck('name');
            $tags = $tags->filter()->unique()->values();
        }

        $gallery = collect(data_get($post, 'meta.gallery', []))
            ->filter()
            ->map(fn($g) => Str::startsWith($g, ['http://', 'https://']) ? $g : asset($g))
            ->take(12);

        $lokasi = $post?->address ?: 'Desa Mentuda, Lingga, Kepulauan Riau';

        $embedMap =
            $post?->map_embed_url ?:
            (filled($lokasi)
                ? '<iframe src="https://maps.google.com/maps?q=' .
                    urlencode($lokasi) .
                    '&t=&z=13&ie=UTF8&iwloc=&output=embed" class="w-full h-full border-0" loading="lazy"></iframe>'
                : null);

        $stat1 = data_get($post, 'meta.estimasi_produksi');
        $stat1_unit = data_get($post, 'meta.estimasi_satuan', 'ton/tahun');
        $stat2 = data_get($post, 'meta.pelaku_umkm');
        $stat3 = data_get($post, 'meta.luas_lahan');

        $deskripsiHtml = filled($post?->body_html) ? $post->body_html : e($post?->summary);

        $fmtRp = fn($n) => is_numeric($n) ? 'Rp ' . number_format($n, 0, ',', '.') : $n;

        $rentangHarga = null;
        if (!is_null($post?->price_min) || !is_null($post?->price_max)) {
            $min = $post?->price_min !== null ? $fmtRp($post->price_min) : null;
            $max = $post?->price_max !== null ? $fmtRp($post->price_max) : null;
            $rentangHarga = trim(($min ?? '') . ($min && $max ? ' — ' : '') . ($max ?? ''));
        }

        $detailBase = array_filter(
            [
                'Kategori' => $kategori,
                'Alamat' => $post?->address,
                'Koordinat' => $post?->hasCoordinates() ? $post->latitude . ', ' . $post->longitude : null,
                'Kontak' => trim(
                    ($post?->contact_name ? $post->contact_name . ' — ' : '') . ($post->contact_phone ?? ''),
                ),
                'Rentang Harga' => $rentangHarga,
                'Tautan Eksternal' => $post?->external_link,
            ],
            fn($v) => filled($v),
        );

        $detailMeta = (array) data_get($post, 'meta.detail', []);
        $detail = array_filter(array_merge($detailBase, $detailMeta), fn($v) => filled($v));

        $updatedAt = $post?->updated_at;

        // ✅ responsive srcset helper untuk cover (gunakan ukuran gambar kamu bila ada)
        $coverSrcSet = implode(', ', [$cover . ' 800w', $cover . ' 1200w', $cover . ' 1600w']);
    @endphp

    <section class="mx-auto max-w-7xl px-3 sm:px-4 md:px-6 lg:px-8 py-8 sm:py-10 md:py-14" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav class="mb-5 sm:mb-6 md:mb-8 text-xs sm:text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="#" class="hover:text-green-700">Informasi</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="{{ route('potensi-desa') }}" class="hover:text-green-700">Potensi Desa</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium line-clamp-1 max-w-[60vw] sm:max-w-none">{{ $post->title }}</li>
            </ol>
        </nav>

        {{-- HERO --}}
        <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
            <div class="grid md:grid-cols-12 gap-0">
                <figure class="order-1 md:order-none md:col-span-7 h-48 sm:h-56 md:h-80 lg:h-[420px] overflow-hidden">
                    <img src="{{ $cover }}" srcset="{{ $coverSrcSet }}"
                        sizes="(min-width:1024px) 60vw, (min-width:768px) 65vw, 100vw" {{-- ✅ responsive sizes --}}
                        alt="{{ $post->title }}" class="h-full w-full object-cover select-none" loading="eager"
                        fetchpriority="high" decoding="async">
                </figure>

                <div class="md:col-span-5 p-4 sm:p-6 md:p-8 flex flex-col justify-center">
                    <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 sm:px-2.5 text-[10px] sm:text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                            <x-heroicon-o-tag class="size-4" /> {{ $kategori }}
                        </span>
                        @foreach ($tags as $t)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-1 sm:px-2.5 text-[10px] sm:text-[11px] font-medium text-emerald-700 ring-1 ring-emerald-200">#{{ $t }}</span>
                        @endforeach
                    </div>

                    <h1 class="mt-2 sm:mt-3 text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-gray-900">
                        {{ $post->title }}
                    </h1>
                    @if (filled($post->summary))
                        <p class="mt-1 text-gray-600 text-sm sm:text-base leading-relaxed">{{ $post->summary }}</p>
                    @endif

                    <div class="mt-3 sm:mt-4 flex flex-wrap items-center gap-2 sm:gap-3 text-xs sm:text-sm text-gray-600">
                        <span class="inline-flex items-center gap-1.5 sm:gap-2">
                            <x-heroicon-o-map-pin class="size-4 text-green-700" /> {{ $lokasi }}
                        </span>
                        @if ($updatedAt)
                            <span class="inline-flex items-center gap-1.5 sm:gap-2">
                                <x-heroicon-o-clock class="size-4 text-green-700" />
                                Diperbarui {{ \Illuminate\Support\Carbon::parse($updatedAt)->diffForHumans() }}
                            </span>
                        @endif
                    </div>

                    {{-- CTA atas --}}
                    <div class="mt-4 sm:mt-5 flex flex-col sm:flex-row gap-2 motion-reduce:transition-none">
                        <a href="#informasi"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700 transition">
                            <x-heroicon-o-information-circle class="size-5" /> Lihat Informasi
                        </a>
                        <a href="{{ route('potensi-desa') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium
                              bg-green-600 text-white hover:bg-green-700 transition
                              md:bg-transparent md:text-green-700 md:hover:text-white md:border md:border-green-600 md:hover:bg-green-600">
                            <x-heroicon-o-arrow-left class="size-5" /> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 sm:gap-8 lg:grid-cols-3 items-start mt-6 sm:mt-8">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-6 sm:space-y-8">
                {{-- Ringkasan Angka --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                    <div class="rounded-xl bg-green-50/60 p-3 sm:p-4 ring-1 ring-green-200">
                        <p class="text-[10px] sm:text-xs text-gray-600">Estimasi Produksi</p>
                        <p class="mt-0.5 font-semibold text-gray-900 text-lg sm:text-xl md:text-2xl">
                            @if (!is_null($stat1))
                                {{ is_numeric($stat1) ? number_format($stat1) : $stat1 }}
                                <span class="text-xs sm:text-sm font-medium text-gray-600">{{ $stat1_unit }}</span>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </p>
                    </div>
                    <div class="rounded-xl bg-emerald-50/60 p-3 sm:p-4 ring-1 ring-emerald-200">
                        <p class="text-[10px] sm:text-xs text-gray-600">Pelaku UMKM</p>
                        <p class="mt-0.5 font-semibold text-gray-900 text-lg sm:text-xl md:text-2xl">
                            {{ !is_null($stat2) ? number_format($stat2) : '—' }}
                        </p>
                    </div>
                    <div class="rounded-xl bg-lime-50/60 p-3 sm:p-4 ring-1 ring-lime-200 hidden sm:block">
                        <p class="text-[10px] sm:text-xs text-gray-600">Luas Lahan</p>
                        <p class="mt-0.5 font-semibold text-gray-900 text-lg sm:text-xl md:text-2xl">
                            @if (!is_null($stat3))
                                {{ is_numeric($stat3) ? number_format($stat3, 2) : $stat3 }} <span
                                    class="text-xs sm:text-sm text-gray-600">ha</span>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Informasi Utama --}}
                <section id="informasi"
                    class="scroll-mt-24 rounded-2xl bg-white shadow ring-1 ring-black/5 p-4 sm:p-6 md:p-8">
                    <h2 class="text-lg sm:text-xl md:text-2xl font-semibold text-gray-900">Deskripsi</h2>
                    <div class="mx-auto my-3 sm:my-4 h-1 w-16 sm:w-20 rounded-full bg-green-600"></div>
                    <div class="prose prose-sm sm:prose base max-w-none">
                        {!! filled($deskripsiHtml)
                            ? $deskripsiHtml
                            : '<p class="text-gray-600">Belum ada deskripsi terperinci untuk potensi ini.</p>' !!}
                    </div>

                    {{-- Detail Tabel Kunci --}}
                    @if (!empty($detail))
                        <div class="mt-5 sm:mt-6 overflow-hidden rounded-xl ring-1 ring-gray-200">
                            <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($detail as $k => $v)
                                        <tr class="align-top">
                                            <th
                                                class="w-40 sm:w-48 bg-gray-50 px-3 sm:px-4 py-2.5 sm:py-3 text-left font-medium text-gray-700">
                                                {{ $k }}</th>
                                            <td class="px-3 sm:px-4 py-2.5 sm:py-3 text-gray-800">
                                                @if ($k === 'Tautan Eksternal' && filled($v))
                                                    <a href="{{ $v }}" target="_blank" rel="noopener noreferrer"
                                                        class="text-green-700 hover:text-green-800 underline break-words">{{ $v }}</a>
                                                @else
                                                    <span
                                                        class="break-words">{{ is_array($v) ? implode(', ', $v) : $v }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>

                {{-- Galeri --}}
                @if ($gallery->count())
                    @php
                        // siapkan srcset per item (pakai URL yang sama untuk contoh; idealnya sediakan variasi resolusi)
                        $sizes = '(min-width:1024px) 320px, (min-width:640px) 33vw, 50vw';
                    @endphp
                    <section class="rounded-2xl bg-white shadow ring-1 ring-black/5 p-4 sm:p-6 md:p-8"
                        x-data="{ open: false, img: '', lastFocus: null }" aria-labelledby="galeri-heading">
                        <h3 id="galeri-heading" class="text-base sm:text-lg md:text-xl font-semibold text-gray-900">Galeri
                        </h3>
                        <div class="mx-auto my-3 sm:my-4 h-1 w-16 sm:w-20 rounded-full bg-green-600"></div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 sm:gap-3">
                            @foreach ($gallery as $g)
                                <button type="button"
                                    class="group relative aspect-[4/3] overflow-hidden rounded-xl ring-1 ring-black/5 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-600"
                                    @click="lastFocus = $event.currentTarget; open = true; img='{{ $g }}'"
                                    aria-haspopup="dialog" aria-controls="galeri-modal" aria-label="Buka gambar">
                                    <img src="{{ $g }}"
                                        srcset="{{ $g }} 640w, {{ $g }} 960w, {{ $g }} 1280w"
                                        sizes="{{ $sizes }}" alt="Galeri {{ $post->title }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale motion-reduce:transition-none"
                                        loading="lazy" decoding="async">
                                    <span
                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition motion-reduce:transition-none"></span>
                                </button>
                            @endforeach
                        </div>

                        {{-- Modal Preview (A11y + keyboard trap) --}}
                        <div x-show="open" x-transition x-cloak id="galeri-modal" role="dialog" aria-modal="true"
                            aria-label="Pratinjau galeri"
                            @keydown.escape.window.prevent.stop="open=false; lastFocus?.focus()"
                            @click.self="open=false; lastFocus?.focus()" x-init="$watch('open', v => { if (v) { setTimeout(() => $refs.closeBtn?.focus(), 0) } })"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-3 sm:px-4">
                            <div
                                class="relative w-full max-w-3xl bg-white rounded-2xl shadow ring-1 ring-black/5 p-3 sm:p-4 md:p-6">
                                <button x-ref="closeBtn" @click="open=false; lastFocus?.focus()" aria-label="Tutup"
                                    class="absolute right-2.5 top-2.5 inline-flex items-center justify-center rounded-full bg-gray-100 p-1.5 sm:p-2 text-gray-600 hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-600">
                                    ✕
                                </button>
                                <img :src="img" alt="Preview Galeri"
                                    class="w-full max-h-[70vh] object-contain rounded-lg">
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Lokasi Peta --}}
                @if ($embedMap)
                    <section class="rounded-2xl bg-white shadow ring-1 ring-black/5 p-4 sm:p-6 md:p-8">
                        <h3 class="text-base sm:text-lg md:text-xl font-semibold text-gray-900">Lokasi</h3>
                        <div class="mx-auto my-3 sm:my-4 h-1 w-16 sm:w-20 rounded-full bg-green-600"></div>
                        <div class="aspect-video overflow-hidden rounded-xl ring-1 ring-black/5">
                            {!! $embedMap !!}
                        </div>
                    </section>
                @endif

                {{-- CTA --}}
                <section class="rounded-2xl border border-green-200 bg-green-50/60 p-4 sm:p-5 md:p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2.5 sm:gap-3">
                        <div>
                            <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-900">Bagikan Potensi Ini
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-700">Sebarkan informasi untuk mendukung promosi dan
                                kolaborasi.</p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                            <a href="#" id="btnShare"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700 transition">
                                <x-heroicon-o-share class="size-4" /> Bagikan
                            </a>
                        </div>
                    </div>
                </section>
            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-4 sm:space-y-6 lg:sticky lg:top-20">
                <div class="bg-white rounded-xl shadow p-4 sm:p-5 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-2.5 sm:mb-3">Ringkasan Cepat</h3>
                    <ul class="space-y-1.5 sm:space-y-2 text-sm text-gray-700">
                        <li class="flex items-start sm:items-center gap-2">
                            <x-heroicon-o-map-pin class="h-4 w-4 min-w-4 text-green-700 mt-0.5 sm:mt-0" /> <span
                                class="break-words">{{ $lokasi }}</span>
                        </li>
                        @if (!is_null($stat1))
                            <li class="flex items-center gap-2">
                                <x-heroicon-o-chart-bar class="h-4 w-4 text-green-700" />
                                Estimasi: {{ is_numeric($stat1) ? number_format($stat1) : $stat1 }} {{ $stat1_unit }}
                            </li>
                        @endif
                        @if (!is_null($stat2))
                            <li class="flex items-center gap-2">
                                <x-heroicon-o-user-group class="h-4 w-4 text-green-700" />
                                Pelaku UMKM: {{ number_format($stat2) }}
                            </li>
                        @endif
                        @if (!is_null($stat3))
                            <li class="flex items-center gap-2">
                                <x-heroicon-o-globe-alt class="h-4 w-4 text-green-700" />
                                Lahan: {{ is_numeric($stat3) ? number_format($stat3, 2) : $stat3 }} ha
                            </li>
                        @endif
                        @if ($post?->contact_phone || $post?->contact_name)
                            <li class="flex items-start sm:items-center gap-2">
                                <x-heroicon-o-phone class="h-4 w-4 min-w-4 text-green-700 mt-0.5 sm:mt-0" />
                                <span class="break-words">
                                    Kontak:
                                    {{ trim(($post->contact_name ? $post->contact_name . ' — ' : '') . ($post->contact_phone ?? '')) }}
                                </span>
                            </li>
                        @endif
                    </ul>

                    @if (filled($post?->external_link))
                        <div class="mt-3 sm:mt-4">
                            <a href="{{ $post->external_link }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-sm font-medium
                                  bg-green-600 text-white hover:bg-green-700 transition
                                  md:bg-transparent md:text-green-700 md:hover:text-white md:border md:border-green-600 md:hover:bg-green-600 w-full sm:w-auto">
                                <x-heroicon-o-document-text class="size-4" /> Dokumen Terkait
                            </a>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow p-4 sm:p-5 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-2.5 sm:mb-3">Tautan Terkait</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('berita') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800"><x-heroicon-o-newspaper
                                    class="size-4" /> Berita Desa</a></li>
                        <li><a href="{{ route('umkm') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800"><x-heroicon-o-building-storefront
                                    class="size-4" /> UMKM Desa</a></li>
                        <li><a href="{{ route('peta-desa') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800"><x-heroicon-o-map
                                    class="size-4" /> Profil Wilayah</a></li>
                    </ul>
                </div>

                <div
                    class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow p-4 sm:p-5 ring-1 ring-green-200">
                    <h3 class="font-semibold text-gray-900">Butuh Bantuan?</h3>
                    <p class="text-sm text-gray-700 mt-1">Hubungi admin untuk update data atau kolaborasi promosi.</p>
                    <div class="mt-3 flex flex-col sm:flex-row gap-2">
                        <a href="#"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium
                              bg-green-600 text-white hover:bg-green-700 transition
                              md:bg-transparent md:text-green-700 md:hover:text-white md:border md:border-green-600 md:hover:bg-green-600">
                            <x-heroicon-o-inbox class="size-4" /> Kontak Admin
                        </a>
                        <a href="#"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium
                              bg-green-600 text-white hover:bg-green-700 transition
                              md:bg-transparent md:text-green-700 md:hover:text-white md:border md:border-green-600 md:hover:bg-green-600">
                            <x-heroicon-o-list-bullet class="size-4" /> Lihat Lainnya
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        {{-- Potensi Terkait --}}
        @if (!empty($related) && count($related))
            <section class="mt-8 sm:mt-10 md:mt-14">
                <h3 class="text-base sm:text-lg md:text-xl font-semibold text-gray-900">Potensi Terkait</h3>
                <div class="mx-auto my-3 sm:my-4 h-1 w-16 sm:w-20 rounded-full bg-green-600"></div>
                <div class="grid gap-3 sm:gap-4 lg:gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $rel)
                        @php
                            /** @var \App\Domains\Post\Models\Post $rel */
                            $img = $rel->cover_url ?? asset('public/img/potensi2.jpg');
                            $cat = $rel->potensi_category ?: optional($rel->category)->name ?: 'Potensi';
                        @endphp
                        <a href="{{ route('potensi-desa-detail', $rel->slug) }}"
                            class="group rounded-2xl bg-white shadow ring-1 ring-black/5 overflow-hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-green-600">
                            <div class="aspect-[16/9] bg-gray-100">
                                <img src="{{ $img }}"
                                    srcset="{{ $img }} 640w, {{ $img }} 960w, {{ $img }} 1280w"
                                    sizes="(min-width:1024px) 33vw, (min-width:640px) 50vw, 100vw"
                                    alt="{{ $rel->title }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale motion-reduce:transition-none"
                                    loading="lazy" decoding="async">
                            </div>
                            <div class="p-3 sm:p-4">
                                <div class="mb-1 flex flex-wrap items-center gap-1.5 sm:gap-2">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 sm:px-2.5 text-[10px] sm:text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                        <x-heroicon-o-tag class="size-4" /> {{ $cat }}
                                    </span>
                                </div>
                                <h4 class="text-sm md:text-base font-semibold text-gray-900 line-clamp-2">
                                    {{ $rel->title }}</h4>
                                <p class="mt-1 text-xs sm:text-sm text-gray-600 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($rel->summary ?? $rel->body_html), 110) }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </section>
@endsection

@push('scripts')
    @php
        $shareTitle = $post->title ?? 'Potensi Desa ';
        $shareText = \Illuminate\Support\Str::limit(strip_tags($post->summary ?? ($post->body_html ?? '')), 140);
        $shareUrl = request()->fullUrl();
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('btnShare');
            if (btn) {
                const shareData = {
                    title: @json($shareTitle),
                    text: @json($shareText ?: 'Lihat detail potensi desa di tautan berikut.'),
                    url: @json($shareUrl),
                };

                btn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    if (navigator.share) {
                        try {
                            await navigator.share(shareData);
                            toast('Tautan dibagikan.');
                            return;
                        } catch (err) {
                            if (err && err.name === 'AbortError') return;
                        }
                    }
                    try {
                        await navigator.clipboard.writeText(shareData.url);
                        toast('Tautan disalin ke clipboard.');
                    } catch {
                        // iOS Safari fallback
                        const input = document.createElement('input');
                        input.value = shareData.url;
                        document.body.appendChild(input);
                        input.select();
                        document.execCommand('copy');
                        input.remove();
                        toast('Tautan disalin ke clipboard.');
                    }
                });
            }

            // ✅ Toast: perhatikan safe-area untuk iPhone (notch)
            function toast(message = 'Berhasil', timeout = 2200) {
                const el = document.createElement('div');
                el.setAttribute('role', 'status');
                el.className =
                    'fixed z-[60] right-4 bottom-4 md:bottom-6 max-w-sm rounded-xl bg-gray-900 text-white text-sm ' +
                    'px-4 py-2 shadow-lg ring-1 ring-black/5 pointer-events-none ' +
                    'motion-reduce:transition-none';
                el.style.paddingBottom = 'calc(0.5rem + env(safe-area-inset-bottom))';
                el.textContent = message;
                document.body.appendChild(el);

                el.style.opacity = '0';
                el.style.transform = 'translateY(6px)';
                requestAnimationFrame(() => {
                    el.style.transition = 'opacity .18s ease, transform .18s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                });

                setTimeout(() => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(6px)';
                    el.addEventListener('transitionend', () => el.remove(), {
                        once: true
                    });
                }, timeout);
            }
        });
    </script>
@endpush
