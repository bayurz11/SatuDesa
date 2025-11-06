{{-- resources/views/pengumuman/show.blade.php --}}
@extends('layouts.app2')

@section('title', ($pengumuman->judul ?? 'Pengumuman') . ' — Pengumuman Desa')

@section('content')
    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Carbon;

        // ====== DATA STATIS (FALLBACK) ======
        if (!isset($pengumuman)) {
            $pengumuman = (object) [
                'judul' => 'Gotong Royong Bersama',
                'kategori' => 'Umum',
                'tag' => ['Lingkungan', 'Kebersamaan'],
                'tanggal' => '2025-09-21 08:00:00', // mulai acara
                'selesai' => '2025-09-21 11:30:00', // selesai acara (opsional)
                'lokasi' => 'Balai Desa Mentuda',
                'penanggung' => 'Kasi Pemerintahan',
                'cover' => asset('public/img/potensi2.jpg'),
                'ringkas' =>
                    'Diharapkan seluruh warga ikut serta dalam kegiatan gotong royong membersihkan lingkungan desa pada hari Minggu.',
                'isi_html' => '<p>
Kegiatan akan difokuskan pada area balai desa, masjid, dan jalur utama. Harap membawa alat kebersihan pribadi seperti <em>sapu lidi</em>, <em>cangkul</em>, dan <em>sarung tangan</em>. Panitia menyiapkan air minum dan snack.</p><ul><li>Briefing singkat pukul 08.00 WIB</li><li>Pembagian area kerja</li><li>Istirahat pukul 10.00 WIB</li><li>Penutupan pukul 11.30 WIB</li></ul>',
                'lampiran' => [
                    ['nama' => 'Surat Edaran RW.pdf', 'url' => '#'],
                    ['nama' => 'Denah Area Kerja.png', 'url' => '#'],
                ],
                'galeri' => [asset('public/img/potensi1.jpg'), asset('public/img/potensi2.jpg')],
                'created_at' => '2025-09-18 09:15:00',
                'updated_at' => '2025-09-19 14:20:00',
            ];
        }

        if (!isset($terkait)) {
            $terkait = [
                (object) [
                    'judul' => 'Sosialisasi Kesehatan',
                    'kategori' => 'Kesehatan',
                    'tanggal' => '2025-09-27 09:00:00',
                    'cover' => asset('public/img/potensi1.jpg'),
                    'ringkas' => 'Pemeriksaan kesehatan gratis di Posyandu.',
                ],
                (object) [
                    'judul' => 'Musyawarah Desa',
                    'kategori' => 'Agenda',
                    'tanggal' => '2025-09-25 19:30:00',
                    'cover' => asset('public/img/potensi2.jpg'),
                    'ringkas' => 'Pembahasan program kerja triwulan berikutnya.',
                ],
            ];
        }

        // Helper tanggal
        $start = Carbon::parse($pengumuman->tanggal);
        $end = !empty($pengumuman->selesai) ? Carbon::parse($pengumuman->selesai) : null;

        $badgeHari = $start->translatedFormat('l'); // Senin, Selasa, ...
        $badgeTgl = $start->format('d');
        $badgeBlnTh = $start->translatedFormat('M Y'); // Sep 2025
        $jamRange = $end ? $start->format('H:i') . '–' . $end->format('H:i') : $start->format('H:i') . ' WIB';
        $cover = $pengumuman->cover ?? asset('public/img/potensi2.jpg');
        $tags = collect($pengumuman->tag ?? [])->take(4);
    @endphp

    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="#" class="hover:text-green-700">Informasi</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="{{ route('pengumuman') }}" class="hover:text-green-700">Pengumuman</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium line-clamp-1">{{ $pengumuman->judul }}</li>
            </ol>
        </nav>

        {{-- HERO --}}
        <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
            <div class="grid md:grid-cols-12 gap-0">
                <figure class="md:col-span-7 h-56 md:h-80 overflow-hidden">
                    <img src="{{ $cover }}" alt="{{ $pengumuman->judul }}" class="h-full w-full object-cover"
                        loading="lazy" decoding="async">
                </figure>

                <div class="md:col-span-5 p-6 md:p-8 flex flex-col justify-center">
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                            <x-heroicon-o-bell class="size-4" />
                            {{ $pengumuman->kategori ?? 'Pengumuman' }}
                        </span>
                        @foreach ($tags as $t)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700 ring-1 ring-emerald-200">
                                #{{ $t }}
                            </span>
                        @endforeach
                    </div>

                    <h1 class="mt-3 text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">
                        {{ $pengumuman->judul }}
                    </h1>

                    <p class="mt-2 text-sm text-gray-600">{{ $pengumuman->ringkas }}</p>

                    <div class="mt-4 grid grid-cols-[auto,1fr] gap-x-3 gap-y-2 text-sm text-gray-700">
                        <span class="inline-flex items-center gap-2 text-gray-600">
                            <x-heroicon-o-calendar class="size-5 text-green-700" /> Tanggal
                        </span>
                        <span>{{ $start->translatedFormat('d F Y') }} @if ($end)
                                ({{ $jamRange }} WIB)
                            @else
                                • {{ $jamRange }}
                            @endif
                        </span>

                        <span class="inline-flex items-center gap-2 text-gray-600">
                            <x-heroicon-o-map-pin class="size-5 text-green-700" /> Lokasi
                        </span>
                        <span>{{ $pengumuman->lokasi }}</span>

                        <span class="inline-flex items-center gap-2 text-gray-600">
                            <x-heroicon-o-user class="size-5 text-green-700" /> Penanggung Jawab
                        </span>
                        <span>{{ $pengumuman->penanggung }}</span>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="#detail"
                            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                            <x-heroicon-o-eye class="size-5" /> Baca Detail
                        </a>
                        <a href="{{ url('/pengumuman') }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                            <x-heroicon-o-arrow-left class="size-5" /> Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Badge tanggal di pojok (opsional) --}}
            <div class="absolute left-4 top-4">
                <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-2 text-center shadow-sm">
                    <p class="text-xs font-medium text-green-700">{{ $badgeHari }}</p>
                    <p class="text-lg font-extrabold text-green-700 leading-none">{{ $badgeTgl }}</p>
                    <p class="text-xs font-medium text-green-700">{{ $badgeBlnTh }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-3 items-start mt-8">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-8">
                {{-- Isi Detail --}}
                <section id="detail" class="rounded-2xl bg-white shadow ring-1 ring-black/5 p-6 md:p-8">
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Detail Pengumuman</h2>
                    <div class="mx-auto my-4 h-1 w-20 rounded-full bg-green-600"></div>

                    <div class="prose max-w-none">
                        {!! $pengumuman->isi_html !!}
                    </div>

                    {{-- Lampiran --}}
                    @if (!empty($pengumuman->lampiran))
                        <div class="mt-6">
                            <h3 class="text-base md:text-lg font-semibold text-gray-900">Lampiran</h3>
                            <ul class="mt-3 space-y-2">
                                @foreach ($pengumuman->lampiran as $lamp)
                                    <li>
                                        <a href="{{ $lamp['url'] }}"
                                            class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                            <x-heroicon-o-paper-clip class="size-5" /> {{ $lamp['nama'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </section>

                {{-- Galeri/Foto kegiatan --}}
                @if (!empty($pengumuman->galeri))
                    <section class="rounded-2xl bg-white shadow ring-1 ring-black/5 p-6 md:p-8" x-data="{ open: false, img: '' }">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-900">Galeri</h3>
                        <div class="mx-auto my-4 h-1 w-20 rounded-full bg-green-600"></div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach ($pengumuman->galeri as $g)
                                <button class="group relative aspect-[4/3] overflow-hidden rounded-xl ring-1 ring-black/5"
                                    @click="open = true; img='{{ $g }}'">
                                    <img src="{{ $g }}" alt="Galeri {{ $pengumuman->judul }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale"
                                        loading="lazy">
                                    <span class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition"></span>
                                </button>
                            @endforeach
                        </div>

                        {{-- Modal Preview --}}
                        <div x-show="open" x-transition x-cloak @click.self="open=false"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
                            <div
                                class="relative max-w-3xl w-full bg-white rounded-2xl shadow ring-1 ring-black/5 p-4 md:p-6">
                                <button @click="open=false" aria-label="Tutup"
                                    class="absolute right-3 top-3 inline-flex items-center justify-center rounded-full bg-gray-100 p-1.5 text-gray-600 hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-600">✕</button>
                                <img :src="img" alt="Preview Galeri"
                                    class="w-full max-h-[70vh] object-contain rounded-lg">
                            </div>
                        </div>
                    </section>
                @endif

                {{-- CTA Aksi --}}
                <section class="rounded-2xl border border-green-200 bg-green-50/60 p-5 md:p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900">Aksi</h3>
                            <p class="text-sm text-gray-700">Sebarkan informasi ini agar lebih banyak warga yang hadir.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="#"
                                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                <x-heroicon-o-share class="size-4" /> Bagikan
                            </a>
                            <a href="#"
                                class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                <x-heroicon-o-printer class="size-4" /> Cetak
                            </a>
                        </div>
                    </div>
                </section>
            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                {{-- Info ringkas --}}
                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-3">Ringkasan Cepat</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-calendar class="h-4 w-4 text-green-700" />
                            {{ $start->translatedFormat('d F Y') }}
                            {{ $end ? '• ' . $jamRange . ' WIB' : '• ' . $jamRange }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-map-pin class="h-4 w-4 text-green-700" />
                            {{ $pengumuman->lokasi }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-user class="h-4 w-4 text-green-700" />
                            {{ $pengumuman->penanggung }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-clock class="h-4 w-4 text-green-700" />
                            Diposting {{ Carbon::parse($pengumuman->created_at)->diffForHumans() }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-pencil-square class="h-4 w-4 text-green-700" />
                            Diperbarui {{ Carbon::parse($pengumuman->updated_at)->diffForHumans() }}
                        </li>
                    </ul>
                </div>

                {{-- Tautan / Aksi cepat --}}
                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <h3 class="font-semibold text-gray-900 mb-3">Tautan Terkait</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/pengumuman') }}"
                                class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-list-bullet class="size-4" /> Semua Pengumuman</a></li>
                        <li><a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                                <x-heroicon-o-map class="size-4" /> Peta Lokasi</a></li>
                    </ul>
                </div>

                {{-- Kontak Admin --}}
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow p-5 ring-1 ring-green-200">
                    <h3 class="font-semibold text-gray-900">Butuh Info Tambahan?</h3>
                    <p class="text-sm text-gray-700 mt-1">Hubungi admin untuk pertanyaan terkait pengumuman ini.</p>
                    <div class="mt-3 flex gap-2">
                        <a href="#"
                            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                            <x-heroicon-o-inbox class="size-4" /> Kontak Admin
                        </a>
                        <a href="{{ url('/pengumuman') }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                            <x-heroicon-o-arrow-left class="size-4" /> Kembali
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        {{-- Pengumuman Terkait --}}
        @if (!empty($terkait))
            <section class="mt-10 md:mt-14">
                <h3 class="text-lg md:text-xl font-semibold text-gray-900">Pengumuman Terkait</h3>
                <div class="mx-auto my-4 h-1 w-20 rounded-full bg-green-600"></div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($terkait as $item)
                        @php
                            $tCover = $item->cover ?? asset('public/img/potensi1.jpg');
                            $tDate = Carbon::parse($item->tanggal);
                        @endphp
                        <a href="#" class="group rounded-2xl bg-white shadow ring-1 ring-black/5 overflow-hidden">
                            <div class="aspect-[16/9] bg-gray-100">
                                <img src="{{ $tCover }}" alt="{{ $item->judul }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale"
                                    loading="lazy">
                            </div>
                            <div class="p-4">
                                <div class="mb-1 flex flex-wrap items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                        <x-heroicon-o-bell class="size-4" /> {{ $item->kategori ?? 'Pengumuman' }}
                                    </span>
                                    <time class="inline-flex items-center gap-1 text-[11px] text-gray-500">
                                        <x-heroicon-o-clock class="size-4" /> {{ $tDate->translatedFormat('d M Y') }}
                                    </time>
                                </div>
                                <h4 class="text-sm md:text-base font-semibold text-gray-900 line-clamp-2">
                                    {{ $item->judul }}</h4>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                    {{ Str::limit($item->ringkas ?? '', 110) }}</p>
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
