@extends('layouts.app2')

@section('title', ($post->title ?? 'Potensi Desa') . ' — Potensi')

@section('content')
@php
    use Illuminate\Support\Str;

    /** @var \App\Domains\Post\Models\Post|null $post */

    // ====== Ambil dari Model Post (content_type = potensi) ======
    // Cover: pakai accessor getCoverUrlAttribute()
    $cover = $post?->cover_url ?? asset('public/img/potensi1.jpg');

    // Kategori potensi: prioritas kolom potensi_category, fallback ke kategori umum
    $kategori = $post?->potensi_category ?: optional($post?->category)->name ?: 'Potensi';

    // Tags relasi (post_tag). Jika belum ada, kosongkan.
    $tags = ($post?->relationLoaded('tags') ? $post->tags : $post?->tags())
        ?->pluck('name')->filter()->unique()->values() ?? collect();

    // Galeri ambil dari meta.gallery (array of URL/path)
    $gallery = collect(data_get($post, 'meta.gallery', []))
        ->filter(fn ($g) => filled($g))
        ->map(function ($g) {
            return Str::startsWith($g, ['http://', 'https://']) ? $g : asset($g);
        })
        ->take(12);

    // Lokasi/alamat
    $lokasi = $post?->address ?: 'Desa Mentuda, Lingga, Kepulauan Riau';

    // Map embed: pakai accessor getMapEmbedUrlAttribute(); fallback pakai alamat
    $embedMap = $post?->map_embed_url
        ?: (filled($lokasi)
            ? '<iframe src="https://maps.google.com/maps?q=' . urlencode($lokasi) . '&t=&z=13&ie=UTF8&iwloc=&output=embed" class="w-full h-full border-0" loading="lazy"></iframe>'
            : null);

    // Ringkasan angka dari meta
    $stat1       = data_get($post, 'meta.estimasi_produksi');            // angka contoh: 180
    $stat1_unit  = data_get($post, 'meta.estimasi_satuan', 'ton/tahun'); // contoh: 'ton/tahun'
    $stat2       = data_get($post, 'meta.pelaku_umkm');                  // contoh: 42
    $stat3       = data_get($post, 'meta.luas_lahan');                   // contoh: 12.5

    // Deskripsi: utamakan body_html, fallback summary
    $deskripsiHtml = $post?->body_html ?: e($post?->summary);

    // Detail tabel kunci: gabungan kolom eksplisit + meta.detail (array key=>val)
    $fmtRp = function ($n) { return is_numeric($n) ? 'Rp ' . number_format($n, 0, ',', '.') : $n; };
    $detailBase = array_filter([
        'Kategori'       => $kategori,
        'Alamat'         => $post?->address,
        'Koordinat'      => $post?->hasCoordinates() ? ($post->latitude . ', ' . $post->longitude) : null,
        'Kontak'         => trim(($post?->contact_name ? $post->contact_name . ' — ' : '') . ($post->contact_phone ?? '')),
        'Rentang Harga'  => (!is_null($post?->price_min) || !is_null($post?->price_max))
                            ? trim(($post?->price_min !== null ? $fmtRp($post->price_min) : '')
                                 . (($post?->price_min !== null && $post?->price_max !== null) ? ' — ' : '')
                                 . ($post?->price_max !== null ? $fmtRp($post->price_max) : ''))
                            : null,
        'Tautan Eksternal' => $post?->external_link,
    ], fn($v) => filled($v));

    $detailMeta = (array) data_get($post, 'meta.detail', []); // mis. ['Musim Panen'=>'Maret–September', ...]
    $detail = array_filter(array_merge($detailBase, $detailMeta));

    $updatedAt = $post?->updated_at;
@endphp

<section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">
    {{-- Breadcrumb --}}
    <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
        <ol class="flex items-center gap-2">
            <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
            <li aria-hidden="true">/</li>
            <li><a href="#" class="hover:text-green-700">Informasi</a></li>
            <li aria-hidden="true">/</li>
            <li><a href="{{ route('potensi-desa') }}" class="hover:text-green-700">Potensi Desa</a></li>
            <li aria-hidden="true">/</li>
            <li class="text-green-700 font-medium line-clamp-1">{{ $post->title }}</li>
        </ol>
    </nav>

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="grid md:grid-cols-12 gap-0">
            <figure class="md:col-span-7 h-56 md:h-80 overflow-hidden">
                <img src="{{ $cover }}" alt="{{ $post->title }}" class="h-full w-full object-cover"
                     loading="lazy" decoding="async">
            </figure>
            <div class="md:col-span-5 p-6 md:p-8 flex flex-col justify-center">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                        <x-heroicon-o-tag class="size-4" />
                        {{ $kategori }}
                    </span>
                    @foreach ($tags as $t)
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700 ring-1 ring-emerald-200">
                            #{{ $t }}
                        </span>
                    @endforeach
                </div>

                <h1 class="mt-3 text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">
                    {{ $post->title }}
                </h1>
                @if (filled($post->summary))
                    <p class="mt-1 text-gray-600">{{ $post->summary }}</p>
                @endif

                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-gray-600">
                    <span class="inline-flex items-center gap-2">
                        <x-heroicon-o-map-pin class="size-4 text-green-700" /> {{ $lokasi }}
                    </span>
                    @if ($updatedAt)
                        <span class="inline-flex items-center gap-2">
                            <x-heroicon-o-clock class="size-4 text-green-700" />
                            Diperbarui {{ \Illuminate\Support\Carbon::parse($updatedAt)->diffForHumans() }}
                        </span>
                    @endif
                </div>

                <div class="mt-5 flex flex-col sm:flex-row gap-2">
                    <a href="#informasi"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                        <x-heroicon-o-information-circle class="size-5" /> Lihat Informasi
                    </a>
                    {{-- Mobile: hijau solid; mulai md berubah jadi outline --}}
                    <a href="{{ route('potensi-desa') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium
                              bg-green-600 text-white hover:bg-green-700 transition
                              md:bg-transparent md:text-green-700 md:hover:text-white md:border md:border-green-600 md:hover:bg-green-600">
                        <x-heroicon-o-arrow-left class="size-5" /> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-3 items-start mt-8">
        {{-- KONTEN UTAMA --}}
        <article class="lg:col-span-2 space-y-8">
            {{-- Ringkasan Angka --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="rounded-xl bg-green-50/60 p-4 ring-1 ring-green-200">
                    <p class="text-[11px] sm:text-xs text-gray-600">Estimasi Produksi</p>
                    <p class="mt-0.5 font-semibold text-gray-900 text-xl md:text-2xl">
                        @if (!is_null($stat1))
                            {{ is_numeric($stat1) ? number_format($stat1) : $stat1 }}
                            <span class="text-sm font-medium text-gray-600">{{ $stat1_unit }}</span>
                        @else
                            <span class="text-gray-500">—</span>
                        @endif
                    </p>
                </div>
                <div class="rounded-xl bg-emerald-50/60 p-4 ring-1 ring-emerald-200">
                    <p class="text-[11px] sm:text-xs text-gray-600">Pelaku UMKM</p>
                    <p class="mt-0.5 font-semibold text-gray-900 text-xl md:text-2xl">
                        {{ !is_null($stat2) ? number_format($stat2) : '—' }}
                    </p>
                </div>
                <div class="rounded-xl bg-lime-50/60 p-4 ring-1 ring-lime-200 hidden sm:block">
                    <p class="text-[11px] sm:text-xs text-gray-600">Luas Lahan</p>
                    <p class="mt-0.5 font-semibold text-gray-900 text-xl md:text-2xl">
                        @if (!is_null($stat3))
                            {{ is_numeric($stat3) ? number_format($stat3, 2) : $stat3 }} <span class="text-sm text-gray-600">ha</span>
                        @else
                            <span class="text-gray-500">—</span>
                        @endif
                    </p>
                </div>
            </div>

            {{-- Informasi Utama --}}
            <section id="informasi" class="rounded-2xl bg-white shadow ring-1 ring-black/5 p-6 md:p-8">
                <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Deskripsi</h2>
                <div class="mx-auto my-4 h-1 w-20 rounded-full bg-green-600"></div>
                <div class="prose max-w-none">
                    {!! filled($deskripsiHtml) ? $deskripsiHtml : '<p class="text-gray-600">Belum ada deskripsi terperinci untuk potensi ini.</p>' !!}
                </div>

                {{-- Detail Tabel Kunci --}}
                @if (!empty($detail))
                    <div class="mt-6 overflow-hidden rounded-xl ring-1 ring-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($detail as $k => $v)
                                    <tr>
                                        <th class="w-48 bg-gray-50 px-4 py-3 text-left font-medium text-gray-700">{{ $k }}</th>
                                        <td class="px-4 py-3 text-gray-800">
                                            @if ($k === 'Tautan Eksternal' && filled($v))
                                                <a href="{{ $v }}" target="_blank" rel="noopener" class="text-green-700 hover:text-green-800 underline">{{ $v }}</a>
                                            @else
                                                {{ is_array($v) ? implode(', ', $v) : $v }}
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
                <section class="rounded-2xl bg-white shadow ring-1 ring-black/5 p-6 md:p-8" x-data="{ open: false, img: '' }">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-900">Galeri</h3>
                    <div class="mx-auto my-4 h-1 w-20 rounded-full bg-green-600"></div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($gallery as $g)
                            <button class="group relative aspect-[4/3] overflow-hidden rounded-xl ring-1 ring-black/5"
                                    @click="open = true; img='{{ $g }}'">
                                <img src="{{ $g }}" alt="Galeri {{ $post->title }}"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale"
                                     loading="lazy">
                                <span class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition"></span>
                            </button>
                        @endforeach
                    </div>

                    {{-- Modal Preview --}}
                    <div x-show="open" x-transition x-cloak @click.self="open=false"
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
                        <div class="relative max-w-3xl w-full bg-white rounded-2xl shadow ring-1 ring-black/5 p-4 md:p-6">
                            <button @click="open=false" aria-label="Tutup"
                                    class="absolute right-3 top-3 inline-flex items-center justify-center rounded-full bg-gray-100 p-1.5 text-gray-600 hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-600">✕</button>
                            <img :src="img" alt="Preview Galeri" class="w-full max-h-[70vh] object-contain rounded-lg">
                        </div>
                    </div>
                </section>
            @endif

            {{-- Lokasi Peta --}}
            @if ($embedMap)
                <section class="rounded-2xl bg-white shadow ring-1 ring-black/5 p-6 md:p-8">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-900">Lokasi</h3>
                    <div class="mx-auto my-4 h-1 w-20 rounded-full bg-green-600"></div>
                    <div class="aspect-[16/9] overflow-hidden rounded-xl ring-1 ring-black/5">
                        {!! $embedMap !!}
                    </div>
                </section>
            @endif

            {{-- CTA --}}
            <section class="rounded-2xl border border-green-200 bg-green-50/60 p-5 md:p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="text-base md:text-lg font-semibold text-gray-900">Bagikan Potensi Ini</h3>
                        <p class="text-sm text-gray-700">Sebarkan informasi untuk mendukung promosi dan kolaborasi.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                        <a href="#"
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                            <x-heroicon-o-share class="size-4" /> Bagikan
                        </a>
                    </div>
                </div>
            </section>
        </article>

        {{-- SIDEBAR --}}
        <aside class="space-y-6 lg:sticky lg:top-20">
            <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                <h3 class="font-semibold text-gray-900 mb-3">Ringkasan Cepat</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-center gap-2">
                        <x-heroicon-o-map-pin class="h-4 w-4 text-green-700" /> {{ $lokasi }}
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
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-phone class="h-4 w-4 text-green-700" />
                            Kontak: {{ trim(($post->contact_name ? $post->contact_name.' — ' : '') . ($post->contact_phone ?? '')) }}
                        </li>
                    @endif
                </ul>

                @if (filled($post?->external_link))
                    <div class="mt-4">
                        <a href="{{ $post->external_link }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium
                                  bg-green-600 text-white hover:bg-green-700 transition
                                  md:bg-transparent md:text-green-700 md:hover:text-white md:border md:border-green-600 md:hover:bg-green-600">
                            <x-heroicon-o-document-text class="size-4" /> Dokumen Terkait
                        </a>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                <h3 class="font-semibold text-gray-900 mb-3">Tautan Terkait</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('berita') }}" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                        <x-heroicon-o-newspaper class="size-4" /> Berita Desa</a></li>
                    <li><a href="{{ route('umkm') }}" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                        <x-heroicon-o-building-storefront class="size-4" /> UMKM Desa</a></li>
                    <li><a href="{{ route('peta-desa') }}" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                        <x-heroicon-o-map class="size-4" /> Profil Wilayah</a></li>
                </ul>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow p-5 ring-1 ring-green-200">
                <h3 class="font-semibold text-gray-900">Butuh Bantuan?</h3>
                <p class="text-sm text-gray-700 mt-1">Hubungi admin untuk update data atau kolaborasi promosi.</p>
                <div class="mt-3 flex flex-col sm:flex-row gap-2">
                    <a href="#"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium
                              bg-green-600 text-white hover:bg-green-700 transition
                              md:bg-transparent md:text-green-700 md:hover:text-white md:border md:border-green-600 md:hover:bg-green-600">
                        <x-heroicon-o-inbox class="size-4" /> Kontak Admin
                    </a>
                    <a href="#"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium
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
        <section class="mt-10 md:mt-14">
            <h3 class="text-lg md:text-xl font-semibold text-gray-900">Potensi Terkait</h3>
            <div class="mx-auto my-4 h-1 w-20 rounded-full bg-green-600"></div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($related as $item)
                    @php
                        /** @var \App\Domains\Post\Models\Post $item */
                        $img = $item->cover_url ?? asset('public/img/potensi2.jpg');
                        $cat = $item->potensi_category ?: optional($item->category)->name ?: 'Potensi';
                    @endphp
                    <a href="{{ route('potensi-desa') }}/{{ $item->slug }}"
                       class="group rounded-2xl bg-white shadow ring-1 ring-black/5 overflow-hidden">
                        <div class="aspect-[16/9] bg-gray-100">
                            <img src="{{ $img }}" alt="{{ $item->title }}"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale"
                                 loading="lazy">
                        </div>
                        <div class="p-4">
                            <div class="mb-1 flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                    <x-heroicon-o-tag class="size-4" /> {{ $cat }}
                                </span>
                            </div>
                            <h4 class="text-sm md:text-base font-semibold text-gray-900 line-clamp-2">
                                {{ $item->title }}</h4>
                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item->summary ?? $item->body_html), 110) }}
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
<script>document.addEventListener('alpine:init', () => {});</script>
@endpush
