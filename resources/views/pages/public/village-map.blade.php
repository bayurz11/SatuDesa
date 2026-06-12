@php
    $metaTitle = 'Peta Desa';
    $metaDescription = 'Informasi koordinat lokasi desa, fasilitas umum, dan titik penting Desa Mentuda.';
    $mapMarkers = collect($profile->map_markers ?? [])->values()->all();
    $hasMapPoint = filled($profile->map_latitude) && filled($profile->map_longitude);
@endphp

@extends('layouts.public')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <section class="relative overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800 text-white mt-16">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.16),_transparent_32%)]">
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <nav class="text-sm text-emerald-100/80" aria-label="Breadcrumb" data-aos="fade-down">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li>Profil Desa</li>
                    <li>/</li>
                    <li class="font-semibold text-white">Peta Desa</li>
                </ol>
            </nav>

            <div class="max-w-4xl" data-aos="fade-up">
                <span
                    class="mt-5 inline-flex items-center rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-50 ring-1 ring-white/15">
                    Profil Desa
                </span>

                <h1
                    class="mt-5 max-w-2xl text-2xl font-bold tracking-tight text-white sm:text-3xl lg:text-[2rem] lg:leading-tight">
                    Peta Desa Mentuda
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-50/90 sm:text-base">
                    Informasi koordinat lokasi {{ $village->name }}, titik fasilitas umum, dan lokasi penting
                    yang membantu masyarakat maupun pengunjung menemukan posisi desa dengan lebih mudah.
                </p>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="mb-8 rounded-[28px] border border-gray-200 bg-white p-5 shadow-xl shadow-gray-200/60 sm:p-6"
            data-aos="fade-up" data-aos-delay="120">
            <div class="grid gap-4 lg:grid-cols-[1.5fr_1fr] lg:items-center">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Informasi</h2>
                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Halaman ini menampilkan ringkasan koordinat peta desa, titik fasilitas umum,
                        dan lokasi penting dengan pola visual yang konsisten dengan halaman berita publik.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl bg-green-50 px-4 py-4">
                        <p class="text-xl font-bold text-green-800">{{ count($mapMarkers) }}</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.2em] text-green-700">Marker Aktif</p>
                    </div>
                    <div class="rounded-2xl bg-emerald-50 px-4 py-4">
                        <p class="text-xl font-bold text-emerald-800">{{ (int) $profile->map_zoom }}</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.2em] text-emerald-700">Zoom Default</p>
                    </div>
                    <div class="rounded-2xl bg-lime-50 px-4 py-4">
                        <p class="text-xl font-bold text-lime-800">Publik</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.2em] text-lime-700">Mode Tampil</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <main class="space-y-8">
                <section data-aos="fade-up" data-aos-delay="100"
                    class="overflow-hidden rounded-[28px] border border-gray-200 bg-white p-4 shadow-lg shadow-gray-200/70 sm:rounded-[32px] sm:p-7">

                    <div class="text-center">
                        <span
                            class="inline-flex items-center rounded-full bg-green-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-green-700 ring-1 ring-green-100">
                            Peta Lokasi
                        </span>

                        <h2 class="mt-4 text-2xl font-bold text-gray-900 sm:text-3xl">
                            {{ $profile->map_title }}
                        </h2>

                        <p class="mx-auto mt-3 max-w-2xl text-sm leading-7 text-gray-600 sm:text-base">
                            {{ $profile->map_description }}
                        </p>
                    </div>

                    <div class="mt-8 overflow-hidden rounded-[24px] border border-gray-200 bg-gray-50 shadow-sm sm:mt-10 sm:rounded-[28px]">
                        @if ($hasMapPoint)
                            <div class="relative min-h-[360px] overflow-hidden bg-green-50 sm:min-h-[460px] lg:min-h-[640px]">
                                <div id="villageMap" class="h-[360px] w-full sm:h-[460px] lg:h-[640px]"></div>

                                <div
                                    class="pointer-events-none absolute left-3 top-3 z-[400] max-w-[calc(100%-1.5rem)] rounded-2xl bg-white/90 px-4 py-3 shadow-lg shadow-gray-900/10 backdrop-blur sm:left-4 sm:top-4">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-green-700">
                                        {{ $village->name }}
                                    </p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900 sm:text-base">
                                        Kec. {{ $village->district }}, Kab. {{ $village->regency }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="flex min-h-[360px] items-center justify-center bg-gradient-to-br from-green-50 to-white p-8 text-center sm:min-h-[460px]">
                                <div class="max-w-xl">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-green-700 ring-1 ring-green-100 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l-6 3V6l6-3 6 3 6-3v15l-6 3-6-3zM9 3v15M15 6v15" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-5 text-xl font-bold text-gray-900">Peta Belum Dikonfigurasi</h3>
                                    <p class="mt-3 text-sm leading-7 text-gray-600">
                                        Koordinat utama desa belum diatur dari panel admin. Setelah lokasi utama ditentukan, peta interaktif dan marker fasilitas umum akan langsung tampil di halaman ini.
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="border-t border-gray-200 bg-white p-4 sm:p-5 lg:p-6">
                            <div class="rounded-2xl bg-green-50 px-4 py-4 text-sm leading-6 text-green-800 ring-1 ring-green-100 sm:px-5">
                                {{ $hasMapPoint
                                    ? 'Peta desa menampilkan titik koordinat utama ' . $village->name . ', marker fasilitas umum, serta dukungan layer peta biasa dan satelit agar lokasi desa lebih mudah dikenali.'
                                    : 'Koordinat utama desa, marker fasilitas umum, dan layer peta akan tersedia setelah konfigurasi peta dilengkapi dari admin.' }}
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                <div data-aos="fade-left" data-aos-delay="200"
                    class="overflow-hidden rounded-[28px] border border-gray-200 bg-white p-4 shadow-md shadow-gray-200/60 sm:p-5">
                    <div class="mb-5 flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">
                                Navigasi
                            </p>
                            <h2 class="text-lg font-bold text-gray-900">Bagian Profil</h2>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('public.history') }}"
                            class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60">
                            <span>Sejarah Desa</span>
                            <span
                                class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-700">&rarr;</span>
                        </a>

                        <a href="{{ route('public.vision-mission') }}"
                            class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60">
                            <span>Visi &amp; Misi</span>
                            <span
                                class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-700">&rarr;</span>
                        </a>

                        <a href="{{ route('public.organization-structure') }}"
                            class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition duration-300 hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md hover:shadow-green-100/60">
                            <span>Struktur Organisasi</span>
                            <span
                                class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-700">&rarr;</span>
                        </a>

                        <a href="{{ route('public.village-map') }}"
                            class="group relative flex items-center justify-between overflow-hidden rounded-2xl bg-green-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-green-700/20 transition duration-300 hover:-translate-y-0.5 hover:bg-green-800 hover:shadow-xl hover:shadow-green-700/30">
                            <span class="absolute inset-y-0 left-0 w-1 bg-white/70"></span>
                            <span class="relative">Peta Desa</span>
                            <span class="relative transition duration-300 group-hover:translate-x-1">&rarr;</span>
                        </a>
                    </div>
                </div>

                @if (!empty($mapMarkers))
                    <div class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-md shadow-gray-200/60"
                        data-aos="fade-left" data-aos-delay="250">
                        <h2 class="text-lg font-bold text-gray-900">Titik Penting</h2>

                        <div class="mt-5 space-y-4">
                            @foreach (collect($mapMarkers)->take(3) as $marker)
                                <div
                                    class="group flex gap-4 rounded-2xl bg-white p-3 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-green-200">
                                    <div
                                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 21s7-4.438 7-11a7 7 0 10-14 0c0 6.562 7 11 7 11z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 10.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <h3
                                            class="line-clamp-2 text-sm font-bold leading-snug text-gray-900 transition-colors duration-300 group-hover:text-green-700 md:text-base">
                                            {{ $marker['name'] ?? 'Titik Lokasi' }}
                                        </h3>

                                        <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                            <span>{{ $marker['category'] ?? 'Lokasi' }}</span>
                                            <span>{{ $marker['latitude'] ?? '-' }}, {{ $marker['longitude'] ?? '-' }}</span>
                                        </div>

                                        @if (!empty($marker['description']))
                                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                                {{ $marker['description'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div data-aos="fade-left" data-aos-delay="300"
                    class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 p-5 text-white shadow-lg shadow-green-900/20 sm:p-6">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-12 -left-12 h-36 w-36 rounded-full bg-black/10"></div>

                    <div class="relative">
                        <div
                            class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 21s7-4.438 7-11a7 7 0 10-14 0c0 6.562 7 11 7 11z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 10.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                            </svg>
                        </div>

                        <h2 class="text-lg font-bold">Lokasi Desa</h2>

                        <p class="mt-3 text-sm leading-6 text-white/85">
                            {{ $hasMapPoint
                                ? 'Peta desa membantu masyarakat dan pengunjung mengenal koordinat lokasi, fasilitas umum, serta titik penting yang ada di ' . $village->name . '.'
                                : 'Panel ini akan menampilkan gambaran lokasi desa setelah titik koordinat utama dan marker publik dilengkapi dari admin.' }}
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    @if ($hasMapPoint)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const villageLat = {{ (float) $profile->map_latitude }};
                const villageLng = {{ (float) $profile->map_longitude }};
                const villageZoom = {{ (int) $profile->map_zoom }};
                const markers = @json($mapMarkers);
                const mapNode = document.getElementById('villageMap');

                if (!mapNode || typeof L === 'undefined') {
                    return;
                }

            const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            });

            const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri'
            });

            const map = L.map(mapNode, {
                scrollWheelZoom: false,
                layers: [satelliteLayer],
            }).setView([villageLat, villageLng], villageZoom);

            L.control.layers({
                'Peta Biasa': streetLayer,
                'Satelit': satelliteLayer,
            }, {}, {
                collapsed: false,
            }).addTo(map);

            const mainMarker = L.marker([villageLat, villageLng])
                .addTo(map)
                .bindPopup(`
                    <div style="min-width:180px">
                        <strong>{{ e($profile->map_popup_title) }}</strong><br>
                        {{ e($profile->map_popup_description) }}
                    </div>
                `)
                .openPopup();

            markers.forEach((marker) => {
                if (marker.latitude === undefined || marker.longitude === undefined || !marker.name) {
                    return;
                }

                const popupDescription = marker.description ? `<br>${marker.description}` : '';

                L.marker([marker.latitude, marker.longitude])
                    .addTo(map)
                    .bindPopup(`
                        <div style="min-width:180px">
                            <strong>${marker.name}</strong>${popupDescription}
                        </div>
                    `);
            });

            setTimeout(function() {
                map.invalidateSize();
            }, 300);

            window.addEventListener('load', function() {
                setTimeout(function() {
                    map.invalidateSize();
                    map.setView([villageLat, villageLng], villageZoom);
                    mainMarker.openPopup();
                }, 450);
            });

            window.addEventListener('resize', function() {
                setTimeout(function() {
                    map.invalidateSize();
                    map.setView([villageLat, villageLng], map.getZoom());
                }, 150);
            });
            });
        </script>
    @endif
@endsection
