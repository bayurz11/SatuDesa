@php
    $search = trim((string) request('q', ''));
    $metaTitle = 'Toko UMKM Desa Mentuda';
    $metaDescription =
        'Etalase produk UMKM Desa Mentuda berisi produk lokal, oleh-oleh, hasil laut, kerajinan, dan kontak pemesanan.';

    $waNumber = '6281234567890';
    $productImage = asset('img/bg.jpg');

    $productCategories = [
        ['label' => 'Semua Produk', 'count' => 32],
        ['label' => 'Hasil Laut', 'count' => 10],
        ['label' => 'Kuliner', 'count' => 9],
        ['label' => 'Kerajinan', 'count' => 6],
        ['label' => 'Pertanian', 'count' => 4],
        ['label' => 'Jasa Lokal', 'count' => 3],
    ];

    $shopStats = [
        ['label' => 'Produk Lokal', 'value' => '32'],
        ['label' => 'Pelaku UMKM', 'value' => '18'],
        ['label' => 'Kategori', 'value' => '5'],
    ];

    $products = [
        [
            'name' => 'Kerupuk Ikan Mentuda',
            'category' => 'Hasil Laut',
            'price' => 'Rp25.000',
            'unit' => 'per bungkus',
            'seller' => 'Dapur Laut Mentuda',
            'description' =>
                'Kerupuk ikan rumahan khas pesisir dengan rasa gurih, cocok untuk oleh-oleh dan konsumsi keluarga.',
            'badge' => 'Terlaris',
            'image' => $productImage,
        ],
        [
            'name' => 'Ikan Teri Kering',
            'category' => 'Hasil Laut',
            'price' => 'Rp45.000',
            'unit' => 'per 500 gram',
            'seller' => 'Kelompok Nelayan Mentuda',
            'description' =>
                'Ikan teri kering hasil olahan warga, cocok untuk lauk harian, sambal, dan kebutuhan dapur.',
            'badge' => 'Produk Unggulan',
            'image' => $productImage,
        ],
        [
            'name' => 'Sambal Ikan Bilis',
            'category' => 'Kuliner',
            'price' => 'Rp30.000',
            'unit' => 'per botol',
            'seller' => 'Mentuda Snack House',
            'description' =>
                'Sambal khas pesisir dengan campuran ikan bilis, pedas gurih, dan siap dikemas sebagai oleh-oleh.',
            'badge' => 'Siap Pesan',
            'image' => $productImage,
        ],
        [
            'name' => 'Anyaman Mini Bahari',
            'category' => 'Kerajinan',
            'price' => 'Rp35.000',
            'unit' => 'per pcs',
            'seller' => 'Anyaman Bahari',
            'description' =>
                'Produk kerajinan tangan berbahan lokal untuk souvenir, dekorasi rumah, dan cendera mata desa.',
            'badge' => 'Handmade',
            'image' => $productImage,
        ],
        [
            'name' => 'Paket Kue Kering Desa',
            'category' => 'Kuliner',
            'price' => 'Rp50.000',
            'unit' => 'per paket',
            'seller' => 'Rumah Kue Mentuda',
            'description' => 'Paket kue kering rumahan untuk acara keluarga, hantaran, dan kebutuhan jamuan desa.',
            'badge' => 'Pre Order',
            'image' => $productImage,
        ],
        [
            'name' => 'Kelapa Muda Mentuda',
            'category' => 'Pertanian',
            'price' => 'Rp12.000',
            'unit' => 'per buah',
            'seller' => 'Petani Lokal',
            'description' => 'Kelapa muda segar dari kebun warga, cocok untuk minuman segar dan kebutuhan acara.',
            'badge' => 'Segar',
            'image' => $productImage,
        ],
    ];

    $featuredProducts = [
        ['name' => 'Kerupuk Ikan Mentuda', 'category' => 'Hasil Laut', 'price' => 'Rp25.000', 'image' => $productImage],
        ['name' => 'Sambal Ikan Bilis', 'category' => 'Kuliner', 'price' => 'Rp30.000', 'image' => $productImage],
        ['name' => 'Anyaman Mini Bahari', 'category' => 'Kerajinan', 'price' => 'Rp35.000', 'image' => $productImage],
    ];

    if ($search !== '') {
        $products = collect($products)
            ->filter(function (array $product) use ($search) {
                return collect([
                    $product['name'],
                    $product['category'],
                    $product['seller'],
                    $product['description'],
                    $product['badge'],
                ])->contains(fn ($value) => stripos((string) $value, $search) !== false);
            })
            ->values()
            ->all();

        $featuredProducts = collect($featuredProducts)
            ->filter(function (array $product) use ($search) {
                return collect([
                    $product['name'],
                    $product['category'],
                    $product['price'],
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
                    <li>Ekonomi Desa</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Toko UMKM</li>
                </ol>
            </nav>

            <div class="max-w-4xl" data-aos="fade-up">
                <h1
                    class="mt-5 max-w-2xl text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-[2rem] lg:leading-tight">
                    Toko UMKM Desa Mentuda
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-50/90">
                    Etalase produk lokal Desa Mentuda yang menampilkan hasil laut, kuliner rumahan,
                    kerajinan, dan produk unggulan warga yang siap dipesan.
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
                            Etalase Produk
                        </span>

                        <h2 class="mt-4 text-2xl font-bold text-gray-900 sm:text-3xl">
                            Produk Unggulan Desa
                        </h2>

                        <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600">
                            Temukan produk UMKM warga Desa Mentuda dan lakukan pemesanan langsung melalui WhatsApp.
                        </p>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        @foreach ($shopStats as $stat)
                            <div
                                class="rounded-[22px] border border-green-100 bg-green-50 p-4 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md hover:shadow-green-100/60">
                                <p class="text-2xl font-bold text-green-800">{{ $stat['value'] }}</p>
                                <p class="mt-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-green-700">
                                    {{ $stat['label'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <article
                        class="group relative mt-10 overflow-hidden rounded-[28px] bg-white shadow-lg ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:ring-green-200">
                        <div class="relative h-[340px] overflow-hidden sm:h-[420px] lg:h-[500px]">
                            <img src="{{ asset('img/bg.jpg') }}" alt="Produk unggulan Desa Mentuda"
                                class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">

                            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/10"></div>

                            <div class="absolute left-5 right-5 bottom-5 text-white md:left-8 md:right-8 md:bottom-8">
                                <div class="mb-4 flex flex-wrap items-center gap-3">
                                    <span
                                        class="inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                                        Produk Pilihan
                                    </span>

                                    <span class="text-sm text-white/90">Hasil Laut</span>
                                    <span class="text-sm text-white/90">Siap Pesan</span>
                                </div>

                                <h3
                                    class="max-w-3xl text-2xl font-bold leading-tight text-white transition duration-300 group-hover:text-green-300 md:text-4xl">
                                    Paket Oleh-Oleh Laut Mentuda
                                </h3>

                                <p class="mt-3 max-w-2xl text-sm leading-7 text-white/85">
                                    Paket produk lokal berisi kerupuk ikan, ikan teri kering, dan sambal khas pesisir.
                                    Cocok untuk oleh-oleh, acara keluarga, dan promosi potensi desa.
                                </p>

                                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, saya ingin memesan Paket Oleh-Oleh Laut Mentuda') }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="mt-5 inline-flex items-center rounded-full bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-green-900/20 transition hover:-translate-y-0.5 hover:bg-green-700">
                                    Pesan via WhatsApp
                                </a>
                            </div>
                        </div>
                    </article>

                    <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($products as $product)
                            <article data-aos="fade-up" data-aos-delay="{{ min(($loop->index % 3) * 80, 160) }}"
                                class="group overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-md shadow-gray-200/60 transition duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-xl hover:shadow-green-100/60">

                                <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-105">

                                    <span
                                        class="absolute left-4 top-4 inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                                        {{ $product['category'] }}
                                    </span>

                                    <span
                                        class="absolute right-4 top-4 inline-flex items-center rounded-full bg-green-700 px-3 py-1 text-xs font-semibold text-white shadow-sm">
                                        {{ $product['badge'] }}
                                    </span>
                                </div>

                                <div class="p-5">
                                    <h3
                                        class="line-clamp-2 text-lg font-bold text-gray-900 transition group-hover:text-green-700">
                                        {{ $product['name'] }}
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        {{ $product['seller'] }}
                                    </p>

                                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">
                                        {{ $product['description'] }}
                                    </p>

                                    <div class="mt-5 flex items-end justify-between gap-3">
                                        <div>
                                            <p class="text-lg font-bold text-green-700">
                                                {{ $product['price'] }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $product['unit'] }}
                                            </p>
                                        </div>

                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, saya ingin memesan produk: ' . $product['name']) }}"
                                            target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center rounded-full bg-green-700 px-4 py-2 text-xs font-semibold text-white transition hover:bg-green-800">
                                            Pesan
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div
                        class="mt-8 rounded-2xl bg-green-50 px-4 py-3 text-sm leading-6 text-green-800 ring-1 ring-green-100">
                        Halaman toko ini dapat dikembangkan menjadi katalog dinamis, keranjang sederhana,
                        detail produk, dan manajemen produk melalui dashboard admin.
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
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 7h18M6 7V5a2 2 0 012-2h8a2 2 0 012 2v2M5 7l1 13h12l1-13" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">
                                Kategori
                            </p>
                            <h2 class="text-lg font-bold text-gray-900">Produk UMKM</h2>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach ($productCategories as $category)
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
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 10v2" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">
                                Pilihan
                            </p>
                            <h2 class="text-lg font-bold text-gray-900">Produk Terlaris</h2>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach ($featuredProducts as $product)
                            <div
                                class="group flex gap-4 rounded-2xl bg-white p-3 ring-1 ring-gray-100 transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-green-100/60 hover:ring-green-200">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                                    class="h-20 w-24 shrink-0 rounded-xl object-cover transition duration-300 group-hover:scale-105">

                                <div class="min-w-0">
                                    <h3
                                        class="line-clamp-2 text-sm font-bold leading-snug text-gray-900 transition group-hover:text-green-700">
                                        {{ $product['name'] }}
                                    </h3>

                                    <div class="mt-2 space-y-1 text-xs text-gray-500">
                                        <p>{{ $product['category'] }}</p>
                                        <p class="font-semibold text-green-700">{{ $product['price'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 7h14M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                        </div>

                        <h2 class="text-lg font-bold">Belanja Produk Lokal</h2>

                        <p class="mt-3 text-sm leading-6 text-white/85">
                            Dukung UMKM Desa Mentuda dengan membeli produk lokal warga secara langsung.
                        </p>

                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, saya ingin bertanya tentang produk UMKM Desa Mentuda') }}"
                            target="_blank" rel="noopener noreferrer"
                            class="mt-6 inline-flex items-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-green-800 transition hover:bg-emerald-50">
                            Hubungi Admin
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
