@extends('layouts.app2')

@section('title', ($berita->judul ?? 'Berita') . ' — Berita Desa')

@section('content')
    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Carbon;

        // ===== DATA STATIS (fallback) =====
        if (!isset($berita)) {
            $berita = (object) [
                'judul' => 'Hasil Panen Ikan Kerapu Melimpah Membantu Perekonomian Masyarakat Desa Mentuda',
                'kategori' => 'Berita Utama',
                'tag' => ['Perikanan', 'Ekonomi'],
                'cover' => asset('public/img/potensi1.jpg'),
                'penulis' => 'Admin Desa',
                'tanggal' => '2024-12-12 08:30:00',
                'ringkas' =>
                    'Panen ikan kerapu tahun ini meningkat signifikan dan berdampak positif pada pendapatan nelayan setempat.',
                'isi_html' => '
                <p>Musim panen kali ini menunjukkan peningkatan kualitas dan kuantitas hasil tangkapan. Nelayan mengaku terbantu dengan adanya fasilitas <em>cold chain</em> yang menjaga kesegaran hasil laut.</p>
                <h3>Dukungan Sarana & Prasarana</h3>
                <p>Pemerintah desa bersama BUMDes memperkuat rantai pasok melalui gudang es dan pengembangan pemasaran digital.</p>
                <blockquote>“Harga lebih stabil, pembeli juga lebih banyak,” ujar salah satu nelayan.</blockquote>
                <p>Langkah selanjutnya adalah memperluas pasar ke kota terdekat, serta mendorong produk olahan bernilai tambah.</p>
            ',
                'baca_menit' => 4, // estimasi membaca
                'updated_at' => '2024-12-13 14:20:00',
            ];
        }

        if (!isset($terkait)) {
            $terkait = [
                (object) [
                    'judul' => 'Pembangunan Balai Desa Mentuda Resmi Dimulai',
                    'kategori' => 'Berita',
                    'tanggal' => '2024-12-12 10:00:00',
                    'cover' => asset('public/img/potensi2.jpg'),
                    'ringkas' => 'Balai desa baru sebagai pusat layanan publik dan kegiatan warga.',
                ],
                (object) [
                    'judul' => 'Tradisi Adat Desa Mentuda Tetap Dilestarikan',
                    'kategori' => 'Budaya',
                    'tanggal' => '2024-12-12 11:00:00',
                    'cover' => asset('public/img/potensi1.jpg'),
                    'ringkas' => 'Festival tahunan dan kegiatan komunitas menjaga warisan budaya.',
                ],
                (object) [
                    'judul' => 'Pelatihan UMKM: Dorong Perekonomian Lokal',
                    'kategori' => 'UMKM',
                    'tanggal' => '2024-12-12 13:00:00',
                    'cover' => asset('public/img/potensi2.jpg'),
                    'ringkas' => 'Pemasaran digital & pengemasan produk untuk pelaku UMKM.',
                ],
            ];
        }

        $tgl = Carbon::parse($berita->tanggal);
        $cover = $berita->cover ?? asset('public/img/potensi1.jpg');
        $tags = collect($berita->tag ?? [])->take(5);
    @endphp

    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ url('/') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="#" class="hover:text-green-700">Informasi</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="{{ url('/berita') }}" class="hover:text-green-700">Berita</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium line-clamp-1">{{ $berita->judul }}</li>
            </ol>
        </nav>

        {{-- HERO / Featured Cover --}}
        <article class="relative overflow-hidden rounded-2xl shadow ring-1 ring-black/5 group">
            <figure class="h-[320px] md:h-[420px] overflow-hidden">
                <img src="{{ $cover }}" alt="{{ $berita->judul }}"
                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.02]"
                    loading="lazy">
            </figure>

            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-black/25 to-transparent">
            </div>

            <div class="absolute inset-x-0 bottom-0 p-5 md:p-6">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-white/95 px-2.5 py-1 text-xs font-medium text-green-700 ring-1 ring-black/5">
                        <x-heroicon-o-tag class="size-4" /> {{ $berita->kategori ?? 'Berita' }}
                    </span>
                    <time class="inline-flex items-center gap-1 rounded-full bg-black/50 px-2.5 py-1 text-xs text-white">
                        <x-heroicon-o-clock class="size-4" /> {{ $tgl->translatedFormat('d M Y') }}
                    </time>
                    @if ($berita->baca_menit ?? false)
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-black/50 px-2.5 py-1 text-xs text-white">
                            <x-heroicon-o-book-open class="size-4" /> {{ $berita->baca_menit }} menit baca
                        </span>
                    @endif
                </div>

                <h1 class="text-white text-2xl md:text-3xl font-extrabold leading-snug drop-shadow">
                    {{ $berita->judul }}
                </h1>

                <p class="mt-2 text-white/90 line-clamp-2">{{ $berita->ringkas }}</p>
            </div>
        </article>

        <div class="grid gap-8 md:gap-10 lg:grid-cols-3 items-start mt-8">
            {{-- KONTEN UTAMA --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Meta atas --}}
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                    <span class="inline-flex items-center gap-2">
                        <x-heroicon-o-user class="size-5 text-green-700" /> {{ $berita->penulis ?? 'Admin' }}
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <x-heroicon-o-calendar class="size-5 text-green-700" /> {{ $tgl->translatedFormat('d F Y, H:i') }}
                        WIB
                    </span>
                    @if (!empty($berita->updated_at))
                        <span class="inline-flex items-center gap-2">
                            <x-heroicon-o-pencil-square class="size-5 text-green-700" />
                            Diperbarui {{ Carbon::parse($berita->updated_at)->diffForHumans() }}
                        </span>
                    @endif>
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
                        {!! $berita->isi_html !!}
                    </div>

                    {{-- Share / Print --}}
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

                {{-- Navigasi Sebelumnya / Berikutnya (placeholder) --}}
                <nav class="flex items-center justify-between text-sm">
                    <a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
                        <x-heroicon-o-arrow-left class="size-4" /> Berita sebelumnya
                    </a>
                    <a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800">
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
                            <x-heroicon-o-tag class="h-4 w-4 text-green-700" /> {{ $berita->kategori ?? 'Berita' }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-user class="h-4 w-4 text-green-700" /> {{ $berita->penulis ?? 'Admin' }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-clock class="h-4 w-4 text-green-700" /> {{ $berita->baca_menit ?? 3 }} menit baca
                        </li>
                    </ul>
                </div>

                {{-- Kategori (statis) --}}
                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <h4 class="font-semibold text-gray-900 mb-3">Kategori</h4>
                    <div class="flex flex-wrap gap-2 text-sm">
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg border bg-green-600 border-green-600 text-white">Semua</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Berita
                            Utama</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Pengumuman</a>
                        <a href="#"
                            class="px-3 py-1.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Agenda</a>
                    </div>
                </div>

                {{-- Terbaru (statis) --}}
                <div class="bg-white rounded-xl shadow p-4 ring-1 ring-black/5">
                    <h4 class="font-semibold text-gray-900 mb-3">Terbaru</h4>
                    <div class="space-y-3">
                        @foreach ($terkait as $item)
                            @php
                                $tDate = Carbon::parse($item->tanggal);
                            @endphp
                            <a href="#" class="flex items-center gap-3 rounded-lg p-2 hover:bg-gray-50 transition">
                                <img src="{{ $item->cover }}" alt="Thumb berita"
                                    class="h-16 w-20 rounded-md object-cover ring-1 ring-black/5" loading="lazy">
                                <div class="min-w-0">
                                    <h5 class="text-sm font-medium text-gray-900 line-clamp-2 hover:text-green-700">
                                        {{ $item->judul }}
                                    </h5>
                                    <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                        <span class="inline-flex items-center gap-1">
                                            <x-heroicon-o-tag class="size-4" /> {{ $item->kategori }}
                                        </span>
                                        <time class="inline-flex items-center gap-1">
                                            <x-heroicon-o-clock class="size-4" /> {{ $tDate->translatedFormat('d-m-Y') }}
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
        @if (!empty($terkait))
            <section class="mt-10 md:mt-14">
                <h3 class="text-lg md:text-xl font-semibold text-gray-900">Berita Terkait</h3>
                <div class="mx-auto my-4 h-1 w-20 rounded-full bg-green-600"></div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($terkait as $item)
                        @php
                            $img = $item->cover ?? asset('public/img/potensi2.jpg');
                            $tDate = Carbon::parse($item->tanggal);
                        @endphp
                        <a href="#" class="group rounded-2xl bg-white shadow ring-1 ring-black/5 overflow-hidden">
                            <div class="aspect-[16/9] bg-gray-100">
                                <img src="{{ $img }}" alt="{{ $item->judul }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale"
                                    loading="lazy">
                            </div>
                            <div class="p-4">
                                <div class="mb-1 flex flex-wrap items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                        <x-heroicon-o-tag class="size-4" /> {{ $item->kategori ?? 'Berita' }}
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
