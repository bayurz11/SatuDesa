@extends('layouts.app2')

@section('title', 'Peta Desa')

@section('content')
    <section class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 py-10 md:py-14" data-aos="fade-up">

        {{-- Breadcrumb --}}
        <nav class="mb-6 mt-8 md:mb-8 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('beranda') }}" class="hover:text-green-700">Beranda</a></li>
                <li aria-hidden="true">/</li>
                <li class="text-green-700 font-medium">Peta Desa</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <header class="text-center mb-10 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-green-700">
                Peta Desa Mentuda
            </h1>
            <p class="mt-3 md:mt-4 text-gray-600 md:text-lg max-w-2xl mx-auto">
                Jelajahi wilayah Desa Mentuda, lokasi fasilitas umum, serta titik UMKM pada peta interaktif ini.
            </p>
        </header>

        <div class="grid gap-8 lg:grid-cols-3 items-start">
            {{-- KONTEN UTAMA --}}
            <article class="lg:col-span-2 space-y-6">

                {{-- Kartu Peta --}}
                <div class="relative overflow-hidden rounded-2xl bg-white shadow ring-1 ring-black/5">
                    <div class="p-4 md:p-5 border-b border-gray-100">
                        <div class="flex items-start gap-3">
                            <span
                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 ring-1 ring-green-200 shrink-0">
                                <x-heroicon-o-map class="size-6 text-green-700" />
                            </span>
                            <div>
                                <h2 class="text-lg md:text-xl font-semibold text-gray-900">Peta Satelit Interaktif</h2>
                                <p class="mt-1 text-gray-700 text-sm">
                                    Peta satelit Desa Mentuda dengan marker lokasi utama. Gunakan zoom dan geser untuk
                                    menjelajah.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 md:p-5">
                        {{-- Peta (Leaflet) --}}
                        <div id="mentudaMap" class="h-[420px] md:h-[540px] rounded-xl ring-1 ring-gray-200 overflow-hidden">
                        </div>

                        {{-- Info bawah --}}
                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-xl bg-green-50/60 p-4 ring-1 ring-green-200">
                                <h3 class="font-semibold text-gray-900 mb-1 text-sm">Tips Navigasi</h3>
                                <p class="text-sm text-gray-700">Gunakan mouse atau dua jari untuk zoom dan geser peta.</p>
                            </div>
                            <div class="rounded-xl bg-amber-50/60 p-4 ring-1 ring-amber-200">
                                <h3 class="font-semibold text-gray-900 mb-1 text-sm">Koordinat Pusat</h3>
                                <p class="text-sm text-gray-700">Lat: -0.16429944952440917, Lng: 104.4830428816694</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CTA Arah --}}
                <div class="rounded-2xl border border-green-200 bg-white p-5 md:p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900">Butuh arah ke Balai Desa?</h3>
                            <p class="text-sm text-gray-700">Buka rute di Google Maps dari perangkat Anda.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="https://maps.app.goo.gl/DssqKULNjNJNr5kg6" target="_blank" rel="noopener"
                                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                                <x-heroicon-o-arrow-top-right-on-square class="size-4" /> Buka Google Maps
                            </a>
                        </div>
                    </div>
                </div>

            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 lg:sticky lg:top-20">
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Legenda</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2"><span class="inline-block h-3 w-3 rounded bg-gray-700"></span>
                            Citra Satelit</li>
                        <li class="flex items-center gap-2"><span
                                class="inline-block h-3 w-3 rounded-full bg-green-600"></span> Marker Lokasi</li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Informasi</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2"><x-heroicon-o-envelope class="size-4 text-green-700" />
                            desa@desamentuda.id</li>
                        <li class="flex items-center gap-2"><x-heroicon-o-phone class="size-4 text-green-700" /> +62 812
                            3456 7890</li>
                        <li class="flex items-center gap-2"><x-heroicon-o-map-pin class="size-4 text-green-700" /> Balai
                            Desa Mentuda</li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow p-4">
                    <a href="{{ route('/') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition">
                        <x-heroicon-o-arrow-left class="size-4" /> Kembali ke Beranda
                    </a>
                </div>
            </aside>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .leaflet-container {
            font-family: inherit;
        }

        .leaflet-control-layers-expanded {
            border-radius: .75rem;
        }

        .leaflet-container img.leaflet-tile {
            max-width: none !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const center = {
                lat: -0.16429944952440917,
                lng: 104.4830428816694
            };


            const map = L.map('mentudaMap', {
                center: [center.lat, center.lng],
                zoom: 17,
                scrollWheelZoom: true
            });


            const esriSat = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Tiles © Esri — Source: Esri, Earthstar Geographics'
                }
            ).addTo(map);

            // Marker utama
            L.marker([center.lat, center.lng])
                .addTo(map)
                .bindPopup(
                    '<strong>Desa Mentuda</strong><br>Wilayah utama Desa Mentuda.<br><a href="https://maps.app.goo.gl/DssqKULNjNJNr5kg6" target="_blank" class="text-green-700 font-medium">Lihat di Google Maps</a>'
                );


            setTimeout(() => map.invalidateSize(), 300);
        });
    </script>
@endpush
