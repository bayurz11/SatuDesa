<article class="lg:col-span-2 space-y-8">

    {{-- Kartu Visi --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="p-6 md:p-8">
            <div class="flex items-center gap-3 mb-4">
                <span
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                    <x-heroicon-o-eye class="size-6 text-green-700" />
                </span>
                <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Visi</h2>
            </div>
            <div class="mx-auto mb-6 h-1 w-20 rounded-full bg-green-600"></div>

            {{-- Visi --}}
            <div class="prose max-w-none trix-view">
                {!! $visi?->isi ?? '<p class="text-gray-700">Belum ada data visi yang aktif.</p>' !!}
            </div>
        </div>
    </div>

    {{-- Kartu Misi --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="p-6 md:p-8">
            <div class="flex items-center gap-3 mb-4">
                <span
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                    <x-heroicon-o-flag class="size-6 text-green-700" />
                </span>
                <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Misi</h2>
            </div>
            <div class="mx-auto mb-6 h-1 w-20 rounded-full bg-green-600"></div>
            @php
                preg_match_all('/<li[^>]*>(.*?)<\/li>/si', $misi->isi ?? '', $m);
                $items = array_map(fn($v) => trim($v), $m[1] ?? []);
            @endphp

            @if (count($items))
                <ul role="list" class="not-prose space-y-3 md:space-y-4"> {{-- cegah efek prose --}}
                    @foreach ($items as $line)
                        <li class="flex items-start gap-2.5 sm:gap-3">
                            {{-- ikon tidak dipengaruhi prose, tidak menyusut --}}
                            <x-heroicon-o-check-circle
                                class="not-prose shrink-0 mt-[2px] w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" />
                            <span
                                class="flex-1 text-[15px] leading-6 sm:text-base sm:leading-7 text-gray-800
                 [&_p]:m-0 [&_strong]:font-semibold [&_strong]:text-gray-900">
                                {!! $line !!}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="prose max-w-none">{!! $misi->isi !!}</div>
            @endif

        </div>
    </div>

</article>
