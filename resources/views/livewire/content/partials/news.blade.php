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

            <article class="relative overflow-hidden rounded-2xl shadow ring-1 ring-black/5 group" data-aos="fade-right"
                data-aos-delay="150">
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
                            {{-- tag icon --}}
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
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

                    <h2 class="text-white text-2xl md:text-3xl font-extrabold leading-snug line-clamp-2 drop-shadow">
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
                                {{-- tag icon --}}
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                {{ $postCat }}
                            </span>
                            <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                                {{-- clock --}}
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

    </div>

    {{-- SIDEBAR --}}
    <aside class="lg:sticky lg:top-20 space-y-6" data-aos="fade-left" data-aos-delay="200">
        {{-- Search --}}
        <form action="{{ url()->current() }}" method="GET" class="bg-white rounded-xl shadow p-4">
            <label for="q" class="sr-only">Cari Berita</label>
            <div class="relative">
                <input id="q" name="q" type="search" placeholder="Cari berita berdasarkan judul…"
                    value="{{ request('q') }}"
                    class="w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-sm placeholder:text-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-500"
                    autocomplete="off">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3 top-1/2 -translate-y-1/2 size-5 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                </svg>
            </div>
        </form>

        {{-- Kategori --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h4 class="font-semibold text-gray-900 mb-3">Kategori</h4>

            @php
                $activeCat = request('category');
                $cats = $categories ?? collect();
            @endphp

            @if ($cats->count() === 0)
                <p class="text-sm text-gray-500">
                    Kategori belum tersedia. Semua postingan akan ditampilkan.
                </p>
            @else
                <div class="flex flex-wrap gap-2">
                    <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => null]) }}"
                        class="px-3 py-1.5 rounded-lg text-sm border {{ $activeCat ? 'border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white' : 'bg-green-600 border-green-600 text-white' }} transition">
                        Semua
                    </a>

                    @foreach ($cats as $cat)
                        @php
                            $catKey = $cat->slug ?? $cat->id;
                            $isActive = (string) $activeCat === (string) $catKey;
                        @endphp
                        <a href="{{ request()->fullUrlWithQuery(['category' => $catKey, 'page' => null]) }}"
                            class="px-3 py-1.5 rounded-lg text-sm border {{ $isActive ? 'bg-green-600 border-green-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white' }} transition">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Terbaru --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h4 class="font-semibold text-gray-900 mb-3">Terbaru</h4>
            @php
                // Tentukan list berita terbaru
                $latestList = collect(); // default kosong

                if (isset($latest) && $latest instanceof \Illuminate\Support\Collection) {
                    $latestList = $latest->take(3);
                } elseif (isset($items)) {
                    // Jika $items adalah LengthAwarePaginator / Paginator
                    $latestList =
                        $items instanceof \Illuminate\Pagination\AbstractPaginator
                            ? $items->take(3)
                            : (is_iterable($items)
                                ? collect($items)->take(3)
                                : collect());
                }
            @endphp

            @if ($latestList->isEmpty())
                <div class="text-center text-gray-500 italic py-6">
                    Belum ada berita yang ditambahkan.
                </div>
            @else
                @foreach ($latestList as $post)
                    <div class="flex gap-4">
                        <img src="{{ $post->cover_url ?? asset('public/img/default-news.jpg') }}"
                            alt="{{ $post->title }}" class="w-24 h-24 object-cover rounded-lg">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $post->title }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ optional($post->published_at)->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="space-y-3">
                @forelse ($latestList as $lp)
                    @php
                        $thumb = $lp->cover_path
                            ? asset('public/storage/' . ltrim($lp->cover_path, '/'))
                            : asset('public/img/potensi1.jpg');
                        $ldate = $lp->published_at ?? $lp->created_at;

                        $lcatName = optional($lp->category)->name;
                        $lcat = filled($lcatName) ? $lcatName : 'Tidak berkategori';
                    @endphp
                    <a href="{{ route('berita') }}/{{ $lp->slug }}"
                        class="flex items-center gap-3 rounded-lg p-2 hover:bg-gray-50 transition">
                        <img src="{{ $thumb }}" alt="Thumb {{ $lp->title }}"
                            class="h-16 w-20 rounded-md object-cover ring-1 ring-black/5" loading="lazy"
                            decoding="async">
                        <div class="min-w-0">
                            <h5 class="text-sm font-medium text-gray-900 line-clamp-2 hover:text-green-700">
                                {{ $lp->title }}
                            </h5>
                            <div class="mt-1 flex items-center gap-3 text-xs text-gray-500">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 6h.008v.008H6V6Z" />
                                    </svg>
                                    {{ $lcat }}
                                </span>
                                <time class="inline-flex items-center gap-1">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0a9 9 0 0118 0z" />
                                    </svg>
                                    {{ optional($ldate)?->format('d-m-Y') }}
                                </time>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-gray-500">Belum ada data terbaru.</p>
                @endforelse
            </div>
        </div>
    </aside>
</div>
