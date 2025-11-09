@php
    /** @var \Illuminate\Support\Collection<int, \App\Domains\Post\Models\Post> $news */
    $hasNews = isset($news) && $news->count() > 0;
@endphp

<div class="grid md:grid-cols-3 gap-8 items-stretch">
    {{-- Artikel Utama --}}
    <div class="md:col-span-2 relative rounded-xl overflow-hidden shadow-lg group flex flex-col h-[390px]"
        data-aos="fade-right" data-aos-delay="500">
        <div class="md:col-span-2">
            @if ($hasNews)
                @php
                    /** @var \App\Domains\Post\Models\Post $featured */
                    $featured = $news->first();
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
            @else
                <div
                    class="relative overflow-hidden rounded-2xl ring-1 ring-black/5 bg-gray-100 h-[380px] grid place-items-center text-gray-500">
                    Belum ada berita.
                </div>
            @endif
        </div>

    </div>

    {{-- Artikel Lainnya --}}
    <div class="space-y-5 flex flex-col" data-aos="fade-left" data-aos-delay="600">
        @foreach ($news->skip(1) as $post)
            @php
                $thumb = $post->cover_path
                    ? asset('public/storage/' . ltrim($post->cover_path, '/'))
                    : asset('public/img/potensi2.jpg');
                $pDate = $post->published_at ?? $post->created_at;
                $catName = optional($post->category)->name;
                $cat = filled($catName) ? $catName : 'Tidak berkategori';
            @endphp

            <a href="{{ route('berita') }}/{{ $post->slug }}"
                class="flex items-center space-x-4 p-2 rounded-lg hover:bg-gray-50 transition group cursor-pointer">
                <img src="{{ $thumb }}" alt="thumb {{ $post->title }}"
                    class="w-20 h-16 object-cover rounded-lg shadow-sm transition-transform duration-300 group-hover:scale-105"
                    loading="lazy" decoding="async">
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-2">
                        {{ $post->title }}
                    </h4>
                    <div class="flex items-center text-xs text-gray-500 mt-1 space-x-3">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                            </svg>
                            {{ $cat }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0a9 9 0 0 1 18 0Z" />
                            </svg>
                            {{ optional($pDate)?->format('d-m-Y') }}
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
