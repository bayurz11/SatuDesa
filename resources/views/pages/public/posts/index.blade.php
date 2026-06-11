@php
    $metaTitle = 'Berita Desa';
    $metaDescription = 'Daftar berita terbaru Desa Mentuda untuk warga dan pengunjung website publik.';
@endphp

@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white mt-16">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-up">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Informasi</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Berita</li>
                </ol>
            </nav>

            <div class="mt-8 max-w-3xl" data-aos="fade-up" data-aos-delay="100">
                <h1 class="mt-6 text-2xl font-bold tracking-tight sm:text-5xl">
                    Berita Desa Mentuda
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                    Informasi terbaru seputar kegiatan desa, pembangunan, pelayanan publik,
                    UMKM, dan agenda resmi Pemerintah Desa Mentuda.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto -mt-10 max-w-7xl px-4 pb-14 sm:px-6 lg:px-8 z-10 relative">
        <div class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-xl shadow-gray-200/60 sm:p-6"
            data-aos="fade-up" data-aos-delay="150">
            <form method="GET" action="{{ route('public.posts.index') }}"
                class="grid gap-4 lg:grid-cols-[1.6fr_0.8fr_auto]">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-gray-700">Cari berita</span>
                    <input type="text" name="q" value="{{ $search }}"
                        placeholder="Cari judul, ringkasan, atau isi berita..."
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-100">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-gray-700">
                        Kategori
                    </span>

                    @php
                        $selectedCategory = $categories->firstWhere('slug', $category);
                    @endphp

                    <details class="group relative">
                        <summary
                            class="flex w-full cursor-pointer list-none items-center justify-between rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 transition duration-200 hover:border-green-300 hover:bg-white focus:outline-none focus:ring-2 focus:ring-green-100">

                            <span class="truncate font-medium">
                                {{ $selectedCategory?->name ?? 'Semua kategori' }}
                            </span>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 shrink-0 text-gray-400 transition duration-300 group-open:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>

                        <div
                            class="absolute left-0 right-0 z-50 mt-2 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl shadow-gray-200/60">

                            {{-- Semua kategori --}}
                            <button type="submit" name="category" value=""
                                class="flex w-full items-center justify-between px-4 py-3 text-left text-sm transition hover:bg-green-50 hover:text-green-700 {{ empty($category) ? 'bg-green-50 font-semibold text-green-700' : 'text-gray-700' }}">

                                <span>Semua kategori</span>

                                @if (empty($category))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                            </button>

                            @foreach ($categories as $postCategory)
                                <button type="submit" name="category" value="{{ $postCategory->slug }}"
                                    class="flex w-full items-center justify-between border-t border-gray-100 px-4 py-3 text-left text-sm transition hover:bg-green-50 hover:text-green-700 {{ $category === $postCategory->slug ? 'bg-green-50 font-semibold text-green-700' : 'text-gray-700' }}">

                                    <span class="truncate">
                                        {{ $postCategory->name }}
                                    </span>

                                    @if ($category === $postCategory->slug)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </details>
                </label>

                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-2xl bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-green-800 hover:shadow-lg lg:w-auto">
                        Tampilkan
                    </button>

                    @if ($search !== '' || $category !== '')
                        <a href="{{ route('public.posts.index') }}"
                            class="inline-flex w-full items-center justify-center rounded-2xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 lg:w-auto">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px]">
            <main>
                @if ($featuredPost)
                    <article data-aos="fade-up" data-aos-delay="80"
                        class="group relative overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:ring-green-200 lg:col-span-8">
                        <a href="{{ route('public.posts.show', $featuredPost->slug) }}"
                            class="relative block h-[360px] md:h-[520px]">
                            <img src="{{ $featuredPost->cover_image_url ?: asset('img/bg.jpg') }}"
                                alt="{{ $featuredPost->cover_image_alt ?: $featuredPost->title }}"
                                class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">

                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/35 to-black/10"></div>

                            <div class="absolute left-5 right-5 bottom-5 text-white md:left-8 md:right-8 md:bottom-8">
                                <div class="mb-4 flex flex-wrap items-center gap-3">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 0 0 3.182 0l4.318-4.318a2.25 2.25 0 0 0 0-3.182L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        </svg>
                                        {{ $featuredPost->category->name ?? 'Berita' }}
                                    </span>

                                    <span class="inline-flex items-center gap-1.5 text-sm text-white/90">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                        </svg>
                                        {{ optional($featuredPost->published_at)->format('d-m-Y') }}
                                    </span>
                                </div>

                                <h3
                                    class="max-w-3xl text-2xl font-bold leading-tight text-white transition-all duration-300 group-hover:text-green-300 group-hover:drop-shadow-lg md:text-4xl">
                                    {{ $featuredPost->title }}
                                </h3>

                                <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/85 md:text-sm">
                                    {{ $featuredPost->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($featuredPost->content), 180) }}
                                </p>
                            </div>
                        </a>
                    </article>
                @endif

                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    @forelse ($posts as $post)
                        <article data-aos="fade-up" data-aos-delay="{{ min(($loop->index % 2) * 80, 160) }}"
                            class="group overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-md shadow-gray-200/60 transition hover:-translate-y-1 hover:shadow-xl">
                            <a href="{{ route('public.posts.show', $post->slug) }}" class="block">
                                <div
                                    class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                    <img src="{{ $post->cover_image_url ?: asset('img/bg.jpg') }}"
                                        alt="{{ $post->cover_image_alt ?: $post->title }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-105">

                                    <span
                                        class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 0 0 3.182 0l4.318-4.318a2.25 2.25 0 0 0 0-3.182L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        </svg>
                                        {{ $post->category->name ?? 'Berita Desa' }}
                                    </span>
                                </div>

                                <div class="p-5">
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                        </svg>
                                        <span>{{ optional($post->published_at)->format('d-m-Y') }}</span>
                                    </div>

                                    <h3
                                        class="mt-3 line-clamp-2 text-lg font-bold tracking-tight text-gray-900 transition group-hover:text-green-700">
                                        {{ $post->title }}
                                    </h3>

                                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">
                                        {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 130) }}
                                    </p>
                                </div>
                            </a>
                        </article>
                    @empty
                        <div class="md:col-span-2" data-aos="fade-up">
                            <div class="rounded-[28px] border border-dashed border-gray-300 bg-white p-10 text-center">
                                <h3 class="text-lg font-semibold text-gray-900">Belum ada berita ditemukan</h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    Coba ubah kata kunci pencarian atau pilih kategori lain.
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if ($posts->hasPages())
                    <div class="mt-10" data-aos="fade-up">
                        {{ $posts->links() }}
                    </div>
                @endif
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60"
                    data-aos="fade-left" data-aos-delay="120">
                    <h2 class="text-lg font-bold text-gray-900">Kategori Berita</h2>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('public.posts.index') }}"
                            class="inline-flex items-center rounded-full border px-4 py-2 text-sm transition {{ $category === '' ? 'border-green-700 bg-green-700 text-white' : 'border-gray-200 text-gray-700 hover:border-green-200 hover:bg-green-50 hover:text-green-700' }}">
                            Semua
                        </a>

                        @foreach ($categories as $postCategory)
                            <a href="{{ route('public.posts.index', ['category' => $postCategory->slug]) }}"
                                class="inline-flex items-center rounded-full border px-4 py-2 text-sm transition {{ $category === $postCategory->slug ? 'border-green-700 bg-green-700 text-white' : 'border-gray-200 text-gray-700 hover:border-green-200 hover:bg-green-50 hover:text-green-700' }}">
                                {{ $postCategory->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60"
                    data-aos="fade-left" data-aos-delay="180">
                    <h2 class="text-lg font-bold text-gray-900">Berita Terbaru</h2>

                    <div class="mt-5 space-y-4">
                        @foreach ($latestPosts as $latestPost)
                            <a href="{{ route('public.posts.show', $latestPost->slug) }}" data-aos="fade-left"
                                data-aos-delay="{{ 60 + $loop->index * 50 }}"
                                class="group flex gap-4 rounded-2xl bg-white p-3 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-green-200">
                                <img src="{{ $latestPost->cover_image_url ?: asset('img/bg.jpg') }}"
                                    alt="{{ $latestPost->cover_image_alt ?: $latestPost->title }}"
                                    class="h-20 w-24 shrink-0 rounded-xl object-cover transition-transform duration-300 group-hover:scale-105">

                                <div class="min-w-0">
                                    <h3
                                        class="line-clamp-2 text-sm font-bold leading-snug text-gray-900 transition-colors duration-300 group-hover:text-green-700 md:text-base">
                                        {{ $latestPost->title }}
                                    </h3>

                                    <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                        <span class="inline-flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 0 0 3.182 0l4.318-4.318a2.25 2.25 0 0 0 0-3.182L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                            </svg>
                                            {{ $latestPost->category->name ?? 'Berita Desa' }}
                                        </span>

                                        <span class="inline-flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                            </svg>
                                            {{ optional($latestPost->published_at)->format('d-m-Y') }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="220"
                    class="rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <h2 class="text-lg font-bold">Butuh informasi cepat?</h2>
                    <p class="mt-3 text-sm leading-6 text-white/85">
                        Pantau berita terbaru, pembaruan layanan, dan agenda penting Desa Mentuda secara berkala.
                    </p>
                    <a href="{{ route('home') }}"
                        class="mt-6 inline-flex items-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-green-800 transition hover:bg-emerald-50">
                        Kembali ke Beranda
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection
