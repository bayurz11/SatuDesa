@php
    $markerRows = old('markers', $markerRows ?? []);
    $publicMapUrl = route('public.village-map');
@endphp

@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <div class="space-y-8 animate-fadeInUp" id="village-map-admin-page" data-initial-markers='@json(array_values($markerRows))'>
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
                            Kelola koordinat utama, pencarian lokasi, marker fasilitas umum, dan preview hasil publik
                            dalam satu halaman admin yang interaktif.
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
                            <div class="rounded-xl bg-white/10 px-4 py-3 text-sm text-slate-200">
                                Klik peta untuk memindahkan titik utama. Saat modal marker terbuka, klik peta untuk mengisi koordinat marker.
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
                                <h2 class="text-2xl font-bold text-gray-900">Editor Peta Admin</h2>
                                <p class="mt-1 text-sm text-gray-600">Pilih titik, cari lokasi, ganti layer peta, lalu simpan untuk langsung tampil di halaman publik.</p>
                            </div>
                            @permission('village_maps.edit')
                                <button type="submit" class="group bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300">
                                    Simpan Perubahan
                                </button>
                            @endpermission
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
                            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-gray-50">
                                <div id="adminVillageMapEditor" class="h-[420px] w-full lg:h-[560px]"></div>
                            </div>

                            <div class="space-y-4">
                                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">
                                    <p class="text-sm font-semibold text-blue-900">Mode Editor</p>
                                    <p class="mt-2 text-sm leading-6 text-blue-800">
                                        Layer biasa dan satelit bisa diganti dari kontrol peta. Gunakan pencarian untuk menemukan lokasi, lalu klik titik yang diinginkan.
                                    </p>
                                </div>

                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                    <p class="text-sm font-semibold text-gray-900">Koordinat aktif</p>
                                    <div class="mt-4 space-y-3 text-sm text-gray-600">
                                        <div>
                                            <span class="font-semibold text-gray-900">Latitude:</span>
                                            <span data-current-latitude>{{ old('map_latitude', $profile->map_latitude) }}</span>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-900">Longitude:</span>
                                            <span data-current-longitude>{{ old('map_longitude', $profile->map_longitude) }}</span>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-900">Zoom:</span>
                                            <span data-current-zoom>{{ old('map_zoom', $profile->map_zoom) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                    <p class="text-sm font-semibold text-gray-900">Aksi cepat</p>
                                    <div class="mt-4 space-y-3">
                                        @permission('village_maps.edit')
                                            <button type="button" class="module-neutral-btn w-full px-4 py-3 text-sm" data-open-marker-modal data-marker-mode="create">
                                                Tambah Marker via Modal
                                            </button>
                                        @endpermission
                                        <a href="{{ $publicMapUrl }}" target="_blank" rel="noopener noreferrer"
                                            class="module-neutral-btn inline-flex w-full items-center justify-center px-4 py-3 text-sm">
                                            Lihat Hasil di Publik
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-cyan-50 px-6 py-6 border-b border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-900">Konten Publik Utama</h2>
                        <p class="mt-1 text-sm text-gray-600">Bagian ini mengatur judul, deskripsi, dan identitas peta pada halaman publik.</p>
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Judul Peta</label>
                                <input type="text" name="map_title" value="{{ old('map_title', $profile->map_title) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-map-title>
                                @error('map_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Deskripsi Peta</label>
                                <textarea name="map_description" rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-map-description>{{ old('map_description', $profile->map_description) }}</textarea>
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
                            <p class="mt-1 text-sm text-gray-600">Kelola marker melalui modal agar input lebih rapi dan fokus.</p>
                        </div>
                        @permission('village_maps.edit')
                            <button type="button" class="module-neutral-btn px-4 py-2 text-sm" data-open-marker-modal data-marker-mode="create">
                                Tambah Marker
                            </button>
                        @endpermission
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="hidden" data-marker-hidden-inputs></div>
                        <div class="space-y-4" data-marker-list-display></div>
                        <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-500 hidden" data-empty-marker-state>
                            Belum ada marker tambahan. Gunakan tombol `Tambah Marker` untuk membuat titik baru.
                        </div>
                    </div>
                </section>
            </main>

            <aside class="space-y-8 lg:sticky lg:top-24 lg:self-start">
                <section class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-blue-50">
                        <h2 class="text-xl font-semibold text-gray-900">Preview Admin</h2>
                        <p class="mt-1 text-sm text-gray-600">Preview ini mengikuti hasil yang akan tampil di halaman publik.</p>
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
                        <div class="rounded-xl bg-gray-50 px-4 py-3">Koordinat utama yang dipilih di peta admin akan menjadi titik utama di halaman publik.</div>
                        <div class="rounded-xl bg-gray-50 px-4 py-3">Marker yang ditambahkan lewat modal akan langsung dipakai oleh halaman publik setelah disimpan.</div>
                        <div class="rounded-xl bg-gray-50 px-4 py-3">Judul dan deskripsi preview selalu mengikuti input form saat ini.</div>
                    </div>
                </section>
            </aside>
        </form>

        <div class="app-modal-overlay hidden" data-marker-modal-overlay data-modal-overlay>
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-2xl">
                    <div class="module-panel-header px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Marker Modal</p>
                                <h2 class="mt-1 text-xl font-semibold text-gray-900" data-marker-modal-title>Tambah Marker</h2>
                                <p class="mt-2 text-sm text-gray-600">
                                    Isi data marker. Saat modal ini terbuka, klik di peta editor untuk otomatis mengisi latitude dan longitude.
                                </p>
                            </div>
                            <button type="button" class="module-neutral-btn px-3 py-2 text-sm" data-close-marker-modal>Tutup</button>
                        </div>
                    </div>

                    <div class="app-modal-body px-6 py-6">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Nama Marker</label>
                                <input type="text" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-form-name>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Kategori</label>
                                <input type="text" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-form-category>
                            </div>

                            <div class="rounded-2xl border border-blue-100 bg-blue-50 px-4 py-4 text-sm text-blue-800">
                                Gunakan pencarian lokasi atau klik peta editor untuk memilih titik marker dengan lebih cepat.
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Latitude</label>
                                <input type="number" step="0.0000001" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-form-latitude>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Longitude</label>
                                <input type="number" step="0.0000001" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-form-longitude>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                                <textarea rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-marker-form-description></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="app-modal-footer px-6 py-4">
                        <button type="button" class="module-neutral-btn px-4 py-3 text-sm" data-close-marker-modal>Batal</button>
                        <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-save-marker-modal>Simpan Marker</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const page = document.getElementById('village-map-admin-page');

            if (!page || typeof L === 'undefined') {
                return;
            }

            const titleInput = page.querySelector('[data-map-title]');
            const descriptionInput = page.querySelector('[data-map-description]');
            const latitudeInput = page.querySelector('[data-map-latitude]');
            const longitudeInput = page.querySelector('[data-map-longitude]');
            const zoomInput = page.querySelector('[data-map-zoom]');
            const currentLatitude = page.querySelector('[data-current-latitude]');
            const currentLongitude = page.querySelector('[data-current-longitude]');
            const currentZoom = page.querySelector('[data-current-zoom]');
            const previewTitle = page.querySelector('[data-preview-title]');
            const previewDescription = page.querySelector('[data-preview-description]');
            const previewMarkerCount = page.querySelector('[data-preview-marker-count]');
            const markerDisplay = page.querySelector('[data-marker-list-display]');
            const markerHiddenInputs = page.querySelector('[data-marker-hidden-inputs]');
            const emptyMarkerState = page.querySelector('[data-empty-marker-state]');
            const modalOverlay = page.querySelector('[data-marker-modal-overlay]');
            const modalTitle = page.querySelector('[data-marker-modal-title]');
            const openModalButtons = page.querySelectorAll('[data-open-marker-modal]');
            const closeModalButtons = page.querySelectorAll('[data-close-marker-modal]');
            const saveModalButton = page.querySelector('[data-save-marker-modal]');

            const modalFields = {
                name: page.querySelector('[data-marker-form-name]'),
                category: page.querySelector('[data-marker-form-category]'),
                latitude: page.querySelector('[data-marker-form-latitude]'),
                longitude: page.querySelector('[data-marker-form-longitude]'),
                description: page.querySelector('[data-marker-form-description]'),
            };

            let markers = [];
            try {
                markers = JSON.parse(page.dataset.initialMarkers || '[]');
            } catch (error) {
                markers = [];
            }

            let modalMode = 'create';
            let editingMarkerIndex = null;
            let previewMarkers = [];
            let editorMarkers = [];
            let lastPickedLatLng = null;

            const initialLat = parseFloat(latitudeInput?.value || '-0.1688817');
            const initialLng = parseFloat(longitudeInput?.value || '104.4712357');
            const initialZoom = parseInt(zoomInput?.value || '14', 10);

            const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap',
            });

            const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri',
            });

            const editorMap = L.map('adminVillageMapEditor', {
                layers: [streetLayer],
            }).setView([initialLat, initialLng], initialZoom);

            L.control.layers({
                'Peta Biasa': streetLayer,
                'Satelit': satelliteLayer,
            }, {}, {
                collapsed: false,
            }).addTo(editorMap);

            if (L.Control.Geocoder) {
                const geocoderControl = L.Control.geocoder({
                    defaultMarkGeocode: false,
                }).addTo(editorMap);

                geocoderControl.on('markgeocode', function(event) {
                    const center = event.geocode.center;
                    editorMap.setView(center, 16);

                    if (!modalOverlay.classList.contains('hidden')) {
                        lastPickedLatLng = center;
                        modalFields.latitude.value = Number(center.lat).toFixed(7);
                        modalFields.longitude.value = Number(center.lng).toFixed(7);
                        return;
                    }

                    setMainCoordinates(center.lat, center.lng);
                });
            }

            const editorMainMarker = L.marker([initialLat, initialLng], {
                draggable: true,
            }).addTo(editorMap);

            const previewMap = L.map('adminVillageMapPreview', {
                scrollWheelZoom: false,
                layers: [streetLayer.clone ? streetLayer.clone() : L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap',
                })],
            }).setView([initialLat, initialLng], initialZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap',
            }).addTo(previewMap);

            const previewMainMarker = L.marker([initialLat, initialLng]).addTo(previewMap);

            const setMainCoordinates = (lat, lng) => {
                latitudeInput.value = Number(lat).toFixed(7);
                longitudeInput.value = Number(lng).toFixed(7);
                currentLatitude.textContent = latitudeInput.value;
                currentLongitude.textContent = longitudeInput.value;

                editorMainMarker.setLatLng([lat, lng]);
                previewMainMarker.setLatLng([lat, lng]);
                previewMap.setView([lat, lng], parseInt(zoomInput.value || '14', 10));
            };

            const syncPreviewText = () => {
                previewTitle.textContent = titleInput?.value || '';
                previewDescription.textContent = descriptionInput?.value || '';
            };

            const refreshHiddenInputs = () => {
                markerHiddenInputs.innerHTML = '';
                markers.forEach((marker, index) => {
                    ['name', 'category', 'latitude', 'longitude', 'description'].forEach((field) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `markers[${index}][${field}]`;
                        input.value = marker[field] ?? '';
                        markerHiddenInputs.appendChild(input);
                    });
                });
            };

            const refreshMapMarkers = () => {
                editorMarkers.forEach((marker) => editorMap.removeLayer(marker));
                previewMarkers.forEach((marker) => previewMap.removeLayer(marker));
                editorMarkers = [];
                previewMarkers = [];

                markers.forEach((marker) => {
                    if (!marker.latitude || !marker.longitude || !marker.name) {
                        return;
                    }

                    const popupDescription = marker.description ? `<br>${marker.description}` : '';
                    const editorMarker = L.marker([marker.latitude, marker.longitude]).addTo(editorMap);
                    const previewMarker = L.marker([marker.latitude, marker.longitude]).addTo(previewMap);

                    editorMarker.bindPopup(`<strong>${marker.name}</strong>${popupDescription}`);
                    previewMarker.bindPopup(`<strong>${marker.name}</strong>${popupDescription}`);

                    editorMarkers.push(editorMarker);
                    previewMarkers.push(previewMarker);
                });

                previewMarkerCount.textContent = markers.length.toString();
            };

            const renderMarkerCards = () => {
                markerDisplay.innerHTML = '';

                if (markers.length === 0) {
                    emptyMarkerState.classList.remove('hidden');
                    refreshHiddenInputs();
                    refreshMapMarkers();
                    return;
                }

                emptyMarkerState.classList.add('hidden');

                markers.forEach((marker, index) => {
                    const card = document.createElement('div');
                    card.className = 'rounded-2xl border border-gray-200 bg-gray-50 p-5';
                    card.innerHTML = `
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">${marker.category || 'Lokasi'}</span>
                                    <span class="text-xs text-gray-500">${marker.latitude}, ${marker.longitude}</span>
                                </div>
                                <h3 class="mt-3 text-lg font-semibold text-gray-900">${marker.name || '-'}</h3>
                                <p class="mt-2 text-sm leading-6 text-gray-600">${marker.description || 'Tanpa deskripsi tambahan.'}</p>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" class="module-edit-btn" data-edit-marker="${index}">Edit</button>
                                <button type="button" class="module-danger-btn" data-delete-marker="${index}">Hapus</button>
                            </div>
                        </div>
                    `;
                    markerDisplay.appendChild(card);
                });

                markerDisplay.querySelectorAll('[data-edit-marker]').forEach((button) => {
                    button.addEventListener('click', () => openMarkerModal('edit', Number(button.dataset.editMarker)));
                });

                markerDisplay.querySelectorAll('[data-delete-marker]').forEach((button) => {
                    button.addEventListener('click', () => {
                        markers.splice(Number(button.dataset.deleteMarker), 1);
                        renderMarkerCards();
                    });
                });

                refreshHiddenInputs();
                refreshMapMarkers();
            };

            const clearModal = () => {
                modalFields.name.value = '';
                modalFields.category.value = '';
                modalFields.latitude.value = '';
                modalFields.longitude.value = '';
                modalFields.description.value = '';
            };

            const openMarkerModal = (mode = 'create', index = null) => {
                modalMode = mode;
                editingMarkerIndex = index;
                clearModal();

                if (mode === 'edit' && index !== null && markers[index]) {
                    const marker = markers[index];
                    modalTitle.textContent = 'Edit Marker';
                    modalFields.name.value = marker.name || '';
                    modalFields.category.value = marker.category || '';
                    modalFields.latitude.value = marker.latitude || '';
                    modalFields.longitude.value = marker.longitude || '';
                    modalFields.description.value = marker.description || '';
                } else {
                    modalTitle.textContent = 'Tambah Marker';
                    if (lastPickedLatLng) {
                        modalFields.latitude.value = Number(lastPickedLatLng.lat).toFixed(7);
                        modalFields.longitude.value = Number(lastPickedLatLng.lng).toFixed(7);
                    }
                }

                modalOverlay.classList.remove('hidden');
                document.body.classList.add('modal-open');
            };

            const closeMarkerModal = () => {
                modalOverlay.classList.add('hidden');
                document.body.classList.remove('modal-open');
                editingMarkerIndex = null;
            };

            const saveMarkerFromModal = () => {
                const payload = {
                    name: modalFields.name.value.trim(),
                    category: modalFields.category.value.trim() || 'Lokasi',
                    latitude: parseFloat(modalFields.latitude.value || ''),
                    longitude: parseFloat(modalFields.longitude.value || ''),
                    description: modalFields.description.value.trim(),
                };

                if (!payload.name || Number.isNaN(payload.latitude) || Number.isNaN(payload.longitude)) {
                    window.showError('Data marker belum lengkap', 'Nama marker dan koordinat harus diisi.');
                    return;
                }

                if (modalMode === 'edit' && editingMarkerIndex !== null) {
                    markers[editingMarkerIndex] = payload;
                } else {
                    markers.push(payload);
                }

                renderMarkerCards();
                closeMarkerModal();
            };

            editorMainMarker.on('dragend', function(event) {
                const latLng = event.target.getLatLng();
                lastPickedLatLng = latLng;
                setMainCoordinates(latLng.lat, latLng.lng);
            });

            editorMap.on('click', function(event) {
                lastPickedLatLng = event.latlng;

                if (!modalOverlay.classList.contains('hidden')) {
                    modalFields.latitude.value = Number(event.latlng.lat).toFixed(7);
                    modalFields.longitude.value = Number(event.latlng.lng).toFixed(7);
                    return;
                }

                setMainCoordinates(event.latlng.lat, event.latlng.lng);
            });

            editorMap.on('zoomend', function() {
                const zoom = editorMap.getZoom();
                zoomInput.value = zoom;
                currentZoom.textContent = zoom;
                previewMap.setZoom(zoom);
            });

            [titleInput, descriptionInput].forEach((field) => {
                field?.addEventListener('input', syncPreviewText);
            });

            [latitudeInput, longitudeInput].forEach((field) => {
                field?.addEventListener('input', () => {
                    const lat = parseFloat(latitudeInput.value || '');
                    const lng = parseFloat(longitudeInput.value || '');
                    if (!Number.isNaN(lat) && !Number.isNaN(lng)) {
                        setMainCoordinates(lat, lng);
                        editorMap.setView([lat, lng], editorMap.getZoom());
                    }
                });
            });

            zoomInput?.addEventListener('input', () => {
                const zoom = parseInt(zoomInput.value || '14', 10);
                if (!Number.isNaN(zoom)) {
                    currentZoom.textContent = zoom;
                    editorMap.setZoom(zoom);
                    previewMap.setZoom(zoom);
                }
            });

            openModalButtons.forEach((button) => {
                button.addEventListener('click', () => openMarkerModal(button.dataset.markerMode || 'create'));
            });

            closeModalButtons.forEach((button) => {
                button.addEventListener('click', closeMarkerModal);
            });

            modalOverlay.addEventListener('click', function(event) {
                if (event.target === modalOverlay) {
                    closeMarkerModal();
                }
            });

            saveModalButton.addEventListener('click', saveMarkerFromModal);

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modalOverlay.classList.contains('hidden')) {
                    closeMarkerModal();
                }
            });

            syncPreviewText();
            renderMarkerCards();
            setMainCoordinates(initialLat, initialLng);

            setTimeout(function() {
                editorMap.invalidateSize();
                previewMap.invalidateSize();
            }, 200);
        });
    </script>
@endsection
