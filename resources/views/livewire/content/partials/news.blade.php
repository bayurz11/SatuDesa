{{-- ========== GRID BERITA ========== --}}
@if (request()->routeIs('beranda'))
    {{-- === KODE PERTAMA (untuk Landing Page / beranda) === --}}
    <div class="grid md:grid-cols-3 gap-8 items-stretch">
        <!-- Artikel Utama -->
        <div class="md:col-span-2 relative rounded-xl overflow-hidden shadow-lg group flex flex-col h-[390px]"
            data-aos="fade-right" data-aos-delay="500">
            <img src="{{ asset('public/img/potensi1.jpg') }}" alt="Berita Utama"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-6 text-white">
                <h3 class="font-semibold text-lg md:text-xl group-hover:text-white transition">
                    Hasil Panen Ikan Kerapu Melimpah Membantu Perekonomian Masyarakat Desa Mentuda
                </h3>

                <!-- Box Metadata -->
                <div class="absolute bottom-0 right-0 flex justify-start">
                    <div
                        class="bg-white text-green-700 px-4 py-2 rounded-tl-2xl flex items-center gap-4 text-sm shadow-md">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M6 6h.008v.008H6V6Z" />
                            </svg>
                            Berita utama
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            12-12-2024
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Artikel Lainnya -->
        <div class="space-y-5 flex flex-col" data-aos="fade-left" data-aos-delay="600">
            {{-- Item 1 --}}
            <div class="flex items-center space-x-4 p-2 rounded-lg hover:bg-gray-50 transition group cursor-pointer">
                <img src="{{ asset('public/img/potensi1.jpg') }}" alt="thumb"
                    class="w-20 h-16 object-cover rounded-lg shadow-sm transition-transform duration-300 group-hover:scale-105">
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-2">
                        Pembangunan Balai Desa Mentuda Resmi Dimulai, Fasilitas Baru untuk Masyarakat
                    </h4>
                    <div class="flex items-center text-xs text-gray-500 mt-1 space-x-3">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M6 6h.008v.008H6V6Z" />
                            </svg>
                            Berita utama
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            12-12-2024
                        </span>
                    </div>
                </div>
            </div>

            {{-- Item 2 --}}
            <div class="flex items-center space-x-4 p-2 rounded-lg hover:bg-gray-50 transition group cursor-pointer">
                <img src="{{ asset('public/img/potensi2.jpg') }}" alt="thumb"
                    class="w-20 h-16 object-cover rounded-lg shadow-sm transition-transform duration-300 group-hover:scale-105">
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-2">
                        Tradisi Adat Desa Mentuda Tetap Dilestarikan di Era Modern
                    </h4>
                    <div class="flex items-center text-xs text-gray-500 mt-1 space-x-3">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M6 6h.008v.008H6V6Z" />
                            </svg>
                            Berita utama
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            12-12-2024
                        </span>
                    </div>
                </div>
            </div>

            {{-- Item 3 --}}
            <div class="flex items-center space-x-4 p-2 rounded-lg hover:bg-gray-50 transition group cursor-pointer">
                <img src="{{ asset('public/img/potensi1.jpg') }}" alt="thumb"
                    class="w-20 h-16 object-cover rounded-lg shadow-sm transition-transform duration-300 group-hover:scale-105">
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-2">
                        Pelatihan UMKM di Desa Mentuda: Dorong Perekonomian Lokal
                    </h4>
                    <div class="flex items-center text-xs text-gray-500 mt-1 space-x-3">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M6 6h.008v.008H6V6Z" />
                            </svg>
                            Berita utama
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            12-12-2024
                        </span>
                    </div>
                </div>
            </div>

            {{-- Item 4 --}}
            <div class="flex items-center space-x-4 p-2 rounded-lg hover:bg-gray-50 transition group cursor-pointer">
                <img src="{{ asset('public/img/potensi1.jpg') }}" alt="thumb"
                    class="w-20 h-16 object-cover rounded-lg shadow-sm transition-transform duration-300 group-hover:scale-105">
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-2">
                        Gotong Royong Warga Desa Mentuda, Wujudkan Jalan Desa yang Lebih Baik
                    </h4>
                    <div class="flex items-center text-xs text-gray-500 mt-1 space-x-3">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M6 6h.008v.008H6V6Z" />
                            </svg>
                            Berita utama
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            12-12-2024
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- === KODE DINAMIS (halaman berita biasa) === --}}
    <div class="grid gap-8 md:gap-10 lg:grid-cols-3 items-start">
        {{-- MAIN COLUMN --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Featured (ambil item pertama jika ada) --}}
            @if ($items->count() > 0)
                @php
                    /** @var \App\Domains\Post\Models\Post $featured */
                    $featured = $items->first();
                    $featDate = $featured->published_at ?? $featured->created_at;
                    $featCover = $featured->cover_path
                        ? asset('public/storage/' . ltrim($featured->cover_path, '/'))
                        : asset('public/img/potensi1.jpg');

                    $featCategoryName = optional($featured->category)->name;
                    $featHasCat = filled($featCategoryName);
                    $featCategory = $featHasCat ? $featCategoryName : 'Tidak berkategori';
                    $featBadgeClass = $featHasCat ? 'bg-white/95 text-green-700' : 'bg-white/90 text-gray-700';
                @endphp

                <article class="relative overflow-hidden rounded-2xl shadow ring-1 ring-black/5 group"
                    data-aos="fade-right" data-aos-delay="150">
                    <a href="{{ route('berita') }}/{{ $featured->slug }}" class="block">
                        <img src="{{ $featCover }}" alt="{{ $featured->title }}"
                            class="h-[380px] w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                            loading="lazy" decoding="async">
                    </a>

                    <div
                        class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                    </div>

                    <div class="absolute inset-x-0 bottom-0 p-5 md:p-6">
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span
                                class="inline-flex items-center gap-1 rounded-full {{ $featBadgeClass }} px-2.5 py-1 text-xs font-medium ring-1 ring-black/5">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M3 10a4 4 0 004-4h10l4 4-8 8-4-4-6 6" />
                                </svg>
                                {{ $featCategory }}
                            </span>

                            <time
                                class="inline-flex items-center gap-1 rounded-full bg-black/50 px-2.5 py-1 text-xs text-white">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0a9 9 0 0118 0z" />
                                </svg>
                                {{ optional($featDate)?->format('d-m-Y') }}
                            </time>
                        </div>

                        <h2
                            class="text-white text-2xl md:text-3xl font-extrabold leading-snug line-clamp-2 drop-shadow">
                            <a href="{{ route('berita') }}/{{ $featured->slug }}"
                                class="pointer-events-auto group-hover:text-green-200 transition">
                                {{ $featured->title }}
                            </a>
                        </h2>
                        <p class="mt-2 text-white/90 line-clamp-2 pointer-events-auto">{{ $featured->summary }}</p>
                    </div>
                </article>
            @endif

            {{-- Grid sisanya --}}
            <div class="grid gap-6 md:grid-cols-2">
                @foreach ($items->skip(1) as $post)
                    @php
                        /** @var \App\Domains\Post\Models\Post $post */
                        $postCover = $post->cover_path
                            ? asset('public/storage/' . ltrim($post->cover_path, '/'))
                            : asset('public/img/potensi2.jpg');
                        $postDate = $post->published_at ?? $post->created_at;

                        $postCategoryName = optional($post->category)->name;
                        $postHasCat = filled($postCategoryName);
                        $postCat = $postHasCat ? $postCategoryName : 'Tidak berkategori';
                        $postBadgeClass = $postHasCat
                            ? 'bg-green-50 text-green-700 ring-green-200'
                            : 'bg-gray-100 text-gray-700 ring-gray-200';
                    @endphp
                    <article class="rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition">
                        <a href="{{ route('berita') }}/{{ $post->slug }}" class="block">
                            <div class="aspect-[16/9] overflow-hidden rounded-t-xl">
                                <img src="{{ $postCover }}" alt="{{ $post->title }}"
                                    class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.04]"
                                    loading="lazy" decoding="async">
                            </div>
                        </a>
                        <div class="p-4 md:p-5">
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-medium ring-1 {{ $postBadgeClass }}">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M3 10a4 4 0 004-4h10l4 4-8 8-4-4-6 6" />
                                    </svg>
                                    {{ $postCat }}
                                </span>
                                <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0a9 9 0 0118 0z" />
                                    </svg>
                                    {{ optional($postDate)?->format('d-m-Y') }}
                                </time>
                            </div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900 leading-snug line-clamp-2">
                                <a href="{{ route('berita') }}/{{ $post->slug }}" class="hover:text-green-700">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-3">{{ $post->summary }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="pt-4">
                <nav class="flex justify-center" aria-label="Pagination">
                    {{ $items->onEachSide(1)->links() }}
                </nav>
            </div>
        </div>

    </div>
@endif
