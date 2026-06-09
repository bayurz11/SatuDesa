@php
    $metaTitle = $post->meta_title ?: $post->title;
    $metaDescription =
        $post->meta_description ?: ($post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 160));
    $shareUrl = url()->current();
    $shareTitle = $post->title;
    $shareText = trim(($post->excerpt ?: $post->title) . ' - ' . $shareUrl);
@endphp

@extends('layouts.public')

@section('content')
    <style>
        .article-content .ql-ui {
            display: none;
        }
    </style>

    <script>
        async function sharePost(url, title, text) {
            const statusElement = document.getElementById('share-status');

            if (navigator.share) {
                try {
                    await navigator.share({
                        title,
                        text,
                        url,
                    });
                    if (statusElement) {
                        statusElement.textContent = 'Berita berhasil dibagikan.';
                    }
                    return;
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }
                }
            }

            if (navigator.clipboard?.writeText) {
                await navigator.clipboard.writeText(url);
                if (statusElement) {
                    statusElement.textContent = 'Tautan berita berhasil disalin.';
                }
                return;
            }

            window.prompt('Salin tautan berita ini:', url);
        }

        async function copyShareLink(url) {
            const statusElement = document.getElementById('share-status');

            if (navigator.clipboard?.writeText) {
                await navigator.clipboard.writeText(url);
                if (statusElement) {
                    statusElement.textContent = 'Tautan berita berhasil disalin.';
                }
                return;
            }

            window.prompt('Salin tautan berita ini:', url);
        }
    </script>

    <section class="relative overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white mt-16">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-up">
                <ol class="flex flex-wrap items-center gap-2">
                    <li>
                        <a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a>
                    </li>
                    <li>/</li>
                    <li>
                        <a href="{{ route('public.posts.index') }}" class="transition hover:text-white">Berita</a>
                    </li>
                    <li>/</li>
                    <li class="line-clamp-1 font-semibold text-white">{{ $post->title }}</li>
                </ol>
            </nav>

            <div class="mt-8 max-w-4xl" data-aos="fade-up" data-aos-delay="100">
                <div class="mb-5 flex flex-wrap items-center gap-3">
                    @if ($post->category)
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-green-700 backdrop-blur ring-1 ring-white/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 0 0 3.182 0l4.318-4.318a2.25 2.25 0 0 0 0-3.182L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            </svg>
                            {{ $post->category->name }}
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-1.5 text-sm text-emerald-50/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                        </svg>
                        {{ optional($post->published_at)->format('d-m-Y') }}
                    </span>

                    @if ($post->author)
                        <span class="inline-flex items-center gap-1.5 text-sm text-emerald-50/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 0 1 15 0" />
                            </svg>
                            {{ $post->author->name }}
                        </span>
                    @endif
                </div>

                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl sm:leading-tight">
                    {{ $post->title }}
                </h1>

                @if ($post->excerpt)
                    <p class="mt-4 max-w-3xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                        {{ $post->excerpt }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <section class="mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8 z-10 relative">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px]">
            <main>
                <article
                    data-aos="fade-up" data-aos-delay="140"
                    class="overflow-hidden rounded-[28px] border border-gray-200 bg-white shadow-xl shadow-gray-200/60">

                    <div class="relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200" data-aos="zoom-in"
                        data-aos-delay="180">
                        @if ($post->cover_image_url)
                            <img src="{{ $post->cover_image_url }}" alt="{{ $post->cover_image_alt ?: $post->title }}"
                                class="max-h-[560px] w-full object-cover">
                        @else
                            <div
                                class="flex min-h-[380px] items-end bg-gradient-to-br from-green-800 via-green-700 to-emerald-600 p-8 text-white">
                                <div>
                                    <span
                                        class="inline-flex rounded-full bg-white/15 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-white/90 ring-1 ring-white/20">
                                        Berita Desa Mentuda
                                    </span>
                                    <h2 class="mt-4 max-w-3xl text-3xl font-bold leading-tight">
                                        {{ $post->title }}
                                    </h2>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($post->cover_image_caption)
                        <p class="border-b border-gray-100 bg-gray-50 px-6 py-3 text-center text-sm text-gray-500"
                            data-aos="fade-up" data-aos-delay="120">
                            {{ $post->cover_image_caption }}
                        </p>
                    @endif

                    <div class="p-6 sm:p-10" data-aos="fade-up" data-aos-delay="200">
                        <div
                            class="article-content prose prose-lg max-w-none
                            prose-headings:font-bold
                            prose-headings:text-gray-900
                            prose-p:leading-8
                            prose-p:text-gray-700
                            prose-a:font-semibold
                            prose-a:text-green-700
                            prose-strong:text-gray-900
                            prose-ul:list-disc
                            prose-ol:list-decimal
                            prose-li:my-1
                            prose-li:marker:text-green-600
                            prose-img:rounded-2xl
                            prose-img:shadow-lg
                            prose-blockquote:border-l-4
                            prose-blockquote:border-green-700
                            prose-blockquote:bg-green-50
                            prose-blockquote:px-5
                            prose-blockquote:py-3
                            prose-blockquote:text-gray-700">
                            {!! $post->content !!}
                        </div>
                    </div>

                    <div
                        data-aos="fade-up" data-aos-delay="240"
                        class="border-t border-gray-100 bg-gradient-to-r from-emerald-50 via-white to-green-50 px-6 py-6 sm:px-10">
                        <div
                            class="flex flex-col gap-5 rounded-[24px] border border-emerald-100 bg-white/90 p-5 shadow-sm shadow-emerald-100/60 sm:p-6">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-600">
                                        Sebarkan Informasi
                                    </p>
                                    <h2 class="mt-1 text-xl font-bold text-gray-900">Bagikan berita ini ke warga lain</h2>
                                    <p class="mt-2 text-sm leading-6 text-gray-600">
                                        Gunakan tombol di bawah untuk membagikan artikel atau menyalin tautannya.
                                    </p>
                                </div>

                                <div
                                    class="inline-flex w-fit items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    {{ optional($post->published_at)->translatedFormat('d F Y') }}
                                </div>
                            </div>

                            <div class="grid gap-3 md:grid-cols-3">
                                <button type="button"
                                    data-aos="fade-up" data-aos-delay="60"
                                    onclick="sharePost('{{ $shareUrl }}', '{{ e($shareTitle) }}', '{{ e($shareText) }}')"
                                    class="group inline-flex items-center justify-center gap-3 rounded-2xl bg-green-700 px-4 py-4 text-sm font-semibold text-white shadow-lg shadow-green-700/20 transition duration-300 hover:-translate-y-1 hover:bg-green-800 hover:shadow-xl hover:shadow-green-700/30">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/15 transition group-hover:scale-110 group-hover:bg-white/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.195.023.394.036.596.036a6.75 6.75 0 0 0 5.834-3.36m-6.43 5.51a6.75 6.75 0 0 1 6.43 5.51m0-11.02a2.25 2.25 0 1 0 2.186 0m-2.186 11.02a2.25 2.25 0 1 0 2.186 0" />
                                        </svg>
                                    </span>
                                    <span class="text-left">
                                        <span class="block">Bagikan Sekarang</span>
                                        <span class="block text-xs font-medium text-white/80">Gunakan menu share perangkat</span>
                                    </span>
                                </button>

                                <a href="https://wa.me/?text={{ urlencode($shareText) }}" target="_blank" rel="noopener noreferrer"
                                    data-aos="fade-up" data-aos-delay="120"
                                    class="group inline-flex items-center justify-center gap-3 rounded-2xl border border-green-200 bg-green-50 px-4 py-4 text-sm font-semibold text-green-700 transition duration-300 hover:-translate-y-1 hover:border-green-300 hover:bg-green-100 hover:shadow-lg hover:shadow-green-100">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 transition group-hover:scale-110 group-hover:bg-green-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 12A9.75 9.75 0 1 1 5.67 4.56L3.75 20.25l5.37-1.71A9.75 9.75 0 0 1 21.75 12Z" />
                                        </svg>
                                    </span>
                                    <span class="text-left">
                                        <span class="block">WhatsApp</span>
                                        <span class="block text-xs font-medium text-green-600/80">Kirim ke grup atau kontak</span>
                                    </span>
                                </a>

                                <button type="button" onclick="copyShareLink('{{ $shareUrl }}')"
                                    data-aos="fade-up" data-aos-delay="180"
                                    class="group inline-flex items-center justify-center gap-3 rounded-2xl border border-gray-200 bg-white px-4 py-4 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-1 hover:border-gray-300 hover:bg-gray-50 hover:shadow-lg hover:shadow-gray-200/70">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 transition group-hover:scale-110 group-hover:bg-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125H6.375a1.125 1.125 0 0 1-1.125-1.125V9.375c0-.621.504-1.125 1.125-1.125H9.75m6 0h2.625c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125H9.375A1.125 1.125 0 0 1 8.25 17.625V9.375c0-.621.504-1.125 1.125-1.125H15.75Zm0 0V5.625c0-.621-.504-1.125-1.125-1.125h-3.75c-.621 0-1.125.504-1.125 1.125V8.25h6Z" />
                                        </svg>
                                    </span>
                                    <span class="text-left">
                                        <span class="block">Salin Tautan</span>
                                        <span class="block text-xs font-medium text-gray-500">Tempel ke media apa pun</span>
                                    </span>
                                </button>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <p id="share-status" class="min-h-6 text-sm font-medium text-emerald-700"></p>
                                <p class="text-xs leading-5 text-gray-500">
                                    Tautan aktif: <span class="font-semibold text-gray-700">{{ $shareUrl }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </article>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60"
                    data-aos="fade-left" data-aos-delay="160">
                    <h2 class="text-lg font-bold text-gray-900">Informasi Artikel</h2>

                    <dl class="mt-5 space-y-5 text-sm">
                        <div class="border-b border-gray-100 pb-4">
                            <dt class="font-semibold text-gray-500">Tanggal Publikasi</dt>
                            <dd class="mt-2">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-amber-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                    </svg>

                                    {{ optional($post->published_at)->translatedFormat('d F Y, H:i') }}
                                </span>
                            </dd>
                        </div>

                        @if ($post->author)
                            <div class="border-b border-gray-100 pb-4">
                                <dt class="font-semibold text-gray-500">Penulis</dt>
                                <dd class="mt-2">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-blue-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>

                                        {{ $post->author->name }}
                                    </span>
                                </dd>
                            </div>
                        @endif
                        @if ($post->category)
                            <div>
                                <dt class="font-semibold text-gray-500">Kategori</dt>
                                <dd class="mt-2">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700 ring-1 ring-green-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 0 0 3.182 0l4.318-4.318a2.25 2.25 0 0 0 0-3.182L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        </svg>

                                        <span>{{ $post->category->name ?? 'Berita Desa' }}</span>
                                    </span>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                @if ($relatedPosts->isNotEmpty())
                    <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60"
                        data-aos="fade-left" data-aos-delay="220">
                        <h2 class="text-lg font-bold text-gray-900">Berita Terkait</h2>

                        <div class="mt-5 space-y-4">
                            @foreach ($relatedPosts as $relatedPost)
                                <a href="{{ route('public.posts.show', $relatedPost->slug) }}"
                                    data-aos="fade-left" data-aos-delay="{{ 60 + ($loop->index * 50) }}"
                                    class="group flex gap-4 rounded-2xl bg-white p-3 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-green-200">
                                    <img src="{{ $relatedPost->cover_image_url ?: asset('img/bg.jpg') }}"
                                        alt="{{ $relatedPost->cover_image_alt ?: $relatedPost->title }}"
                                        class="h-20 w-24 shrink-0 rounded-xl object-cover transition-transform duration-300 group-hover:scale-105">

                                    <div class="min-w-0">
                                        <h3
                                            class="line-clamp-2 text-sm font-bold leading-snug text-gray-900 transition-colors duration-300 group-hover:text-green-700 md:text-base">
                                            {{ $relatedPost->title }}
                                        </h3>

                                        <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                            <span class="inline-flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 0 0 3.182 0l4.318-4.318a2.25 2.25 0 0 0 0-3.182L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                                </svg>
                                                {{ $relatedPost->category->name ?? 'Berita Desa' }}
                                            </span>

                                            <span class="inline-flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                                                </svg>
                                                {{ optional($relatedPost->published_at)->format('d-m-Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div
                    data-aos="fade-left" data-aos-delay="260"
                    class="rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-6 text-white shadow-lg shadow-green-900/20">
                    <h2 class="text-lg font-bold">Butuh informasi cepat?</h2>
                    <p class="mt-3 text-sm leading-6 text-white/85">
                        Pantau berita terbaru, pembaruan layanan, dan agenda penting Desa Mentuda secara berkala.
                    </p>
                    <a href="{{ route('public.posts.index') }}"
                        class="mt-6 inline-flex items-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-green-800 transition hover:bg-emerald-50">
                        Lihat Semua Berita
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection
