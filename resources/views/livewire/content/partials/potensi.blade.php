<div class="grid gap-8 lg:grid-cols-3 items-start">
    <article class="lg:col-span-2 space-y-8">
        {{-- Highlight --}}
        @if ($items->count() > 0)
            @php $first = $items->first(); @endphp
            <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                <div class="grid md:grid-cols-12 gap-0">
                    <figure class="md:col-span-7 h-56 md:h-72 overflow-hidden">
                        <img src="{{ $first->cover_url ?? asset('public/img/potensi2.jpg') }}" alt="{{ $first->title }}"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </figure>
                    <div class="md:col-span-5 p-6 md:p-8 flex flex-col justify-center">
                        <span
                            class="inline-flex items-center gap-1 w-fit rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                            {{-- sparkles --}}
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3l2 7l-6 4l7 1l2 7l3-6l7-2l-6-3l1-7l-5 5z" />
                            </svg>
                            Sorotan
                        </span>
                        <h2 class="mt-3 text-xl md:text-2xl font-semibold text-gray-900">{{ $first->title }}</h2>
                        <p class="mt-2 text-gray-700 line-clamp-3">{{ $first->summary }}</p>
                        <div class="mt-4">
                            <a href="{{ route('potensi-desa') }}/{{ $first->slug }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                {{-- eye --}}
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0a3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7c-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Grid potensi --}}
        <div class="grid gap-6 sm:grid-cols-2">
            @foreach ($items->skip(1) as $p)
                <div class="group rounded-2xl bg-white shadow ring-1 ring-black/5 overflow-hidden">
                    <div class="aspect-[16/9] bg-gray-100">
                        <img src="{{ $p->cover_url ?? asset('public/img/potensi1.jpg') }}" alt="{{ $p->title }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale"
                            loading="lazy" decoding="async">
                    </div>
                    <div class="p-4">
                        <div class="mb-1 flex flex-wrap items-center gap-2">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                {{-- tag --}}
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M3 10a4 4 0 004-4h10l4 4-8 8-4-4-6 6" />
                                </svg>
                                {{ $p->category->name ?? 'Potensi' }}
                            </span>
                        </div>
                        <h3 class="text-sm md:text-base font-semibold text-gray-900">{{ $p->title }}</h3>
                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $p->summary }}</p>

                        <div class="mt-3 flex items-center justify-between">
                            <a href="{{ route('potensi-desa') }}/{{ $p->slug }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-1.5 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                                {{-- eye --}}
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0a3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7c-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pt-4">
            <nav class="flex justify-center" aria-label="Pagination">
                {{ $items->onEachSide(1)->links() }}
            </nav>
        </div>
    </article>

    <aside class="space-y-6 lg:sticky lg:top-20">
        {{-- sidebar ringkas --}}
    </aside>
</div>
