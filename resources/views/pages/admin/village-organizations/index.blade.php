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

        $publicOrganizationUrl = route('public.organization-structure');
        $identity = $organizationIdentity ?? [];
        $positionOptions = collect($organizationPositionOptions ?? [])->values();
        $members = collect($organizationMembers ?? [])->values();
    @endphp

    <div class="space-y-8 animate-fadeInUp">
        <div class="profile-module-hero">
            <div class="p-8">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                    <div class="flex max-w-3xl gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75v10.5M12 9v8.25M6.75 11.25v6M4.5 19.5h15" />
                            </svg>
                        </div>
                        <div>
                            <p class="profile-module-kicker">Profil Desa</p>
                            <h1 class="profile-module-heading">Manajemen Struktur Organisasi</h1>
                            <p class="profile-module-copy">
                                Kelola identitas halaman, master jabatan, dan data struktur organisasi publik lewat tabel ringkas dan modal input.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row xl:flex-col">
                        <div class="profile-module-stat">
                            <p class="profile-module-stat-label">Desa Aktif</p>
                            <p class="text-lg font-semibold text-slate-900 mt-2">{{ $village->name }}</p>
                        </div>
                        <a href="{{ $publicOrganizationUrl }}" target="_blank" rel="noopener noreferrer"
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5h18M3 12h18M3 16.5h12" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="profile-module-heading">Struktur Organisasi Desa</h2>
                            <p class="profile-module-copy">
                                Semua data di bawah ini langsung membentuk tampilan halaman publik. Gunakan master jabatan untuk isi dropdown, lalu tambahkan anggota struktur sesuai kebutuhan.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="profile-module-stat">
                            <p class="profile-module-stat-label">Identitas Publik</p>
                            <p class="profile-module-stat-value">1</p>
                            <p class="profile-module-stat-note text-blue-600">Satu set aktif</p>
                        </div>
                        <div class="profile-module-stat">
                            <p class="profile-module-stat-label">Master Jabatan</p>
                            <p class="profile-module-stat-value">{{ $positionOptions->count() }}</p>
                            <p class="profile-module-stat-note text-emerald-600">Dropdown siap pakai</p>
                        </div>
                        <div class="profile-module-stat">
                            <p class="profile-module-stat-label">Data Struktur</p>
                            <p class="profile-module-stat-value">{{ $members->count() }}</p>
                            <p class="profile-module-stat-note text-amber-600">Tampil ke publik</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 bg-slate-50/70 px-8 py-6">
                <div class="grid gap-8">
                    <section class="rounded-[28px] border border-slate-200 bg-white shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="profile-module-section-title">Identitas Halaman Publik</h3>
                                <p class="profile-module-section-copy">Kelola judul, deskripsi, catatan, dan panel samping publik lewat satu tombol khusus.</p>
                            </div>
                            @permission('village_organizations.edit')
                                <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-open-modal="identity-modal">
                                    Atur Identitas Halaman
                                </button>
                            @endpermission
                        </div>

                        <div class="overflow-x-auto">
                            <table class="profile-module-table min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr class="text-left">
                                        <th class="px-6 py-4">Judul Halaman</th>
                                        <th class="px-6 py-4">Badge</th>
                                        <th class="px-6 py-4">Judul Bagan</th>
                                        <th class="px-6 py-4">Panel Samping</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    <tr class="align-top text-sm text-slate-700">
                                        <td class="px-6 py-5">
                                            <p class="font-semibold text-slate-900">{{ $identity['page_title'] ?? '-' }}</p>
                                            <p class="mt-1 max-w-md text-slate-500 line-clamp-2">{{ $identity['page_description'] ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-5">{{ $identity['section_badge'] ?? '-' }}</td>
                                        <td class="px-6 py-5">
                                            <p class="font-medium text-slate-900">{{ $identity['section_title'] ?? '-' }}</p>
                                            <p class="mt-1 max-w-md text-slate-500 line-clamp-2">{{ $identity['section_description'] ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-5">
                                            <p class="font-medium text-slate-900">{{ $identity['sidebar_title'] ?? '-' }}</p>
                                            <p class="mt-1 max-w-sm text-slate-500 line-clamp-2">{{ $identity['sidebar_description'] ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex justify-end gap-2">
                                                @permission('village_organizations.edit')
                                                    <button type="button" class="module-edit-btn" data-open-modal="identity-modal">Edit</button>
                                                    <form method="POST" action="{{ route('village-organizations.identity.reset') }}" onsubmit="return confirm('Reset identitas halaman ke data awal?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="module-danger-btn">Hapus</button>
                                                    </form>
                                                @endpermission
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="rounded-[28px] border border-slate-200 bg-white shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="profile-module-section-title">Master Jabatan</h3>
                                <p class="profile-module-section-copy">Data di sini menjadi sumber dropdown untuk input struktur organisasi.</p>
                            </div>
                            @permission('village_organizations.edit')
                                <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-open-modal="position-modal" data-position-action="create">
                                    Tambah Jabatan
                                </button>
                            @endpermission
                        </div>

                        <div class="overflow-x-auto">
                            <table class="profile-module-table min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr class="text-left">
                                        <th class="px-6 py-4">Label</th>
                                        <th class="px-6 py-4">Judul Jabatan</th>
                                        <th class="px-6 py-4">Kelompok</th>
                                        <th class="px-6 py-4">Urutan</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    @forelse ($positionOptions as $option)
                                        <tr class="text-sm text-slate-700">
                                            <td class="px-6 py-5 font-semibold text-slate-900">{{ $option['label'] }}</td>
                                            <td class="px-6 py-5">{{ $option['title'] }}</td>
                                            <td class="px-6 py-5">{{ $organizationGroups[$option['group']] ?? $option['group'] }}</td>
                                            <td class="px-6 py-5">{{ $option['sort_order'] ?? 0 }}</td>
                                            <td class="px-6 py-5">
                                                <div class="flex justify-end gap-2">
                                                    @permission('village_organizations.edit')
                                                        <button type="button" class="module-edit-btn"
                                                            data-open-modal="position-modal"
                                                            data-position-action="edit"
                                                            data-position='@json($option)'>Edit</button>
                                                        <form method="POST" action="{{ route('village-organizations.positions.destroy', $option['id']) }}" onsubmit="return confirm('Hapus jabatan ini? Anggota yang memakai jabatan ini juga akan ikut terhapus.')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="module-danger-btn">Hapus</button>
                                                        </form>
                                                    @endpermission
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">Belum ada data jabatan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="rounded-[28px] border border-slate-200 bg-white shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="profile-module-section-title">Data Struktur Organisasi</h3>
                                <p class="profile-module-section-copy">Data ini yang langsung ditampilkan pada halaman publik sesuai jabatan yang dipilih dari dropdown.</p>
                            </div>
                            @permission('village_organizations.edit')
                                <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-open-modal="member-modal" data-member-action="create">
                                    Tambah Data Struktur
                                </button>
                            @endpermission
                        </div>

                        <div class="overflow-x-auto">
                            <table class="profile-module-table min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr class="text-left">
                                        <th class="px-6 py-4">Foto</th>
                                        <th class="px-6 py-4">Jabatan</th>
                                        <th class="px-6 py-4">Kelompok</th>
                                        <th class="px-6 py-4">Nama / Keterangan</th>
                                        <th class="px-6 py-4">Urutan</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    @forelse ($members as $member)
                                        <tr class="text-sm text-slate-700">
                                            <td class="px-6 py-5">
                                                <img src="{{ $resolvePhotoUrl($member['photo_path'] ?? null) }}" alt="{{ $member['position_title'] }}" class="h-12 w-12 rounded-full border border-slate-200 object-cover">
                                            </td>
                                            <td class="px-6 py-5">
                                                <p class="font-semibold text-slate-900">{{ $member['position_title'] }}</p>
                                                <p class="mt-1 text-slate-500">{{ $member['position_label'] }}</p>
                                            </td>
                                            <td class="px-6 py-5">{{ $member['group_label'] }}</td>
                                            <td class="px-6 py-5">{{ $member['name'] }}</td>
                                            <td class="px-6 py-5">{{ $member['sort_order'] ?? 0 }}</td>
                                            <td class="px-6 py-5">
                                                <div class="flex justify-end gap-2">
                                                    @permission('village_organizations.edit')
                                                        <button type="button" class="module-edit-btn"
                                                            data-open-modal="member-modal"
                                                            data-member-action="edit"
                                                            data-member='@json($member)'>Edit</button>
                                                        <form method="POST" action="{{ route('village-organizations.members.destroy', $member['id']) }}" onsubmit="return confirm('Hapus data struktur ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="module-danger-btn">Hapus</button>
                                                        </form>
                                                    @endpermission
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">Belum ada data struktur organisasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>

    @permission('village_organizations.edit')
        <div class="app-modal-overlay hidden" data-modal="identity-modal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-3xl">
                    <form method="POST" action="{{ route('village-organizations.identity.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="module-panel-header px-6 py-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Identitas Publik</p>
                                    <h2 class="mt-1 text-xl font-semibold text-gray-900">Atur Identitas Halaman</h2>
                                </div>
                                <button type="button" class="module-neutral-btn px-3 py-2 text-sm" data-close-modal="identity-modal">Tutup</button>
                            </div>
                        </div>
                        <div class="app-modal-body px-6 py-6">
                            <div class="grid gap-5 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Judul Halaman</label>
                                    <input type="text" name="page_title" value="{{ $identity['page_title'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Deskripsi Halaman</label>
                                    <textarea name="page_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ $identity['page_description'] ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Badge</label>
                                    <input type="text" name="section_badge" value="{{ $identity['section_badge'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Judul Bagan</label>
                                    <input type="text" name="section_title" value="{{ $identity['section_title'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Deskripsi Bagan</label>
                                    <textarea name="section_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ $identity['section_description'] ?? '' }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Catatan Publik</label>
                                    <textarea name="note" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ $identity['note'] ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Judul Panel Samping</label>
                                    <input type="text" name="sidebar_title" value="{{ $identity['sidebar_title'] ?? '' }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Deskripsi Panel Samping</label>
                                    <textarea name="sidebar_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ $identity['sidebar_description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" class="module-neutral-btn px-4 py-3 text-sm" data-close-modal="identity-modal">Batal</button>
                            <button type="submit" class="module-primary-btn px-5 py-3 text-sm">Simpan Identitas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="app-modal-overlay hidden" data-modal="position-modal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-2xl">
                    <form method="POST" action="{{ route('village-organizations.positions.store') }}" data-position-form>
                        @csrf
                        <input type="hidden" name="_method" value="POST" data-position-method>
                        <div class="module-panel-header px-6 py-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Master Jabatan</p>
                                    <h2 class="mt-1 text-xl font-semibold text-gray-900" data-position-modal-title>Tambah Jabatan</h2>
                                </div>
                                <button type="button" class="module-neutral-btn px-3 py-2 text-sm" data-close-modal="position-modal">Tutup</button>
                            </div>
                        </div>
                        <div class="app-modal-body px-6 py-6">
                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Label</label>
                                    <input type="text" name="label" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-position-label>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Kelompok</label>
                                    <select name="group" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-position-group>
                                        @foreach ($organizationGroups as $groupKey => $groupLabel)
                                            <option value="{{ $groupKey }}">{{ $groupLabel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Judul Jabatan</label>
                                    <input type="text" name="title" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-position-title>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Urutan</label>
                                    <input type="number" name="sort_order" min="0" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-position-sort>
                                </div>
                            </div>
                        </div>
                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" class="module-neutral-btn px-4 py-3 text-sm" data-close-modal="position-modal">Batal</button>
                            <button type="submit" class="module-primary-btn px-5 py-3 text-sm">Simpan Jabatan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="app-modal-overlay hidden" data-modal="member-modal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-2xl">
                    <form method="POST" action="{{ route('village-organizations.members.store') }}" enctype="multipart/form-data" data-member-form>
                        @csrf
                        <input type="hidden" name="photo_path" value="img/avatar-placeholder.png" data-member-photo-path>
                        <input type="hidden" name="_method" value="POST" data-member-method>
                        <div class="module-panel-header px-6 py-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Data Struktur</p>
                                    <h2 class="mt-1 text-xl font-semibold text-gray-900" data-member-modal-title>Tambah Data Struktur</h2>
                                </div>
                                <button type="button" class="module-neutral-btn px-3 py-2 text-sm" data-close-modal="member-modal">Tutup</button>
                            </div>
                        </div>
                        <div class="app-modal-body px-6 py-6">
                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Jabatan</label>
                                    <select name="position_option_id" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-member-position>
                                        @foreach ($positionOptions as $option)
                                            <option value="{{ $option['id'] }}">{{ $option['title'] }} ({{ $organizationGroups[$option['group']] ?? $option['group'] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Urutan</label>
                                    <input type="number" name="sort_order" min="0" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-member-sort>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Nama / Keterangan</label>
                                    <input type="text" name="name" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-member-name>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Foto</label>
                                    <input type="file" name="photo" accept="image/*" class="mt-2 block w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-green-50 file:px-3 file:py-2 file:font-semibold file:text-green-700 hover:file:bg-green-100">
                                </div>
                            </div>
                        </div>
                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" class="module-neutral-btn px-4 py-3 text-sm" data-close-modal="member-modal">Batal</button>
                            <button type="submit" class="module-primary-btn px-5 py-3 text-sm">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endpermission

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openButtons = document.querySelectorAll('[data-open-modal]');
            const closeButtons = document.querySelectorAll('[data-close-modal]');

            const openModal = (name) => {
                const modal = document.querySelector(`[data-modal="${name}"]`);
                if (!modal) return;
                modal.classList.remove('hidden');
                document.body.classList.add('modal-open');
            };

            const closeModal = (name) => {
                const modal = document.querySelector(`[data-modal="${name}"]`);
                if (!modal) return;
                modal.classList.add('hidden');
                document.body.classList.remove('modal-open');
            };

            openButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const modalName = button.dataset.openModal;

                    if (modalName === 'position-modal') {
                        const form = document.querySelector('[data-position-form]');
                        const method = document.querySelector('[data-position-method]');
                        const title = document.querySelector('[data-position-modal-title]');
                        form.action = @json(route('village-organizations.positions.store'));
                        method.value = 'POST';
                        title.textContent = 'Tambah Jabatan';
                        form.querySelector('[data-position-label]').value = '';
                        form.querySelector('[data-position-title]').value = '';
                        form.querySelector('[data-position-group]').value = 'pimpinan';
                        form.querySelector('[data-position-sort]').value = '';

                        if (button.dataset.positionAction === 'edit' && button.dataset.position) {
                            const data = JSON.parse(button.dataset.position);
                            form.action = @json(url('admin/profil-desa/struktur-organisasi/jabatan')) + '/' + data.id;
                            method.value = 'PUT';
                            title.textContent = 'Edit Jabatan';
                            form.querySelector('[data-position-label]').value = data.label ?? '';
                            form.querySelector('[data-position-title]').value = data.title ?? '';
                            form.querySelector('[data-position-group]').value = data.group ?? 'pimpinan';
                            form.querySelector('[data-position-sort]').value = data.sort_order ?? '';
                        }
                    }

                    if (modalName === 'member-modal') {
                        const form = document.querySelector('[data-member-form]');
                        const method = document.querySelector('[data-member-method]');
                        const title = document.querySelector('[data-member-modal-title]');
                        form.action = @json(route('village-organizations.members.store'));
                        method.value = 'POST';
                        title.textContent = 'Tambah Data Struktur';
                        form.querySelector('[data-member-position]').value = form.querySelector('[data-member-position]')?.options[0]?.value ?? '';
                        form.querySelector('[data-member-name]').value = '';
                        form.querySelector('[data-member-sort]').value = '';
                        form.querySelector('[data-member-photo-path]').value = 'img/avatar-placeholder.png';

                        if (button.dataset.memberAction === 'edit' && button.dataset.member) {
                            const data = JSON.parse(button.dataset.member);
                            form.action = @json(url('admin/profil-desa/struktur-organisasi/anggota')) + '/' + data.id;
                            method.value = 'POST';
                            title.textContent = 'Edit Data Struktur';
                            form.querySelector('[data-member-position]').value = data.position_option_id ?? '';
                            form.querySelector('[data-member-name]').value = data.name ?? '';
                            form.querySelector('[data-member-sort]').value = data.sort_order ?? '';
                            form.querySelector('[data-member-photo-path]').value = data.photo_path ?? 'img/avatar-placeholder.png';
                        }
                    }

                    openModal(modalName);
                });
            });

            closeButtons.forEach((button) => {
                button.addEventListener('click', () => closeModal(button.dataset.closeModal));
            });

            document.querySelectorAll('[data-modal]').forEach((modal) => {
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeModal(modal.dataset.modal);
                    }
                });
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    document.querySelectorAll('[data-modal]').forEach((modal) => {
                        if (!modal.classList.contains('hidden')) {
                            closeModal(modal.dataset.modal);
                        }
                    });
                }
            });
        });
    </script>
@endsection
