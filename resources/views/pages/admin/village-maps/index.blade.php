@php
    $markerRows = old('markers', $markerRows ?? []);
    $publicMapUrl = route('public.village-map');
@endphp

@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="space-y-8 animate-fadeInUp" id="village-map-admin-page">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-700 via-slate-800 to-slate-900 shadow-2xl">
            <div class="absolute inset-0 bg-white/5"></div>

            <div class="relative p-8 text-white">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="inline-flex items-center rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-slate-100 ring-1 ring-white/15">
                            Profil Desa
                        </span>
                        <h1 class="mt-5 text-4xl font-bold">Peta Desa</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-200">
                            Kelola koordinat utama, judul panel informasi, marker fasilitas umum, dan preview tampilan
                            publik secara langsung dari halaman admin ini.
                        </p>
                    </div>

                    <div class="w-full max-w-sm rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-200">Ringkasan</p>
                        <div class="mt-4 space-y-3">
                            <div class="rounded-xl bg-white/10 px-4 py-3">
                                <p class="text-sm font-semibold text-white">Desa</p>
                                <p class="mt-1 text-sm text-slate-200">{{ $village->name }}</p>
                            </div>
                            <div class="rounded-xl bg-white/10 px-4 py-3">
                                <p class="text-sm font-semibold text-white">Preview Publik</p>
                                <a href="{{ $publicMapUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="mt-1 inline-flex text-sm text-slate-100 underline underline-offset-4">
                                    Buka halaman publik
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('village-maps.update') }}" class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px]">
            @csrf
            @method('PUT')

            <main class="space-y-8">
                <section class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-cyan-50 px-6 py-6 border-b border-gray-200">
                        <div class="flex items-center justify-between gap-4 flex-col sm:flex-row">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Konten Publik Utama</h2>
                                <p class="mt-1 text-sm text-gray-600">Bagian ini langsung mengatur judul, deskripsi, dan identitas peta pada halaman publik.</p>
                            </div>
                            @permission('village_maps.edit')
                                <button type="submit" class="group bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300">
                                    Simpan Perubahan
                                </button>
                            @endpermission
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Judul Peta</label>
                                <input type="text" name="map_title" value="{{ old('map_title', $profile->map_title) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                @error('map_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Deskripsi Peta</label>
                                <textarea name="map_description" rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_description', $profile->map_description) }}</textarea>
                                @error('map_description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Latitude Utama</label>
                                <input type="number" step="0.0000001" name="map_latitude" value="{{ old('map_latitude', $profile->map_latitude) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-map-latitude>
                                @error('map_latitude')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Longitude Utama</label>
                                <input type="number" step="0.0000001" name="map_longitude" value="{{ old('map_longitude', $profile->map_longitude) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-map-longitude>
                                @error('map_longitude')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Zoom Default</label>
                                <input type="number" min="1" max="18" name="map_zoom" value="{{ old('map_zoom', $profile->map_zoom) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-map-zoom>
                                @error('map_zoom')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Judul Popup Marker Utama</label>
                                <input type="text" name="map_popup_title" value="{{ old('map_popup_title', $profile->map_popup_title) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                @error('map_popup_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Deskripsi Popup Marker Utama</label>
                                <textarea name="map_popup_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_popup_description', $profile->map_popup_description) }}</textarea>
                                @error('map_popup_description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-slate-100 px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Panel Informasi Publik</h2>
                        <p class="mt-1 text-sm text-gray-600">Blok ini mengatur panel kanan pada halaman publik.</p>
                    </div>

                    <div class="p-6 sm:p-8 grid gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Judul Panel Informasi</label>
                            <input type="text" name="map_info_title" value="{{ old('map_info_title', $profile->map_info_title) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            @error('map_info_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Judul Batas Wilayah</label>
                                <input type="text" name="map_boundary_title" value="{{ old('map_boundary_title', $profile->map_boundary_title) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                @error('map_boundary_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Judul Fasilitas Umum</label>
                                <input type="text" name="map_facility_title" value="{{ old('map_facility_title', $profile->map_facility_title) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                @error('map_facility_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Batas Wilayah</label>
                            <textarea name="map_boundary_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_boundary_description', $profile->map_boundary_description) }}</textarea>
                            @error('map_boundary_description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Fasilitas Umum</label>
                            <textarea name="map_facility_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_facility_description', $profile->map_facility_description) }}</textarea>
                            @error('map_facility_description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Judul Potensi Desa</label>
                            <input type="text" name="map_potential_title" value="{{ old('map_potential_title', $profile->map_potential_title) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            @error('map_potential_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Potensi Desa</label>
                            <textarea name="map_potential_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_potential_description', $profile->map_potential_description) }}</textarea>
                            @error('map_potential_description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Catatan Tambahan</label>
                            <textarea name="map_note" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_note', $profile->map_note) }}</textarea>
                            @error('map_note')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </section>

                <section class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Marker Fasilitas dan Titik Penting</h2>
                            <p class="mt-1 text-sm text-gray-600">Tambahkan marker yang akan ditampilkan di peta publik.</p>
                        </div>
                        @permission('village_maps.edit')
                            <button type="button" class="module-neutral-btn px-4 py-2 text-sm" data-add-marker>
                                Tambah Marker
                            </button>
                        @endpermission
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="space-y-4" data-marker-list>
                            @forelse ($markerRows as $index => $marker)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5" data-marker-item>
                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700">Nama Marker</label>
                                            <input type="text" name="markers[{{ $index }}][name]" value="{{ $marker['name'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-name>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700">Kategori</label>
                                            <input type="text" name="markers[{{ $index }}][category]" value="{{ $marker['category'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700">Latitude</label>
                                            <input type="number" step="0.0000001" name="markers[{{ $index }}][latitude]" value="{{ $marker['latitude'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-latitude>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700">Longitude</label>
                                            <input type="number" step="0.0000001" name="markers[{{ $index }}][longitude]" value="{{ $marker['longitude'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-longitude>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                                            <textarea name="markers[{{ $index }}][description]" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ $marker['description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    @permission('village_maps.edit')
                                        <div class="mt-4 flex justify-end">
                                            <button type="button" class="module-danger-btn" data-remove-marker>Hapus Marker</button>
                                        </div>
                                    @endpermission
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-500" data-empty-marker-state>
                                    Belum ada marker tambahan. Tambahkan marker untuk fasilitas umum, titik layanan, atau potensi desa.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </main>

            <aside class="space-y-8 lg:sticky lg:top-24 lg:self-start">
                <section class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-blue-50">
                        <h2 class="text-xl font-semibold text-gray-900">Preview Admin</h2>
                        <p class="mt-1 text-sm text-gray-600">Preview ini mengikuti konten publik terbaru dari form di kiri.</p>
                    </div>

                    <div class="p-6">
                        <div class="rounded-2xl overflow-hidden border border-gray-200 bg-gray-50">
                            <div id="adminVillageMapPreview" class="h-[300px] w-full"></div>
                        </div>

                        <div class="mt-5 space-y-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Judul Publik</p>
                                <p class="mt-2 text-lg font-semibold text-gray-900" data-preview-title>{{ old('map_title', $profile->map_title) }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">Deskripsi Publik</p>
                                <p class="mt-2 text-sm leading-6 text-gray-600" data-preview-description>{{ old('map_description', $profile->map_description) }}</p>
                            </div>

                            <div class="rounded-2xl bg-blue-50 px-4 py-4 text-sm text-blue-800">
                                Marker aktif di preview: <span class="font-semibold" data-preview-marker-count>{{ count($markerRows) }}</span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-white shadow-xl rounded-2xl border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900">Kesesuaian Publik</h2>
                    <div class="mt-4 space-y-3 text-sm text-gray-600">
                        <div class="rounded-xl bg-gray-50 px-4 py-3">Hero publik mengambil judul dan deskripsi dari form ini.</div>
                        <div class="rounded-xl bg-gray-50 px-4 py-3">Panel kanan publik mengikuti judul dan isi informasi yang Anda isi.</div>
                        <div class="rounded-xl bg-gray-50 px-4 py-3">Semua marker valid akan ditampilkan langsung di peta publik.</div>
                    </div>
                </section>
            </aside>
        </form>
    </div>

    <template id="marker-row-template">
        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5" data-marker-item>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama Marker</label>
                    <input type="text" data-name-template="markers[__INDEX__][name]" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-name>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Kategori</label>
                    <input type="text" data-name-template="markers[__INDEX__][category]" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Latitude</label>
                    <input type="number" step="0.0000001" data-name-template="markers[__INDEX__][latitude]" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-latitude>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Longitude</label>
                    <input type="number" step="0.0000001" data-name-template="markers[__INDEX__][longitude]" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-longitude>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                    <textarea rows="3" data-name-template="markers[__INDEX__][description]" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700"></textarea>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" class="module-danger-btn" data-remove-marker>Hapus Marker</button>
            </div>
        </div>
    </template>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const page = document.getElementById('village-map-admin-page');

            if (!page || typeof L === 'undefined') {
                return;
            }

            const markerList = page.querySelector('[data-marker-list]');
            const addMarkerButton = page.querySelector('[data-add-marker]');
            const template = document.getElementById('marker-row-template');
            const titleInput = page.querySelector('input[name="map_title"]');
            const descriptionInput = page.querySelector('textarea[name="map_description"]');
            const latitudeInput = page.querySelector('[data-map-latitude]');
            const longitudeInput = page.querySelector('[data-map-longitude]');
            const zoomInput = page.querySelector('[data-map-zoom]');
            const previewTitle = page.querySelector('[data-preview-title]');
            const previewDescription = page.querySelector('[data-preview-description]');
            const previewMarkerCount = page.querySelector('[data-preview-marker-count]');

            let markerIndex = markerList.querySelectorAll('[data-marker-item]').length;
            let previewMarkers = [];

            const initialLat = parseFloat(latitudeInput?.value || '-0.1688817');
            const initialLng = parseFloat(longitudeInput?.value || '104.4712357');
            const initialZoom = parseInt(zoomInput?.value || '14', 10);

            const map = L.map('adminVillageMapPreview', {
                scrollWheelZoom: false,
            }).setView([initialLat, initialLng], initialZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap',
            }).addTo(map);

            let mainMarker = L.marker([initialLat, initialLng]).addTo(map);

            const collectMarkers = () => {
                return Array.from(markerList.querySelectorAll('[data-marker-item]')).map((item) => {
                    const name = item.querySelector('[data-marker-name]')?.value?.trim() || '';
                    const latitude = parseFloat(item.querySelector('[data-marker-latitude]')?.value || '');
                    const longitude = parseFloat(item.querySelector('[data-marker-longitude]')?.value || '');
                    const description = item.querySelector('textarea')?.value?.trim() || '';

                    if (!name || Number.isNaN(latitude) || Number.isNaN(longitude)) {
                        return null;
                    }

                    return { name, latitude, longitude, description };
                }).filter(Boolean);
            };

            const refreshPreviewMap = () => {
                const lat = parseFloat(latitudeInput?.value || '');
                const lng = parseFloat(longitudeInput?.value || '');
                const zoom = parseInt(zoomInput?.value || '14', 10);

                if (!Number.isNaN(lat) && !Number.isNaN(lng)) {
                    map.setView([lat, lng], Number.isNaN(zoom) ? 14 : zoom);
                    mainMarker.setLatLng([lat, lng]);
                }

                previewMarkers.forEach((marker) => map.removeLayer(marker));
                previewMarkers = [];

                const markers = collectMarkers();
                markers.forEach((marker) => {
                    const node = L.marker([marker.latitude, marker.longitude]).addTo(map);
                    if (marker.description) {
                        node.bindPopup(`<strong>${marker.name}</strong><br>${marker.description}`);
                    } else {
                        node.bindPopup(`<strong>${marker.name}</strong>`);
                    }
                    previewMarkers.push(node);
                });

                previewMarkerCount.textContent = markers.length.toString();
                setTimeout(() => map.invalidateSize(), 100);
            };

            const syncPreviewText = () => {
                if (previewTitle) {
                    previewTitle.textContent = titleInput?.value || '';
                }
                if (previewDescription) {
                    previewDescription.textContent = descriptionInput?.value || '';
                }
            };

            const bindMarkerItem = (item) => {
                item.querySelectorAll('input, textarea').forEach((field) => {
                    field.addEventListener('input', refreshPreviewMap);
                });

                const removeButton = item.querySelector('[data-remove-marker]');
                if (removeButton) {
                    removeButton.addEventListener('click', () => {
                        item.remove();
                        const emptyState = markerList.querySelector('[data-empty-marker-state]');
                        if (!markerList.querySelector('[data-marker-item]') && !emptyState) {
                            const placeholder = document.createElement('div');
                            placeholder.className = 'rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-500';
                            placeholder.setAttribute('data-empty-marker-state', '');
                            placeholder.textContent = 'Belum ada marker tambahan. Tambahkan marker untuk fasilitas umum, titik layanan, atau potensi desa.';
                            markerList.appendChild(placeholder);
                        }
                        refreshPreviewMap();
                    });
                }
            };

            if (addMarkerButton && template && markerList) {
                addMarkerButton.addEventListener('click', () => {
                    const emptyState = markerList.querySelector('[data-empty-marker-state]');
                    if (emptyState) {
                        emptyState.remove();
                    }

                    const fragment = template.content.cloneNode(true);
                    fragment.querySelectorAll('[data-name-template]').forEach((field) => {
                        field.setAttribute('name', field.getAttribute('data-name-template').replace('__INDEX__', markerIndex));
                    });

                    markerList.appendChild(fragment);
                    const newItem = markerList.querySelectorAll('[data-marker-item]')[markerList.querySelectorAll('[data-marker-item]').length - 1];
                    bindMarkerItem(newItem);
                    markerIndex += 1;
                    refreshPreviewMap();
                });
            }

            [titleInput, descriptionInput].forEach((field) => {
                field?.addEventListener('input', syncPreviewText);
            });

            [latitudeInput, longitudeInput, zoomInput].forEach((field) => {
                field?.addEventListener('input', refreshPreviewMap);
            });

            markerList.querySelectorAll('[data-marker-item]').forEach(bindMarkerItem);

            syncPreviewText();
            refreshPreviewMap();
        });
    </script>
@endsection
