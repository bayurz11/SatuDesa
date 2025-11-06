@php
    // pastikan model Struktur punya accessor getFotoUrlAttribute()
    // agar $m->foto_url mengarah ke asset('public/' . $m->foto)
    $img = fn($m) => $m?->foto_url ?? asset('public/img/avatars/default-person.png');
    $nameOr = fn($m, $fallback) => $m?->nama ?: $fallback;
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
                        <img src="{{ $img($pimpinan) }}" alt="Kepala Desa" class="h-full w-full object-cover"
                            loading="lazy" />
                    </div>
                    <h3 class="text-lg font-semibold text-green-700">Kepala Desa</h3>
                    <p class="text-gray-600">{{ $nameOr($pimpinan, 'Nama Kepala Desa') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sekretariat --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                        <x-heroicon-o-briefcase class="size-6 text-green-700" />
                    </span>
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Sekretariat</h2>
                </div>
                <span
                    class="inline-flex items-center rounded-full bg-emerald-400 px-3 py-1 text-xs font-medium text-white">
                    Struktural
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                {{-- Sekretaris --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($sekretaris) }}" alt="Sekretaris Desa" class="h-full w-full object-cover"
                            loading="lazy">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Sekretaris Desa</h3>
                    <p class="text-gray-600">{{ $nameOr($sekretaris, 'Nama Sekretaris') }}</p>
                </div>

                {{-- Kaur Keuangan --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kaurKeuangan) }}" alt="Kaur Keuangan" class="h-full w-full object-cover"
                            loading="lazy">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kaur Keuangan</h3>
                    <p class="text-gray-600">{{ $nameOr($kaurKeuangan, 'Nama Kaur Keuangan') }}</p>
                </div>

                {{-- Kaur Umum & Perencanaan --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kaurUmumPerencanaan) }}" alt="Kaur Umum & Perencanaan"
                            class="h-full w-full object-cover" loading="lazy">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kaur Umum &amp; Perencanaan</h3>
                    <p class="text-gray-600">{{ $nameOr($kaurUmumPerencanaan, 'Nama Kaur Umum & Perencanaan') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kasi --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                        <x-heroicon-o-clipboard-document-list class="size-6 text-green-700" />
                    </span>
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Kasi</h2>
                </div>
                <span
                    class="inline-flex items-center rounded-full bg-emerald-400 px-3 py-1 text-xs font-medium text-white">
                    Struktural
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                {{-- Kasi Pemerintahan --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kasiPemerintahan) }}" alt="Kasi Pemerintahan"
                            class="h-full w-full object-cover" loading="lazy">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kasi Pemerintahan</h3>
                    <p class="text-gray-600">{{ $nameOr($kasiPemerintahan, 'Nama Kasi Pemerintahan') }}</p>
                </div>

                {{-- Kasi Kesejahteraan --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kasiKesejahteraan) }}" alt="Kasi Kesejahteraan"
                            class="h-full w-full object-cover" loading="lazy">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kasi Kesejahteraan</h3>
                    <p class="text-gray-600">{{ $nameOr($kasiKesejahteraan, 'Nama Kasi Kesejahteraan') }}</p>
                </div>

                {{-- Kasi Pelayanan --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kasiPelayanan) }}" alt="Kasi Pelayanan" class="h-full w-full object-cover"
                            loading="lazy">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kasi Pelayanan</h3>
                    <p class="text-gray-600">{{ $nameOr($kasiPelayanan, 'Nama Kasi Pelayanan') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kepala Dusun --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200">
                        <x-heroicon-o-map class="size-6 text-green-700" />
                    </span>
                    <h2 class="text-xl md:text-2xl font-semibold text-gray-900">Kepala Dusun</h2>
                </div>
                <span
                    class="inline-flex items-center rounded-full bg-lime-500 px-3 py-1 text-xs font-medium text-white">
                    Kewilayahan
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                {{-- Kadus Mentuda --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kadusMentuda) }}" alt="Kepala Dusun Mentuda"
                            class="h-full w-full object-cover" loading="lazy">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kadus Mentuda</h3>
                    <p class="text-gray-600">{{ $nameOr($kadusMentuda, 'Nama Kadus Mentuda') }}</p>
                </div>

                {{-- Kadus Pulun & Jelutung --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kadusPulunJelutung) }}" alt="Kepala Dusun Pulun & Jelutung"
                            class="h-full w-full object-cover" loading="lazy">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kadus Pulun &amp; Jelutung</h3>
                    <p class="text-gray-600">{{ $nameOr($kadusPulunJelutung, 'Nama Kadus Pulun & Jelutung') }}</p>
                </div>

                {{-- Kadus Tembok & Mentengah --}}
                <div class="rounded-xl border border-gray-200 p-6 text-center hover:shadow-md transition">
                    <div class="mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-1 ring-black/5">
                        <img src="{{ $img($kadusTembokMentengah) }}" alt="Kepala Dusun Tembok & Mentengah"
                            class="h-full w-full object-cover" loading="lazy">
                    </div>
                    <h3 class="text-base font-semibold text-green-700">Kadus Tembok &amp; Mentengah</h3>
                    <p class="text-gray-600">{{ $nameOr($kadusTembokMentengah, 'Nama Kadus Tembok & Mentengah') }}</p>
                </div>
            </div>
        </div>
    </div>

</article>
