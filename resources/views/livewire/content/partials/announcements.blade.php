{{-- KOLOM UTAMA --}}

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

            {{-- Tanggal badge --}}
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

                {{-- Meta opsional --}}
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
