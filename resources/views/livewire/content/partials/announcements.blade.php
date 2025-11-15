{{-- GRID UTAMA --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    {{-- KOLOM UTAMA --}}
    <div class="lg:col-span-8">
        @forelse ($items as $item)
            @php
                $dateRef = $item->start_at ?? $item->published_at;
                $dayName = optional($dateRef)?->translatedFormat('l') ?? '-';
                $dayNum = optional($dateRef)?->format('d') ?? '--';
                $monYr = optional($dateRef)?->translatedFormat('M Y') ?? '--';
                $timeStr = optional($dateRef)?->translatedFormat('d F Y • H:i');
                $detailUrl = route('pengumuman.show', $item->slug);
            @endphp

            <div
                class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5 transition hover:shadow-md mb-6 last:mb-0">

                <div class="p-5 md:p-6 flex flex-col sm:flex-row sm:items-start gap-4">

                    {{-- Tanggal Badge --}}
                    <div class="shrink-0">
                        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-2 text-center">
                            <p class="text-xs font-medium text-green-700">{{ $dayName }}</p>
                            <p class="text-lg font-extrabold text-green-700 leading-none">{{ $dayNum }}</p>
                            <p class="text-xs font-medium text-green-700">{{ $monYr }}</p>
                        </div>
                    </div>

                    {{-- Isi --}}
                    <div class="flex-1 min-w-0">
                        <div class="mb-1 flex flex-wrap items-center gap-2">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                                <x-heroicon-o-bell class="size-4" /> Pengumuman
                            </span>

                            @if ($timeStr)
                                <time class="inline-flex items-center gap-1 text-xs text-gray-500">
                                    <x-heroicon-o-clock class="size-4" /> {{ $timeStr }}
                                </time>
                            @endif
                        </div>

                        <h2 class="text-base md:text-lg font-semibold text-gray-900 leading-snug">
                            <a href="{{ $detailUrl }}" class="hover:text-green-700">
                                {{ $item->title }}
                            </a>
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                            {{ $item->summary }}
                        </p>

                        <div class="mt-3 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                            @if ($item->location)
                                <span class="inline-flex items-center gap-1">
                                    <x-heroicon-o-map-pin class="size-4" /> {{ $item->location }}
                                </span>
                            @endif

                            @if ($item->organizer)
                                <span class="inline-flex items-center gap-1">
                                    <x-heroicon-o-user class="size-4" /> {{ $item->organizer }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="sm:self-center mt-4 sm:mt-0 w-full sm:w-auto">
                        <a href="{{ $detailUrl }}"
                            class="w-full sm:w-auto inline-flex justify-center items-center gap-2 rounded-lg bg-green-600 text-white px-4 py-2 text-sm font-medium hover:bg-green-700 hover:shadow-md transition duration-200 md:px-5 md:py-2.5 md:text-base">
                            <x-heroicon-o-eye class="size-4 md:size-5" />
                            <span>Baca Selengkapnya</span>
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="rounded-xl border border-gray-200 bg-white p-6 text-gray-600">
                Belum ada pengumuman.
            </div>
        @endforelse
    </div>

    {{-- SIDEBAR --}}
    <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-20">

        {{-- Pencarian --}}
        <div role="search" class="bg-white rounded-xl shadow p-4">
            <label for="search-q" class="sr-only">
                Cari {{ $title ?? 'Konten' }}
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <input id="search-q" type="text" wire:model.live="search"
                    onkeydown="if (event.key === 'Enter') event.preventDefault();"
                    placeholder="Cari judul / ringkasan / tag / kategori…"
                    class="block w-full pl-12 pr-24 py-3 border border-gray-300 rounded-xl bg-white placeholder-gray-500
                           focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" />

                @if (!empty($search))
                    <button type="button" wire:click="$set('search','')"
                        class="absolute inset-y-0 right-10 my-2 px-2 text-gray-500 hover:text-gray-700">
                        Bersihkan
                    </button>
                @endif

                <div wire:loading.delay wire:target="search" class="absolute inset-y-0 right-3 flex items-center">
                    <svg class="animate-spin h-5 w-5 text-gray-400" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="font-semibold text-gray-900 mb-3">Filter</h3>
            <div class="flex flex-wrap gap-2">
                <a href="#"
                    class="px-3 py-1.5 rounded-lg text-sm border bg-green-600 border-green-600 text-white">Semua</a>
                <a href="#"
                    class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Umum</a>
                <a href="#"
                    class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Kesehatan</a>
                <a href="#"
                    class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Pendidikan</a>
                <a href="#"
                    class="px-3 py-1.5 rounded-lg text-sm border border-gray-300 text-gray-700 hover:bg-green-600 hover:text-white transition">Agenda</a>
            </div>
        </div>

        {{-- Agenda Terdekat --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="font-semibold text-gray-900 mb-3">Agenda Terdekat</h3>
            <ul class="space-y-3 text-sm">
                <li class="flex items-start gap-3">
                    <x-heroicon-o-calendar class="mt-0.5 size-5 text-green-700" />
                    <div>
                        <p class="font-medium text-gray-900">Musyawarah Desa</p>
                        <p class="text-gray-500">25 September 2025 — Balai Desa</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <x-heroicon-o-megaphone class="mt-0.5 size-5 text-green-700" />
                    <div>
                        <p class="font-medium text-gray-900">Sosialisasi Kesehatan</p>
                        <p class="text-gray-500">27 September 2025 — Posyandu</p>
                    </div>
                </li>
            </ul>
        </div>

    </aside>
</div>
