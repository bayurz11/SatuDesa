<div class="grid gap-8 lg:grid-cols-3 items-start">
    <article class="lg:col-span-2 space-y-4">
        @forelse ($items as $item)
            <div
                class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5 transition hover:shadow-md">
                <div class="p-5 md:p-6 flex flex-col sm:flex-row sm:items-start gap-4">
                    {{-- Badge tanggal --}}
                    <div class="shrink-0">
                        @php
                            $dayName = optional($item->start_at ?? $item->published_at)->translatedFormat('l') ?? '-';
                            $day = optional($item->start_at ?? $item->published_at)->format('d') ?? '--';
                            $month = optional($item->start_at ?? $item->published_at)->translatedFormat('M Y') ?? '--';
                        @endphp
                        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-2 text-center">
                            <p class="text-xs font-medium text-green-700">{{ $dayName }}</p>
                            <p class="text-lg font-extrabold text-green-700 leading-none">{{ $day }}</p>
                            <p class="text-xs font-medium text-green-700">{{ $month }}</p>
                        </div>
                    </div>

                    {{-- Isi --}}
                    <div class="flex-1 min-w-0">
                        <div class="mb-1 flex flex-wrap items-center gap-2">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                {{-- icon bell --}}
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                Pengumuman
                            </span>
                            @if ($item->start_at)
                                <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                                    {{-- icon clock --}}
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0a9 9 0 0118 0z" />
                                    </svg>
                                    {{ $item->start_at->format('d M Y • H:i') }}
                                </time>
                            @endif
                        </div>

                        <h2 class="text-base md:text-lg font-semibold text-gray-900 leading-snug">
                            <a href="{{ route('pengumuman') }}/{{ $item->slug }}" class="hover:text-green-700">
                                {{ $item->title }}
                            </a>
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $item->summary }}</p>

                        <div class="mt-3 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                            @if ($item->location)
                                <span class="inline-flex items-center gap-1">
                                    {{-- map pin --}}
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 11a3 3 0 100-6 3 3 0 000 6z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.5 10.5c0 7.5-7.5 10.5-7.5 10.5S4.5 18 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    {{ $item->location }}
                                </span>
                            @endif
                            @if ($item->organizer)
                                <span class="inline-flex items-center gap-1">
                                    {{-- user --}}
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A9 9 0 1118.88 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $item->organizer }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="sm:self-center">
                        <a href="{{ route('pengumuman') }}/{{ $item->slug }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                            {{-- eye --}}
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0a3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7c-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada pengumuman.</p>
        @endforelse

        {{-- Pagination khusus kolom utama --}}
        <div class="pt-2 flex justify-center">
            {{ $items->onEachSide(1)->links() }}
        </div>
    </article>

    {{-- SIDEBAR contoh sederhana --}}
    <aside class="space-y-6 lg:sticky lg:top-20">
        {{-- bisa isi widget ringkas di sini --}}
    </aside>
</div>
