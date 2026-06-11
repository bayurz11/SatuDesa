@extends('layouts.app')

@section('content')
    @php
        $resolvePhotoUrl = function ($path) {
            if (! filled($path)) {
                return asset('img/avatar-placeholder.png');
            }

            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            if (str_starts_with($path, 'img/')) {
                return asset($path);
            }

            return \App\Support\UploadStorage::url($path);
        };

        $organizationHead = old('organization_head', $organizationHead ?? []);
        $organizationPartner = old('organization_partner', $organizationPartner ?? []);
        $organizationSecretary = old('organization_secretary', $organizationSecretary ?? []);
        $organizationKaurItems = old('organization_kaur_items', $organizationKaurItems ?? []);
        $organizationKasiItems = old('organization_kasi_items', $organizationKasiItems ?? []);
        $organizationDusunItems = old('organization_dusun_items', $organizationDusunItems ?? []);
        $publicOrganizationUrl = route('public.organization-structure');
    @endphp

    <div class="space-y-8 animate-fadeInUp">
        <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-gradient-to-r from-white via-slate-50 to-blue-50 shadow-lg shadow-slate-200/60">
            <div class="p-8">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                    <div class="flex max-w-3xl gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75v10.5M12 9v8.25M6.75 11.25v6M4.5 19.5h15" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-700">Profil Desa</p>
                            <h1 class="mt-2 text-4xl font-bold text-slate-900">Manajemen Struktur Organisasi</h1>
                            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                                Kelola struktur organisasi publik, susunan perangkat desa, dan foto tiap jabatan dari satu halaman admin yang konsisten.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row xl:flex-col">
                        <div class="rounded-2xl border border-white/80 bg-white/80 px-5 py-4 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Desa Aktif</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $village->name }}</p>
                        </div>
                        <a href="{{ $publicOrganizationUrl }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-4 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition hover:brightness-95">
                            Buka Halaman Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('village-organizations.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <main class="space-y-8">
                <section class="module-panel">
                    <div class="module-panel-header px-6 py-6">
                        <div class="flex items-center justify-between gap-4 flex-col sm:flex-row">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Identitas Halaman Publik</h2>
                                <p class="mt-1 text-sm text-gray-600">Bagian ini mengatur judul halaman, ringkasan pembuka, bagan utama, dan catatan samping.</p>
                            </div>
                            @permission('village_organizations.edit')
                                <button type="submit" class="module-primary-btn px-6 py-3 text-sm">Simpan Perubahan</button>
                            @endpermission
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 grid gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Judul Halaman</label>
                            <input type="text" name="organization_page_title" value="{{ old('organization_page_title', $profile->organization_page_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Halaman</label>
                            <textarea name="organization_page_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('organization_page_description', $profile->organization_page_description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Badge Bagan</label>
                            <input type="text" name="organization_section_badge" value="{{ old('organization_section_badge', $profile->organization_section_badge) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Judul Bagan</label>
                            <input type="text" name="organization_section_title" value="{{ old('organization_section_title', $profile->organization_section_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Bagan</label>
                            <textarea name="organization_section_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('organization_section_description', $profile->organization_section_description) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Catatan Struktur</label>
                            <textarea name="organization_note" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('organization_note', $profile->organization_note) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Judul Panel Samping</label>
                            <input type="text" name="organization_sidebar_title" value="{{ old('organization_sidebar_title', $profile->organization_sidebar_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Panel Samping</label>
                            <textarea name="organization_sidebar_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('organization_sidebar_description', $profile->organization_sidebar_description) }}</textarea>
                        </div>
                    </div>
                </section>

                @php
                    $topPositions = [
                        'organization_head' => ['title' => 'Kepala Desa', 'data' => $organizationHead, 'upload' => 'organization_head_photo'],
                        'organization_partner' => ['title' => 'Mitra Desa / BPD', 'data' => $organizationPartner, 'upload' => 'organization_partner_photo'],
                        'organization_secretary' => ['title' => 'Sekretariat Desa', 'data' => $organizationSecretary, 'upload' => 'organization_secretary_photo'],
                    ];
                @endphp

                <section class="module-panel">
                    <div class="module-panel-header px-6 py-5">
                        <h2 class="text-xl font-semibold text-gray-900">Jabatan Inti</h2>
                        <p class="mt-1 text-sm text-gray-600">Tiga posisi utama ini mengikuti pola tampilan publik di bagian atas bagan organisasi.</p>
                    </div>

                    <div class="p-6 sm:p-8 grid gap-6 xl:grid-cols-3">
                        @foreach ($topPositions as $field => $position)
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $resolvePhotoUrl($position['data']['photo_path'] ?? null) }}" alt="{{ $position['title'] }}" class="h-16 w-16 rounded-full border-4 border-white object-cover shadow-sm">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $position['title'] }}</h3>
                                        <p class="text-sm text-gray-500">Upload foto dan isi teks yang tampil di publik.</p>
                                    </div>
                                </div>

                                <div class="mt-5 space-y-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Label</label>
                                        <input type="text" name="{{ $field }}[label]" value="{{ $position['data']['label'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Judul / Nama Jabatan</label>
                                        <input type="text" name="{{ $field }}[title]" value="{{ $position['data']['title'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Nama / Keterangan</label>
                                        <input type="text" name="{{ $field }}[name]" value="{{ $position['data']['name'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    </div>
                                    <input type="hidden" name="{{ $field }}[photo_path]" value="{{ $position['data']['photo_path'] ?? 'img/avatar-placeholder.png' }}">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Foto</label>
                                        <input type="file" name="{{ $position['upload'] }}" accept="image/*" class="mt-2 block w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-semibold file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                @php
                    $groups = [
                        'organization_kaur_items' => ['title' => 'Kaur', 'items' => $organizationKaurItems, 'upload' => 'organization_kaur_photos'],
                        'organization_kasi_items' => ['title' => 'Kasi', 'items' => $organizationKasiItems, 'upload' => 'organization_kasi_photos'],
                        'organization_dusun_items' => ['title' => 'Kepala Dusun', 'items' => $organizationDusunItems, 'upload' => 'organization_dusun_photos'],
                    ];
                @endphp

                @foreach ($groups as $groupField => $group)
                    <section class="module-panel">
                        <div class="module-panel-header px-6 py-5">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $group['title'] }}</h2>
                            <p class="mt-1 text-sm text-gray-600">Bagian ini mengikuti tiga kartu perangkat desa seperti tampilan publik saat ini.</p>
                        </div>

                        <div class="p-6 sm:p-8 grid gap-6 xl:grid-cols-3">
                            @foreach ($group['items'] as $index => $item)
                                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $resolvePhotoUrl($item['photo_path'] ?? null) }}" alt="{{ $item['title'] ?? 'Foto perangkat desa' }}" class="h-14 w-14 rounded-full border-4 border-green-50 object-cover shadow-sm">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900">Item {{ $index + 1 }}</h3>
                                            <p class="text-sm text-gray-500">Foto dan teks tampil langsung di publik.</p>
                                        </div>
                                    </div>

                                    <div class="mt-5 space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700">Label</label>
                                            <input type="text" name="{{ $groupField }}[{{ $index }}][label]" value="{{ $item['label'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700">Jabatan</label>
                                            <input type="text" name="{{ $groupField }}[{{ $index }}][title]" value="{{ $item['title'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700">Nama / Keterangan</label>
                                            <input type="text" name="{{ $groupField }}[{{ $index }}][name]" value="{{ $item['name'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                        </div>
                                        <input type="hidden" name="{{ $groupField }}[{{ $index }}][photo_path]" value="{{ $item['photo_path'] ?? 'img/avatar-placeholder.png' }}">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700">Foto</label>
                                            <input type="file" name="{{ $group['upload'] }}[{{ $index }}]" accept="image/*" class="mt-2 block w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-green-50 file:px-3 file:py-2 file:font-semibold file:text-green-700 hover:file:bg-green-100">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </main>
        </form>
    </div>
@endsection
