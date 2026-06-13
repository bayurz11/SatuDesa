@php
    $active = $active ?? 'history';

    $profileNavItems = [
        [
            'key' => 'history',
            'label' => 'Sejarah Desa',
            'route' => route('public.history'),
            'icon' => 'M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z',
        ],
        [
            'key' => 'vision-mission',
            'label' => 'Visi & Misi',
            'route' => route('public.vision-mission'),
            'icon' => 'M9 12l2 2 4-4M12 3l7 4v5c0 5-3 8-7 9-4-1-7-4-7-9V7l7-4z',
        ],
        [
            'key' => 'organization-structure',
            'label' => 'Struktur Organisasi',
            'route' => route('public.organization-structure'),
            'icon' => 'M12 6a3 3 0 110 6 3 3 0 010-6zM5 21a7 7 0 0114 0M4 8a2 2 0 114 0M16 8a2 2 0 114 0',
        ],
        [
            'key' => 'village-map',
            'label' => 'Peta Desa',
            'route' => route('public.village-map'),
            'icon' => 'M9 18l-6 3V6l6-3 6 3 6-3v15l-6 3-6-3zM9 3v15M15 6v15',
        ],
    ];
@endphp

<div class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-md shadow-gray-200/60" data-aos="fade-left" data-aos-delay="{{ $delay ?? 220 }}">
    <div class="mb-5 flex items-center gap-3">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
            </svg>
        </div>

        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">Navigasi</p>
            <h2 class="text-lg font-bold text-gray-900">Bagian Profil</h2>
        </div>
    </div>

    <div class="space-y-3">
        @foreach ($profileNavItems as $item)
            @php
                $isActive = $active === $item['key'];
            @endphp
            <a href="{{ $item['route'] }}"
                class="{{ $isActive
                    ? 'group relative flex items-center justify-between overflow-hidden rounded-2xl bg-green-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-green-700/20 transition duration-300 hover:-translate-y-0.5 hover:bg-green-800 hover:shadow-xl hover:shadow-green-700/30'
                    : 'group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60' }}">
                <span class="relative flex items-center gap-3">
                    <span
                        class="{{ $isActive
                            ? 'flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 text-white'
                            : 'flex h-9 w-9 items-center justify-center rounded-xl bg-gray-50 text-green-700 ring-1 ring-gray-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                        </svg>
                    </span>
                    <span>{{ $item['label'] }}</span>
                </span>
                <span class="{{ $isActive ? 'relative transition duration-300 group-hover:translate-x-1' : 'text-gray-400 transition duration-300 group-hover:translate-x-1 group-hover:text-green-700' }}">&rarr;</span>
            </a>
        @endforeach
    </div>
</div>
