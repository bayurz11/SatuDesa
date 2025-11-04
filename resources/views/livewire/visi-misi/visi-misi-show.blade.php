<article class="lg:col-span-2 space-y-8">

    @php
        // Ambil isi & status secara aman (tidak melempar error saat null)
        $visiIsi = data_get($visi, 'isi'); // null jika tidak ada
        $visiActive = (bool) data_get($visi, 'is_active', false);

        $misiIsi = (string) data_get($misi, 'isi', ''); // string kosong jika tidak ada
        $misiActive = (bool) data_get($misi, 'is_active', false);

        // Parse <li> hanya kalau ada isi
        $items = [];
        if (filled($misiIsi)) {
            preg_match_all('/<li[^>]*>(.*?)<\/li>/si', $misiIsi, $m);
            $items = array_map(fn($v) => trim($v), $m[1] ?? []);
        }
    @endphp

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
                @if ($visiActive && filled($visiIsi))
                    {!! $visiIsi !!}
                @else
                    <p class="text-gray-700">Belum ada data visi yang aktif.</p>
                @endif
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

            @if ($misiActive && filled($misiIsi))
                @if (count($items))
                    <ul role="list" class="not-prose space-y-3 md:space-y-4">
                        @foreach ($items as $line)
                            <li class="flex items-start gap-2.5 sm:gap-3">
                                <x-heroicon-o-check-circle
                                    class="not-prose shrink-0 mt-[2px] w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" />
                                <span
                                    class="flex-1 text-[15px] leading-6 sm:text-base sm:leading-7 text-gray-800 [&_p]:m-0 [&_strong]:font-semibold [&_strong]:text-gray-900">
                                    {!! $line !!}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{-- Jika tidak ada <li>, tampilkan apa adanya --}}
                    <div class="prose max-w-none">{!! $misiIsi !!}</div>
                @endif
            @else
                <p class="text-gray-700">Belum ada data misi yang aktif.</p>
            @endif

        </div>
    </div>

</article>
