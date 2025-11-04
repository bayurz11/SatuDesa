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

            <div class="prose max-w-none prose-green">
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

            @if ($misi)
                {{-- Jika konten misi disimpan dalam HTML (ul/li atau <p>) --}}
                <div class="prose max-w-none prose-green">
                    {!! $misi->isi !!}
                </div>

                {{-- Atau, jika kamu menyimpan misi sebagai teks baris-per-baris (tanpa <li>), pakai versi list berikut: --}}
                {{--
                @php
                    $items = preg_split("/\r\n|\n|\r/", trim(strip_tags($misi->isi)));
                @endphp
                <ul class="grid gap-3 md:gap-4">
                    @foreach ($items as $line)
                        @if (trim($line) !== '')
                            <li class="flex items-start gap-3">
                                <x-heroicon-o-check-circle class="mt-0.5 size-5 text-green-600" />
                                <span class="text-gray-700">{{ $line }}</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
                --}}
            @else
                <p class="text-gray-700">Belum ada data misi yang aktif.</p>
            @endif
        </div>
    </div>

</article>
