@php
    $search = trim((string) request('q', ''));
    $metaTitle = 'Layanan Kantor Desa Mentuda';
    $metaDescription =
        'Informasi layanan yang tersedia di Kantor Desa Mentuda, meliputi administrasi kependudukan, surat keterangan, sosial, dan layanan umum warga.';

    $serviceCategories = [
        ['label' => 'Semua Layanan', 'count' => 15],
        ['label' => 'Administrasi', 'count' => 6],
        ['label' => 'Surat Keterangan', 'count' => 5],
        ['label' => 'Sosial', 'count' => 2],
        ['label' => 'Umum', 'count' => 2],
    ];

    $serviceStats = [
        ['label' => 'Jenis Layanan', 'value' => '15'],
        ['label' => 'Alur Proses', 'value' => '3 Langkah'],
        ['label' => 'Jam Layanan', 'value' => 'Senin-Jumat'],
    ];

    $services = [
        [
            'title' => 'Surat Keterangan Domisili',
            'category' => 'Administrasi',
            'requirements' => 'KTP, KK, pengantar RT/RW',
            'description' =>
                'Layanan surat keterangan tempat tinggal atau domisili warga untuk kebutuhan administrasi.',
            'icon' => 'home',
        ],
        [
            'title' => 'Surat Keterangan Usaha',
            'category' => 'Surat Keterangan',
            'requirements' => 'KTP, KK, data usaha',
            'description' =>
                'Surat keterangan untuk pelaku usaha atau UMKM sebagai pendukung pengajuan modal dan legalitas usaha.',
            'icon' => 'briefcase',
        ],
        [
            'title' => 'Surat Pengantar KTP',
            'category' => 'Administrasi',
            'requirements' => 'KK, akta lahir, foto bila diperlukan',
            'description' => 'Layanan pengantar untuk pembuatan atau perubahan data KTP sesuai kebutuhan warga.',
            'icon' => 'id-card',
        ],
        [
            'title' => 'Surat Pengantar Kartu Keluarga',
            'category' => 'Administrasi',
            'requirements' => 'KTP, KK lama, dokumen pendukung',
            'description' => 'Pengantar perubahan, penambahan, atau penerbitan Kartu Keluarga.',
            'icon' => 'users',
        ],
        [
            'title' => 'Surat Keterangan Tidak Mampu',
            'category' => 'Sosial',
            'requirements' => 'KTP, KK, data keluarga',
            'description' =>
                'Surat keterangan untuk kebutuhan pendidikan, kesehatan, bantuan sosial, atau administrasi lainnya.',
            'icon' => 'heart',
        ],
        [
            'title' => 'Surat Pengantar Nikah',
            'category' => 'Administrasi',
            'requirements' => 'KTP, KK, akta lahir, pas foto',
            'description' => 'Layanan pengantar administrasi pernikahan untuk diteruskan ke instansi terkait.',
            'icon' => 'document',
        ],
        [
            'title' => 'Surat Keterangan Kelahiran',
            'category' => 'Surat Keterangan',
            'requirements' => 'KTP orang tua, KK, surat bidan/rumah sakit',
            'description' => 'Surat keterangan kelahiran sebagai dokumen pendukung pengurusan akta kelahiran.',
            'icon' => 'sparkles',
        ],
        [
            'title' => 'Surat Keterangan Kematian',
            'category' => 'Surat Keterangan',
            'requirements' => 'KTP/KK almarhum, data keluarga',
            'description' => 'Surat keterangan kematian untuk kebutuhan pencatatan sipil dan administrasi keluarga.',
            'icon' => 'archive',
        ],
        [
            'title' => 'Legalisasi Dokumen',
            'category' => 'Umum',
            'requirements' => 'Dokumen asli dan fotokopi',
            'description' => 'Pengesahan salinan dokumen tertentu sesuai kebutuhan administrasi warga.',
            'icon' => 'check',
        ],
    ];

    if ($search !== '') {
        $services = collect($services)
            ->filter(function (array $service) use ($search) {
                return collect([
                    $service['title'],
                    $service['category'],
                    $service['requirements'],
                    $service['description'],
                ])->contains(fn ($value) => stripos((string) $value, $search) !== false);
            })
            ->values()
            ->all();
    }
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
                    <li>Pelayanan Publik</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Layanan Kantor Desa</li>
                </ol>
            </nav>

            <div class="max-w-4xl" data-aos="fade-up">
                <h1
                    class="mt-5 max-w-2xl text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-[2rem] lg:leading-tight">
                    Layanan Kantor Desa Mentuda
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-50/90">
                    Informasi jenis layanan administrasi, surat keterangan, sosial, dan layanan umum
                    yang dapat diajukan masyarakat melalui Kantor Desa Mentuda.
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
                            Panduan Layanan
                        </span>

                        <h2 class="mt-4 text-2xl font-bold text-gray-900 sm:text-3xl">
                            Layanan yang Tersedia di Kantor Desa
                        </h2>

                        <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                            Pilih layanan sesuai kebutuhan, siapkan berkas persyaratan, lalu ajukan ke petugas kantor desa.
                        </p>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        @foreach ($serviceStats as $stat)
                            <div
                                class="rounded-[22px] border border-green-100 bg-green-50 p-4 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md hover:shadow-green-100/60">
                                <p class="text-xl font-bold text-green-800">{{ $stat['value'] }}</p>
                                <p class="mt-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-green-700">
                                    {{ $stat['label'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 rounded-[28px] border border-gray-200 bg-white p-5 shadow-md shadow-gray-200/60">
                        <div class="grid gap-4 md:grid-cols-3">
                            <div class="rounded-2xl bg-emerald-50 px-5 py-5">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-700">
                                    1. Pilih Layanan
                                </p>
                                <p class="mt-2 text-sm leading-6 text-gray-700">
                                    Tentukan jenis surat atau kebutuhan administrasi yang ingin diajukan.
                                </p>
                            </div>

                            <div class="rounded-2xl bg-amber-50 px-5 py-5">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-700">
                                    2. Siapkan Berkas
                                </p>
                                <p class="mt-2 text-sm leading-6 text-gray-700">
                                    Siapkan KTP, KK, dan dokumen pendukung sesuai jenis layanan.
                                </p>
                            </div>

                            <div class="rounded-2xl bg-sky-50 px-5 py-5">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-700">
                                    3. Datang ke Kantor
                                </p>
                                <p class="mt-2 text-sm leading-6 text-gray-700">
                                    Petugas akan melakukan verifikasi dan memproses dokumen pengajuan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($services as $service)
                            <article data-aos="fade-up" data-aos-delay="{{ min(($loop->index % 3) * 80, 160) }}"
                                class="group relative overflow-hidden rounded-[28px] border border-gray-200 bg-white p-5 shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-xl hover:shadow-green-100/60">

                                <div
                                    class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-green-50 transition duration-300 group-hover:scale-125">
                                </div>

                                <div class="relative">
                                    <div
                                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100 transition duration-300 group-hover:bg-green-700 group-hover:text-white">
                                        @if ($service['icon'] === 'home')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 10.5L12 3l9 7.5M5 10v10h14V10M9 20v-6h6v6" />
                                            </svg>
                                        @elseif ($service['icon'] === 'briefcase')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10 6V5a2 2 0 012-2h0a2 2 0 012 2v1m-9 0h14a1 1 0 011 1v11a2 2 0 01-2 2H5a2 2 0 01-2-2V7a1 1 0 011-1z" />
                                            </svg>
                                        @elseif ($service['icon'] === 'id-card')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 5h16v14H4zM8 10h4M8 14h8M15.5 9.5h1" />
                                            </svg>
                                        @elseif ($service['icon'] === 'users')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 11a4 4 0 10-8 0 4 4 0 008 0zM4 21a8 8 0 0116 0M18 8a3 3 0 013 3M21 21a6 6 0 00-4-5.65" />
                                            </svg>
                                        @elseif ($service['icon'] === 'heart')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 21s-7-4.5-9-10a5.5 5.5 0 019-5.8A5.5 5.5 0 0121 11c-2 5.5-9 10-9 10z" />
                                            </svg>
                                        @elseif ($service['icon'] === 'document')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M7 3h7l5 5v13H7V3zM14 3v5h5M9 13h6M9 17h6" />
                                            </svg>
                                        @elseif ($service['icon'] === 'sparkles')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3zM19 15l.9 2.6L22 18.5l-2.1.9L19 22l-.9-2.6-2.1-.9 2.1-.9L19 15z" />
                                            </svg>
                                        @elseif ($service['icon'] === 'archive')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 7h16M5 7l1 13h12l1-13M9 11h6" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                    </div>

                                    <span
                                        class="inline-flex rounded-full bg-green-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-green-700 ring-1 ring-green-100">
                                        {{ $service['category'] }}
                                    </span>

                                    <h3
                                        class="mt-4 line-clamp-2 text-lg font-bold text-gray-900 transition group-hover:text-green-700">
                                        {{ $service['title'] }}
                                    </h3>

                                    <p class="mt-3 text-sm leading-6 text-gray-600">
                                        {{ $service['description'] }}
                                    </p>

                                    <div class="mt-5 rounded-2xl bg-gray-50 p-4 ring-1 ring-gray-100">
                                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-gray-500">
                                            Syarat Umum
                                        </p>
                                        <p class="mt-2 text-sm leading-6 text-gray-700">
                                            {{ $service['requirements'] }}
                                        </p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div
                        class="mt-8 rounded-2xl bg-green-50 px-4 py-3 text-sm leading-6 text-green-800 ring-1 ring-green-100">
                        Data layanan dapat disesuaikan kembali dengan kebijakan Kantor Desa Mentuda dan peraturan
                        administrasi yang berlaku.
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
                                Kategori
                            </p>
                            <h2 class="text-lg font-bold text-gray-900">Kelompok Layanan</h2>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach ($serviceCategories as $category)
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
                    class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-12 -left-12 h-36 w-36 rounded-full bg-black/10"></div>

                    <div class="relative">
                        <div
                            class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7h8M8 11h8M8 15h5M5 3h14a1 1 0 011 1v16l-4-3H5a1 1 0 01-1-1V4a1 1 0 011-1z" />
                            </svg>
                        </div>

                        <h2 class="text-lg font-bold">Informasi Pelayanan</h2>

                        <p class="mt-3 text-sm leading-6 text-white/85">
                            Untuk proses lebih cepat, warga disarankan membawa dokumen asli dan fotokopi sesuai kebutuhan
                            layanan.
                        </p>

                        <div class="mt-5 rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">
                                Jam Pelayanan
                            </p>
                            <p class="mt-2 text-sm font-semibold text-white">
                                Senin - Jumat
                            </p>
                            <p class="text-sm text-white/80">
                                08.00 - 15.00 WIB
                            </p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
