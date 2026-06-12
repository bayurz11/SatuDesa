@php
    $markerRows = old('markers', $markerRows ?? []);
    $publicMapUrl = route('public.village-map');
@endphp

@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <div class="space-y-8 animate-fadeInUp" id="village-map-admin-page"
        data-initial-markers='@json(array_values($markerRows))'
        data-map-lat="{{ old('map_latitude', $profile->map_latitude) }}"
        data-map-lng="{{ old('map_longitude', $profile->map_longitude) }}"
        data-map-zoom="{{ old('map_zoom', $profile->map_zoom) }}"
        data-map-title="@js(old('map_title', $profile->map_title))"
        data-map-description="@js(old('map_description', $profile->map_description))"
        data-popup-title="@js(old('map_popup_title', $profile->map_popup_title))"
        data-popup-description="@js(old('map_popup_description', $profile->map_popup_description))">

        <div class="profile-module-hero">
            <div class="p-8">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                    <div class="flex max-w-3xl gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l-6 3V6l6-3 6 3 6-3v15l-6 3-6-3zM9 3v15M15 6v15" />
                            </svg>
                        </div>
                        <div>
                            <p class="profile-module-kicker">Profil Desa</p>
                            <h1 class="profile-module-heading">Manajemen Peta Desa</h1>
                            <p class="profile-module-copy">
                                Kelola editor peta, konten publik utama, panel informasi, dan marker fasilitas umum dengan pola ringkas seperti halaman berita.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row xl:flex-col">
                        <div class="profile-module-stat">
                            <p class="profile-module-stat-label">Desa Aktif</p>
                            <p class="text-2xl font-bold text-slate-900 mt-2">{{ $village->name }}</p>
                            <p class="profile-module-stat-note text-blue-600">{{ count($markerRows) }} marker aktif</p>
                        </div>
                        <a href="{{ $publicMapUrl }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-4 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition hover:brightness-95">
                            Buka Halaman Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="module-panel overflow-hidden">
            <div class="module-panel-header px-8 py-8">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                    <div class="flex max-w-3xl gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white shadow-lg shadow-violet-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h10.5" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="profile-module-heading">Peta Desa</h2>
                            <p class="profile-module-copy">
                                Halaman ini hanya menampilkan hasil konfigurasi setiap kategori. Semua perubahan dilakukan melalui modal agar tampilan lebih bersih dan mudah dipakai.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-4">
                        <div class="profile-module-stat">
                            <p class="profile-module-stat-label">Editor Peta</p>
                            <p class="profile-module-stat-value">{{ old('map_zoom', $profile->map_zoom) }}</p>
                            <p class="profile-module-stat-note text-blue-600">Zoom aktif</p>
                        </div>
                        <div class="profile-module-stat">
                            <p class="profile-module-stat-label">Konten Utama</p>
                            <p class="profile-module-stat-value">1</p>
                            <p class="profile-module-stat-note text-emerald-600">Set aktif</p>
                        </div>
                        <div class="profile-module-stat">
                            <p class="profile-module-stat-label">Panel Publik</p>
                            <p class="profile-module-stat-value">3</p>
                            <p class="profile-module-stat-note text-amber-600">Blok informasi</p>
                        </div>
                        <div class="profile-module-stat">
                            <p class="profile-module-stat-label">Marker</p>
                            <p class="profile-module-stat-value" data-preview-marker-count>{{ count($markerRows) }}</p>
                            <p class="profile-module-stat-note text-fuchsia-600">Titik penting</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 bg-slate-50/70 px-8 py-6">
                <div class="grid gap-8">
                    <section class="rounded-[28px] border border-slate-200 bg-white shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="profile-module-section-title">Editor Peta Admin</h3>
                                <p class="profile-module-section-copy">Ringkasan koordinat, zoom, dan preview peta utama. Klik tombol untuk membuka editor interaktif.</p>
                            </div>
                            @permission('village_maps.edit')
                                <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-open-modal="map-editor-modal">Editor Peta Admin</button>
                            @endpermission
                        </div>

                        <div class="grid gap-6 p-6 lg:grid-cols-[minmax(0,1fr)_320px]">
                            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                                <div id="adminVillageMapPreview" class="h-[320px] w-full md:h-[420px]"></div>
                            </div>
                            <div class="space-y-4">
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                    <p class="text-sm font-semibold text-slate-900">Koordinat Utama</p>
                                    <div class="mt-4 space-y-2 text-sm text-slate-600">
                                        <div><span class="font-semibold text-slate-900">Latitude:</span> <span data-current-latitude>{{ old('map_latitude', $profile->map_latitude) }}</span></div>
                                        <div><span class="font-semibold text-slate-900">Longitude:</span> <span data-current-longitude>{{ old('map_longitude', $profile->map_longitude) }}</span></div>
                                        <div><span class="font-semibold text-slate-900">Zoom:</span> <span data-current-zoom>{{ old('map_zoom', $profile->map_zoom) }}</span></div>
                                    </div>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                    <p class="text-sm font-semibold text-slate-900">Popup Utama</p>
                                    <p class="mt-2 font-semibold text-slate-900" data-popup-title-preview>{{ old('map_popup_title', $profile->map_popup_title) }}</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-600" data-popup-description-preview>{{ old('map_popup_description', $profile->map_popup_description) }}</p>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                    <p class="text-sm font-semibold text-slate-900">Mode Peta</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">Layer biasa dan satelit tersedia di editor. Pencarian lokasi dan klik peta akan membantu memilih titik dengan cepat.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-[28px] border border-slate-200 bg-white shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="profile-module-section-title">Konten Publik Utama</h3>
                                <p class="profile-module-section-copy">Judul, deskripsi halaman, dan isi popup marker utama yang tampil di publik.</p>
                            </div>
                            @permission('village_maps.edit')
                                <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-open-modal="map-content-modal">Konten Publik Utama</button>
                            @endpermission
                        </div>
                        <div class="overflow-x-auto">
                            <table class="profile-module-table min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr class="text-left">
                                        <th class="px-6 py-4">Judul</th>
                                        <th class="px-6 py-4">Deskripsi</th>
                                        <th class="px-6 py-4">Popup Utama</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    <tr class="align-top text-sm text-slate-700">
                                        <td class="px-6 py-5 font-semibold text-slate-900" data-map-title-preview>{{ old('map_title', $profile->map_title) }}</td>
                                        <td class="px-6 py-5 max-w-lg" data-map-description-preview>{{ old('map_description', $profile->map_description) }}</td>
                                        <td class="px-6 py-5">
                                            <p class="font-semibold text-slate-900">{{ old('map_popup_title', $profile->map_popup_title) }}</p>
                                            <p class="mt-1 max-w-sm text-slate-500">{{ old('map_popup_description', $profile->map_popup_description) }}</p>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            @permission('village_maps.edit')
                                                <button type="button" class="module-edit-btn" data-open-modal="map-content-modal">Edit</button>
                                            @endpermission
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="rounded-[28px] border border-slate-200 bg-white shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="profile-module-section-title">Panel Informasi Publik</h3>
                                <p class="profile-module-section-copy">Ringkasan panel informasi, fasilitas umum, potensi desa, dan catatan tambahan publik.</p>
                            </div>
                            @permission('village_maps.edit')
                                <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-open-modal="map-panels-modal">Panel Informasi Publik</button>
                            @endpermission
                        </div>
                        <div class="grid gap-4 p-6 md:grid-cols-3">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Panel Utama</p>
                                <h4 class="mt-3 text-lg font-semibold text-slate-900">{{ old('map_info_title', $profile->map_info_title) }}</h4>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ old('map_note', $profile->map_note) ?: 'Tidak ada catatan tambahan.' }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Fasilitas Umum</p>
                                <h4 class="mt-3 text-lg font-semibold text-slate-900">{{ old('map_facility_title', $profile->map_facility_title) }}</h4>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ old('map_facility_description', $profile->map_facility_description) }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Potensi Desa</p>
                                <h4 class="mt-3 text-lg font-semibold text-slate-900">{{ old('map_potential_title', $profile->map_potential_title) }}</h4>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ old('map_potential_description', $profile->map_potential_description) }}</p>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-[28px] border border-slate-200 bg-white shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="profile-module-section-title">Marker Fasilitas dan Titik Penting</h3>
                                <p class="profile-module-section-copy">Daftar marker tampil sebagai hasil. Tambah dan edit dilakukan lewat modal.</p>
                            </div>
                            @permission('village_maps.edit')
                                <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-open-marker-modal data-marker-mode="create">Tambah Marker</button>
                            @endpermission
                        </div>
                        <form method="POST" action="{{ route('village-maps.markers.update') }}" class="p-6">
                            @csrf
                            @method('PUT')
                            <div class="hidden" data-marker-hidden-inputs></div>
                            <div class="space-y-4" data-marker-list-display></div>
                            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-500 hidden" data-empty-marker-state>
                                Belum ada marker tambahan. Gunakan tombol `Tambah Marker` untuk membuat titik baru.
                            </div>
                            @permission('village_maps.edit')
                                <div class="mt-5 flex justify-end">
                                    <button type="submit" class="module-primary-btn px-5 py-3 text-sm">Simpan Marker</button>
                                </div>
                            @endpermission
                        </form>
                    </section>
                </div>
            </div>
        </section>

        @permission('village_maps.edit')
            <div class="app-modal-overlay hidden" data-modal="map-editor-modal">
                <div class="app-modal-shell">
                    <div class="app-modal-panel max-w-6xl">
                        <form method="POST" action="{{ route('village-maps.editor.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="module-panel-header px-6 py-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Editor Peta</p>
                                        <h2 class="mt-1 text-xl font-semibold text-gray-900">Editor Peta Admin</h2>
                                        <p class="mt-2 text-sm text-gray-600">Pilih titik utama, cari lokasi, dan ganti layer peta. Hasilnya langsung dipakai di halaman publik.</p>
                                    </div>
                                    <button type="button" class="module-neutral-btn px-3 py-2 text-sm" data-close-modal="map-editor-modal">Tutup</button>
                                </div>
                            </div>
                            <div class="app-modal-body px-6 py-6">
                                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                                        <div id="adminVillageMapEditor" class="h-[420px] w-full lg:h-[560px]"></div>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5 text-sm text-blue-800">
                                            Layer biasa dan satelit tersedia. Gunakan pencarian lokasi atau klik pada peta untuk mengisi koordinat utama.
                                        </div>
                                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                            <label class="block text-sm font-semibold text-slate-900">Latitude</label>
                                            <input type="number" step="0.0000001" name="map_latitude" value="{{ old('map_latitude', $profile->map_latitude) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-slate-700" data-map-latitude>
                                        </div>
                                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                            <label class="block text-sm font-semibold text-slate-900">Longitude</label>
                                            <input type="number" step="0.0000001" name="map_longitude" value="{{ old('map_longitude', $profile->map_longitude) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-slate-700" data-map-longitude>
                                        </div>
                                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                            <label class="block text-sm font-semibold text-slate-900">Zoom Default</label>
                                            <input type="number" min="1" max="18" name="map_zoom" value="{{ old('map_zoom', $profile->map_zoom) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-slate-700" data-map-zoom>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="app-modal-footer px-6 py-4">
                                <button type="button" class="module-neutral-btn px-4 py-3 text-sm" data-close-modal="map-editor-modal">Batal</button>
                                <button type="submit" class="module-primary-btn px-5 py-3 text-sm">Simpan Editor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="app-modal-overlay hidden" data-modal="map-content-modal">
                <div class="app-modal-shell">
                    <div class="app-modal-panel max-w-3xl">
                        <form method="POST" action="{{ route('village-maps.content.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="module-panel-header px-6 py-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Konten Utama</p>
                                        <h2 class="mt-1 text-xl font-semibold text-gray-900">Konten Publik Utama</h2>
                                    </div>
                                    <button type="button" class="module-neutral-btn px-3 py-2 text-sm" data-close-modal="map-content-modal">Tutup</button>
                                </div>
                            </div>
                            <div class="app-modal-body px-6 py-6">
                                <div class="grid gap-5 md:grid-cols-2">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700">Judul Peta</label>
                                        <input type="text" name="map_title" value="{{ old('map_title', $profile->map_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700">Deskripsi Peta</label>
                                        <textarea name="map_description" rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_description', $profile->map_description) }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Judul Popup Utama</label>
                                        <input type="text" name="map_popup_title" value="{{ old('map_popup_title', $profile->map_popup_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700">Deskripsi Popup Utama</label>
                                        <textarea name="map_popup_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_popup_description', $profile->map_popup_description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="app-modal-footer px-6 py-4">
                                <button type="button" class="module-neutral-btn px-4 py-3 text-sm" data-close-modal="map-content-modal">Batal</button>
                                <button type="submit" class="module-primary-btn px-5 py-3 text-sm">Simpan Konten</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="app-modal-overlay hidden" data-modal="map-panels-modal">
                <div class="app-modal-shell">
                    <div class="app-modal-panel max-w-3xl">
                        <form method="POST" action="{{ route('village-maps.panels.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="module-panel-header px-6 py-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Panel Publik</p>
                                        <h2 class="mt-1 text-xl font-semibold text-gray-900">Panel Informasi Publik</h2>
                                    </div>
                                    <button type="button" class="module-neutral-btn px-3 py-2 text-sm" data-close-modal="map-panels-modal">Tutup</button>
                                </div>
                            </div>
                            <div class="app-modal-body px-6 py-6">
                                <div class="grid gap-5 md:grid-cols-2">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700">Judul Panel Informasi</label>
                                        <input type="text" name="map_info_title" value="{{ old('map_info_title', $profile->map_info_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Judul Fasilitas Umum</label>
                                        <input type="text" name="map_facility_title" value="{{ old('map_facility_title', $profile->map_facility_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Judul Potensi Desa</label>
                                        <input type="text" name="map_potential_title" value="{{ old('map_potential_title', $profile->map_potential_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Deskripsi Fasilitas Umum</label>
                                        <textarea name="map_facility_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_facility_description', $profile->map_facility_description) }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Deskripsi Potensi Desa</label>
                                        <textarea name="map_potential_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_potential_description', $profile->map_potential_description) }}</textarea>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700">Catatan Tambahan</label>
                                        <textarea name="map_note" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('map_note', $profile->map_note) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="app-modal-footer px-6 py-4">
                                <button type="button" class="module-neutral-btn px-4 py-3 text-sm" data-close-modal="map-panels-modal">Batal</button>
                                <button type="submit" class="module-primary-btn px-5 py-3 text-sm">Simpan Panel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endpermission

        <div class="app-modal-overlay hidden" data-marker-modal-overlay>
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-2xl">
                    <div class="module-panel-header px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Marker Modal</p>
                                <h2 class="mt-1 text-xl font-semibold text-gray-900" data-marker-modal-title>Tambah Marker</h2>
                                <p class="mt-2 text-sm text-gray-600">Isi data marker. Saat modal terbuka, klik di editor peta untuk otomatis mengisi koordinat.</p>
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
            if (!page || typeof L === 'undefined') return;

            const initialLat = parseFloat(page.dataset.mapLat || '-0.1642816');
            const initialLng = parseFloat(page.dataset.mapLng || '104.4830524');
            const initialZoom = parseInt(page.dataset.mapZoom || '18', 10);

            const currentLatitude = page.querySelector('[data-current-latitude]');
            const currentLongitude = page.querySelector('[data-current-longitude]');
            const currentZoom = page.querySelector('[data-current-zoom]');
            const markerDisplay = page.querySelector('[data-marker-list-display]');
            const markerHiddenInputs = page.querySelector('[data-marker-hidden-inputs]');
            const emptyMarkerState = page.querySelector('[data-empty-marker-state]');
            const previewMarkerCount = page.querySelector('[data-preview-marker-count]');

            let markers = [];
            try {
                markers = JSON.parse(page.dataset.initialMarkers || '[]');
            } catch (error) {
                markers = [];
            }

            const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' });
            const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19, attribution: 'Tiles &copy; Esri' });

            const previewMap = L.map('adminVillageMapPreview', { scrollWheelZoom: false, layers: [satelliteLayer] }).setView([initialLat, initialLng], initialZoom);
            const previewMainMarker = L.marker([initialLat, initialLng]).addTo(previewMap);
            const previewMarkers = [];

            const editorMap = L.map('adminVillageMapEditor', { layers: [streetLayer] }).setView([initialLat, initialLng], initialZoom);
            const editorMainMarker = L.marker([initialLat, initialLng], { draggable: true }).addTo(editorMap);
            const editorMarkers = [];

            L.control.layers({ 'Peta Biasa': streetLayer, 'Satelit': satelliteLayer }, {}, { collapsed: false }).addTo(editorMap);

            const modalFields = {
                name: page.querySelector('[data-marker-form-name]'),
                category: page.querySelector('[data-marker-form-category]'),
                latitude: page.querySelector('[data-marker-form-latitude]'),
                longitude: page.querySelector('[data-marker-form-longitude]'),
                description: page.querySelector('[data-marker-form-description]'),
            };
            const modalOverlay = page.querySelector('[data-marker-modal-overlay]');
            const modalTitle = page.querySelector('[data-marker-modal-title]');
            const saveModalButton = page.querySelector('[data-save-marker-modal]');
            let modalMode = 'create';
            let editingMarkerIndex = null;
            let lastPickedLatLng = null;

            const mapLatitudeInput = page.querySelector('[data-map-latitude]');
            const mapLongitudeInput = page.querySelector('[data-map-longitude]');
            const mapZoomInput = page.querySelector('[data-map-zoom]');

            const openModal = (name) => {
                const modal = document.querySelector(`[data-modal="${name}"]`);
                if (!modal) return;
                modal.classList.remove('hidden');
                document.body.classList.add('modal-open');
                if (name === 'map-editor-modal') {
                    setTimeout(() => editorMap.invalidateSize(), 150);
                }
            };

            const closeModal = (name) => {
                const modal = document.querySelector(`[data-modal="${name}"]`);
                if (!modal) return;
                modal.classList.add('hidden');
                document.body.classList.remove('modal-open');
            };

            document.querySelectorAll('[data-open-modal]').forEach((button) => {
                button.addEventListener('click', () => openModal(button.dataset.openModal));
            });
            document.querySelectorAll('[data-close-modal]').forEach((button) => {
                button.addEventListener('click', () => closeModal(button.dataset.closeModal));
            });
            document.querySelectorAll('[data-modal]').forEach((modal) => {
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) closeModal(modal.dataset.modal);
                });
            });

            const setMainCoordinates = (lat, lng) => {
                const normalizedLat = Number(lat);
                const normalizedLng = Number(lng);
                if (Number.isNaN(normalizedLat) || Number.isNaN(normalizedLng)) return;

                if (mapLatitudeInput) mapLatitudeInput.value = normalizedLat.toFixed(7);
                if (mapLongitudeInput) mapLongitudeInput.value = normalizedLng.toFixed(7);
                currentLatitude.textContent = normalizedLat.toFixed(7);
                currentLongitude.textContent = normalizedLng.toFixed(7);
                editorMainMarker.setLatLng([normalizedLat, normalizedLng]);
                previewMainMarker.setLatLng([normalizedLat, normalizedLng]);
                previewMap.setView([normalizedLat, normalizedLng], parseInt(mapZoomInput?.value || initialZoom, 10));
            };

            editorMainMarker.on('dragend', function() {
                const position = editorMainMarker.getLatLng();
                setMainCoordinates(position.lat, position.lng);
            });

            editorMap.on('click', function(event) {
                if (!modalOverlay.classList.contains('hidden')) {
                    lastPickedLatLng = event.latlng;
                    modalFields.latitude.value = Number(event.latlng.lat).toFixed(7);
                    modalFields.longitude.value = Number(event.latlng.lng).toFixed(7);
                    return;
                }
                setMainCoordinates(event.latlng.lat, event.latlng.lng);
            });

            if (L.Control.Geocoder) {
                const geocoder = L.Control.geocoder({ defaultMarkGeocode: false }).addTo(editorMap);
                geocoder.on('markgeocode', function(event) {
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

            if (mapZoomInput) {
                mapZoomInput.addEventListener('input', () => {
                    const zoom = parseInt(mapZoomInput.value || initialZoom, 10);
                    currentZoom.textContent = zoom;
                    previewMap.setZoom(zoom);
                    editorMap.setZoom(zoom);
                });
            }

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
                editorMarkers.splice(0).forEach((marker) => editorMap.removeLayer(marker));
                previewMarkers.splice(0).forEach((marker) => previewMap.removeLayer(marker));

                markers.forEach((marker) => {
                    if (!marker.latitude || !marker.longitude || !marker.name) return;
                    const popupDescription = marker.description ? `<br>${marker.description}` : '';
                    const editorMarker = L.marker([marker.latitude, marker.longitude]).addTo(editorMap);
                    const previewMarker = L.marker([marker.latitude, marker.longitude]).addTo(previewMap);
                    editorMarker.bindPopup(`<strong>${marker.name}</strong>${popupDescription}`);
                    previewMarker.bindPopup(`<strong>${marker.name}</strong>${popupDescription}`);
                    editorMarkers.push(editorMarker);
                    previewMarkers.push(previewMarker);
                });

                previewMarkerCount.textContent = String(markers.length);
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
                    card.className = 'rounded-2xl border border-slate-200 bg-slate-50 p-5';
                    card.innerHTML = `
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">${marker.category || 'Lokasi'}</span>
                                    <span class="text-xs text-slate-500">${marker.latitude}, ${marker.longitude}</span>
                                </div>
                                <h3 class="mt-3 text-lg font-semibold text-slate-900">${marker.name || '-'}</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-600">${marker.description || 'Tanpa deskripsi tambahan.'}</p>
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

            const clearMarkerModal = () => {
                modalFields.name.value = '';
                modalFields.category.value = '';
                modalFields.latitude.value = '';
                modalFields.longitude.value = '';
                modalFields.description.value = '';
            };

            const openMarkerModal = (mode = 'create', index = null) => {
                modalMode = mode;
                editingMarkerIndex = index;
                clearMarkerModal();
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
                    category: modalFields.category.value.trim(),
                    latitude: modalFields.latitude.value.trim(),
                    longitude: modalFields.longitude.value.trim(),
                    description: modalFields.description.value.trim(),
                };
                if (!payload.name || !payload.latitude || !payload.longitude) {
                    window.showError?.('Data marker belum lengkap', 'Nama marker, latitude, dan longitude wajib diisi.');
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

            document.querySelectorAll('[data-open-marker-modal]').forEach((button) => {
                button.addEventListener('click', () => openMarkerModal(button.dataset.markerMode || 'create'));
            });
            document.querySelectorAll('[data-close-marker-modal]').forEach((button) => {
                button.addEventListener('click', closeMarkerModal);
            });
            modalOverlay.addEventListener('click', (event) => {
                if (event.target === modalOverlay) closeMarkerModal();
            });
            saveModalButton.addEventListener('click', saveMarkerFromModal);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    if (!modalOverlay.classList.contains('hidden')) closeMarkerModal();
                    document.querySelectorAll('[data-modal]').forEach((modal) => {
                        if (!modal.classList.contains('hidden')) closeModal(modal.dataset.modal);
                    });
                }
            });

            renderMarkerCards();
            setTimeout(() => {
                previewMap.invalidateSize();
                editorMap.invalidateSize();
            }, 100);
        });
    </script>
@endsection
