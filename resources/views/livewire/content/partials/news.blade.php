<div class="grid gap-8 md:gap-10 lg:grid-cols-3 items-start">
    <div class="lg:col-span-2 space-y-8">
        {{-- Featured (ambil item pertama jika ada) --}}
        @if ($items->count() > 0)
            @php $featured = $items->first(); @endphp
            <article class="relative overflow-hidden rounded-2xl shadow ring-1 ring-black/5 group">
                <a href="{{ route('berita') }}/{{ $featured->slug }}" class="block">
                    <img src="{{ $featured->cover_url ?? asset('public/img/potensi1.jpg') }}"
                        class="h-[380px] w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                        alt="{{ $featured->title }}" loading="lazy" decoding="async">
                </a>
                <div
                    class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                </div>
                <div class="absolute inset-x-0 bottom-0 p-5 md:p-6">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-white/95 px-2.5 py-1 text-xs font-medium text-green-700 ring-1 ring-black/5">
                            {{-- tag icon --}}
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M3 10a4 4 0 004-4h10l4 4-8 8-4-4-6 6" />
                            </svg>
                            Berita Utama
                        </span>
                        <time
                            class="inline-flex items-center gap-1 rounded-full bg-black/50 px-2.5 py-1 text-xs text-white">
                            {{-- clock --}}
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0a9 9 0 0118 0z" />
                            </svg>
                            {{ $featured->published_at?->format('d-m-Y') }}
                        </time>
                    </div>

                    <h2 class="text-white text-2xl md:text-3xl font-extrabold leading-snug line-clamp-2 drop-shadow">
                        <a href="{{ route('berita') }}/{{ $featured->slug }}"
                            class="pointer-events-auto group-hover:text-green-200 transition">{{ $featured->title }}</a>
                    </h2>
                    <p class="mt-2 text-white/90 line-clamp-2 pointer-events-auto">{{ $featured->summary }}</p>
                </div>
            </article>
        @endif

        {{-- Grid sisanya --}}
        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($items->skip(1) as $post)
                <article class="rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition">
                    <a href="{{ route('berita') }}/{{ $post->slug }}" class="block">
                        <div class="aspect-[16/9] overflow-hidden rounded-t-xl">
                            <img src="{{ $post->cover_url ?? asset('public/img/potensi2.jpg') }}"
                                alt="{{ $post->title }}"
                                class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.04]"
                                loading="lazy" decoding="async">
                        </div>
                    </a>
                    <div class="p-4 md:p-5">
                        <div class="mb-2 flex flex-wrap items-center gap-2">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                {{-- tag icon --}}
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M3 10a4 4 0 004-4h10l4 4-8 8-4-4-6 6" />
                                </svg>
                                {{ $post->category->name ?? 'Berita' }}
                            </span>
                            <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                                {{-- clock --}}
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0a9 9 0 0118 0z" />
                                </svg>
                                {{ $post->published_at?->format('d-m-Y') }}
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

        <div class="pt-4">
            <nav class="flex justify-center" aria-label="Pagination">
                {{ $items->onEachSide(1)->links() }}
            </nav>
        </div>
    </div>

    {{-- Sidebar ringkas --}}
    <aside class="lg:sticky lg:top-20 space-y-6">
        {{-- taruh widget terbaru / kategori, dsb --}}
    </aside>
</div>
