<article class="lg:col-span-2 space-y-6">
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-center mb-6">
                @php
                    $logo = $sejarah?->gambar
                        ? asset('storage/' . $sejarah->gambar)
                        : 'https://linggakab.go.id/resources/config/icon_256.png';
                @endphp
                <img src="{{ $logo }}" alt="Logo Desa Mentuda"
                    class="w-10 h-10 md:w-24 md:h-24 rounded-lg object-contain  shadow-sm" loading="lazy" decoding="async">
            </div>

            <div class="mx-auto mb-6 h-1 w-24 rounded-full bg-green-600"></div>

            <div
                class="prose prose-sm md:prose-base max-w-none prose-headings:font-semibold prose-a:text-green-700 prose-strong:text-gray-900 prose-p:text-gray-700">
                {!! $sejarah?->isi !!}
            </div>

            @if ($sejarah && $sejarah->relationLoaded('timelines') && $sejarah->timelines->isNotEmpty())
                <div class="not-prose mt-8">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-3">Linimasa Singkat</h2>
                    <ol class="relative border-s border-gray-200">
                        @foreach ($sejarah->timelines as $item)
                            <li class="ms-4 pb-5 last:pb-0">
                                <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full bg-green-600"></div>
                                <time class="mb-1 text-xs font-medium text-green-700">{{ $item->label_waktu }}</time>
                                <p class="text-gray-700">{{ $item->deskripsi }}</p>
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endif
            {{-- Timeline ringkas (elemen visual konsisten) --}}
            <div class="not-prose mt-8">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-3">Linimasa Singkat</h2>
                <ol class="relative border-s border-gray-200">
                    <li class="ms-4 pb-5">
                        <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full bg-green-600"></div>
                        <time class="mb-1 text-xs font-medium text-green-700">Abad ke-18</time>
                        <p class="text-gray-700">Pemukiman awal dan penamaan “Mentuda”.</p>
                    </li>
                    <li class="ms-4 pb-5">
                        <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full bg-green-600"></div>
                        <time class="mb-1 text-xs font-medium text-green-700">Masa Kolonial</time>
                        <p class="text-gray-700">Persinggahan pedagang; akulturasi budaya.</p>
                    </li>
                    <li class="ms-4 pb-5">
                        <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full bg-green-600"></div>
                        <time class="mb-1 text-xs font-medium text-green-700">Pasca 1945</time>
                        <p class="text-gray-700">Pembangunan infrastruktur & layanan publik.</p>
                    </li>
                    <li class="ms-4">
                        <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full bg-green-600"></div>
                        <time class="mb-1 text-xs font-medium text-green-700">Kini</time>
                        <p class="text-gray-700">Pelestarian tradisi seiring adaptasi modern.</p>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <blockquote class="rounded-xl border border-green-200 bg-green-50/60 p-5 md:p-6 text-green-900 shadow-sm">
        <p class="text-sm md:text-base leading-relaxed">
            {{ $sejarah?->kutipan ?? '“Gotong royong adalah napas Desa Mentuda—menguatkan persatuan, menjaga tradisi, dan membuka jalan kemajuan.”' }}
        </p>
    </blockquote>
</article>
