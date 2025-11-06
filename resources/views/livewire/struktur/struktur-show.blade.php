@php
    $img = fn($m, $fallback) => $m?->foto_url ?? asset($fallback);
    $nameOr = fn($m, $fallback) => $m?->nama ?: $fallback;
    $fallback = asset('img/avatars/default-person.png');
@endphp

<article class="lg:col-span-2 space-y-8">

    {{-- Kepala Desa --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                        <x-heroicon-o-user class="size-6 text-green-700" />
                    </span>
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Kepala Desa</h2>
                </div>
                <span
                    class="inline-flex items-center rounded-full bg-green-600 px-3 py-1 text-xs font-medium text-white">
                    Pimpinan
                </span>
            </div>

            <div class="flex justify-center">
                <div class="text-center">
                    <div class="mx-auto mb-4 h-28 w-28 overflow-hidden rounded-full ring-1 ring-black/5">


                        <img src="{{ $pimpinan?->foto_url ?: $fallback }}" alt="Kepala Desa"
                            class="h-full w-full object-cover" loading="lazy" />
                        {{ asset('public/' . $pimpinan->foto_url) }}
                    </div>
                    <h3 class="text-lg font-semibold text-green-700">Kepala Desa</h3>
                    <p class="text-gray-600">{{ $nameOr($pimpinan, 'Nama Kepala Desa') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sekretaris & Bendahara --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                        <x-heroicon-o-briefcase class="size-6 text-green-700" />
                    </span>
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Sekretariat & Keuangan</h2>
                </div>
                <span
                    class="inline-flex items-center rounded-full bg-emerald-400 px-3 py-1 text-xs font-medium text-white">
                    Struktural
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Sekretaris --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($sekretariat, 'public/img/user2.jpg') }}" alt="Sekretaris Desa"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Sekretaris Desa</h3>
                    <p class="text-gray-600">{{ $nameOr($sekretariat, 'Nama Sekretaris') }}</p>
                </div>

                {{-- Bendahara --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($bendahara, 'public/img/user3.jpg') }}" alt="Bendahara Desa"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Bendahara Desa</h3>
                    <p class="text-gray-600">{{ $nameOr($bendahara, 'Nama Bendahara') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kepala Urusan --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                        <x-heroicon-o-clipboard-document-list class="size-6 text-green-700" />
                    </span>
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Kepala Urusan</h2>
                </div>
                <span
                    class="inline-flex items-center rounded-full bg-emerald-400 px-3 py-1 text-xs font-medium text-white">
                    Struktural
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                {{-- Kaur Umum --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kaurUmum, 'public/img/user1.jpg') }}" alt="Kaur Umum"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kaur Umum</h3>
                    <p class="text-gray-600">{{ $nameOr($kaurUmum, 'Nama Kaur Umum') }}</p>
                </div>

                {{-- Kaur Keuangan --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kaurKeuangan, 'public/img/user2.jpg') }}" alt="Kaur Keuangan"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kaur Keuangan</h3>
                    <p class="text-gray-600">{{ $nameOr($kaurKeuangan, 'Nama Kaur Keuangan') }}</p>
                </div>

                {{-- Kaur Pembangunan --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kaurPembangunan, 'public/img/user3.jpg') }}" alt="Kaur Pembangunan"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kaur Pembangunan</h3>
                    <p class="text-gray-600">{{ $nameOr($kaurPembangunan, 'Nama Kaur Pembangunan') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Ketua RT & RW --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                        <x-heroicon-o-home-modern class="size-6 text-green-700" />
                    </span>
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Ketua RT &amp; RW</h2>
                </div>
                <span
                    class="inline-flex items-center rounded-full bg-lime-400 px-3 py-1 text-xs font-medium text-white">
                    Kewilayahan
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                {{-- RW 01 --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-16 w-16 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($rw01, 'public/img/user2.jpg') }}" alt="RW 01"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-sm font-semibold text-green-700">Ketua RW 01</h3>
                    <p class="text-gray-600">{{ $nameOr($rw01, 'Nama RW 01') }}</p>
                </div>

                {{-- RW 02 --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-16 w-16 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($rw02, 'public/img/user2.jpg') }}" alt="RW 02"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-sm font-semibold text-green-700">Ketua RW 02</h3>
                    <p class="text-gray-600">{{ $nameOr($rw02, 'Nama RW 02') }}</p>
                </div>

                {{-- RT 01 --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-16 w-16 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($rt01, 'public/img/user4.jpg') }}" alt="RT 01"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-sm font-semibold text-green-700">Ketua RT 01</h3>
                    <p class="text-gray-600">{{ $nameOr($rt01, 'Nama RT 01') }}</p>
                </div>

                {{-- RT 02 --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-16 w-16 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($rt02, 'public/img/user4.jpg') }}" alt="RT 02"
                            class="h-full w-full object-cover" loading="lazy" decoding="async">
                    </div>
                    <h3 class="text-sm font-semibold text-green-700">Ketua RT 02</h3>
                    <p class="text-gray-600">{{ $nameOr($rt02, 'Nama RT 02') }}</p>
                </div>
            </div>
        </div>
    </div>

</article>
