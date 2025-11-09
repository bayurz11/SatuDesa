@php
    /** @var \Illuminate\Support\Collection<int, \App\Domains\Post\Models\Post> $news */
    $hasNews = isset($news) && $news->count() > 0;
@endphp

<div class="grid md:grid-cols-3 gap-8 items-stretch">
    {{-- Artikel Utama --}}
    <div class="md:col-span-2 relative rounded-xl overflow-hidden shadow-lg group flex flex-col h-[390px]"
        data-aos="fade-right" data-aos-delay="500">
        @if ($hasNews)
            @php
                $featured = $news->first();
                $featDate = $featured->published_at ?? $featured->created_at;
                $featCover = $featured->cover_path
                    ? asset('public/storage/' . ltrim($featured->cover_path, '/'))
                    : asset('public/img/potensi1.jpg');
                $featCategoryName = optional($featured->category)->name;
                $featHasCat = filled($featCategoryName);
                $featCategory = $featHasCat ? $featCategoryName : 'Tidak berkategori';
            @endphp

            <a href="{{ route('berita') }}/{{ $featured->slug }}" class="block absolute inset-0">
                <img src="{{ $featCover }}" alt="{{ $featured->title }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    loading="lazy" decoding="async">
            </a>

            {{-- Overlay Judul + Gradient --}}
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-6 text-white">
                <h3 class="font-semibold text-lg md:text-xl group-hover:text-white transition line-clamp-2">
                    <a href="{{ route('berita') }}/{{ $featured->slug }}" class="pointer-events-auto">
                        {{ $featured->title }}
                    </a>
                </h3>

                {{-- Box Metadata --}}
                <div class="absolute bottom-0 right-0 flex justify-start">
                    <div
                        class="bg-white text-green-700 px-4 py-2 rounded-tl-2xl flex items-center gap-4 text-sm shadow-md">
                        {{-- Kategori --}}
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                            </svg>
                            {{ $featCategory }}
                        </span>
                        {{-- Tanggal --}}
                        <span class="flex items-center gap-1 text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0a9 9 0 0 1 18 0Z" />
                            </svg>
                            {{ optional($featDate)?->format('d-m-Y') }}
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="absolute inset-0 grid place-items-center bg-gray-100 text-gray-500">
                Belum ada berita.
            </div>
        @endif
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
