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

    <div class="space-y-6 animate-fadeInUp">
        <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 px-6 py-6 border-b border-gray-200">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.25 6.75v10.5M12 9v8.25M6.75 11.25v6M4.5 19.5h15" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-700">Profil Desa</p>
                            <h2 class="text-2xl font-bold text-gray-900 mt-1">Manajemen Struktur Organisasi</h2>
                            <p class="text-sm text-gray-600 mt-1">Kelola identitas halaman dan data struktur organisasi publik.</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <div class="px-4 py-3 bg-white border border-gray-300 rounded-xl">
                            <div class="text-sm font-medium text-gray-500">Desa Aktif</div>
                            <div class="text-lg font-semibold text-gray-900 mt-1">{{ $village->name }}</div>
                        </div>
                        <a href="{{ $publicOrganizationUrl }}" target="_blank" rel="noopener noreferrer"
                            class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300">
                            Buka Halaman Publik
                        </a>
                    </div>
                </div>
            </div>

            <div class="px-6 py-6 bg-white">
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 shadow-sm">
                        <p class="text-sm text-gray-500">Identitas Publik</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">1</p>
                        <p class="text-sm font-semibold text-blue-600 mt-3">Satu set aktif</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 shadow-sm">
                        <p class="text-sm text-gray-500">Master Jabatan</p>
                        <p class="text-lg font-bold text-gray-900 mt-2">Dipindah ke Settings</p>
                        <a href="{{ route('settings.organization-positions.index') }}" class="inline-flex mt-3 text-sm font-semibold text-emerald-600 hover:text-emerald-700">Kelola master jabatan</a>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 shadow-sm">
                        <p class="text-sm text-gray-500">Data Struktur</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $members->count() }}</p>
                        <p class="text-sm font-semibold text-amber-600 mt-3">Tampil ke publik</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 bg-white">
                <div class="grid gap-6 p-6">
                    <section class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-200 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Identitas Halaman Publik</h3>
                                <p class="text-sm text-gray-600 mt-1">Kelola judul, deskripsi, catatan, dan panel samping publik lewat satu tombol khusus.</p>
                            </div>
                            @permission('village_organizations.edit')
                                <button type="button" class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-5 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300" data-open-modal="identity-modal">
                                    Atur Identitas Halaman
                                </button>
                            @endpermission
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Judul Halaman</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Badge</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Judul Bagan</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Panel Samping</th>
                                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <tr class="align-top text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300">
                                        <td class="px-6 py-5">
                                            <p class="font-semibold text-gray-900">{{ $identity['page_title'] ?? '-' }}</p>
                                            <p class="mt-1 max-w-md text-gray-500 line-clamp-2">{{ $identity['page_description'] ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-5">{{ $identity['section_badge'] ?? '-' }}</td>
                                        <td class="px-6 py-5">
                                            <p class="font-medium text-gray-900">{{ $identity['section_title'] ?? '-' }}</p>
                                            <p class="mt-1 max-w-md text-gray-500 line-clamp-2">{{ $identity['section_description'] ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-5">
                                            <p class="font-medium text-gray-900">{{ $identity['sidebar_title'] ?? '-' }}</p>
                                            <p class="mt-1 max-w-sm text-gray-500 line-clamp-2">{{ $identity['sidebar_description'] ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex justify-end gap-2">
                                                @permission('village_organizations.edit')
                                                    <button type="button" class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition-all duration-200 hover:scale-105 hover:bg-blue-100 hover:text-blue-700" data-open-modal="identity-modal">Edit</button>
                                                    <form method="POST" action="{{ route('village-organizations.identity.reset') }}" onsubmit="return confirm('Reset identitas halaman ke data awal?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition-all duration-200 hover:scale-105 hover:bg-red-100 hover:text-red-700">Hapus</button>
                                                    </form>
                                                @endpermission
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-200 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Data Struktur Organisasi</h3>
                                <p class="text-sm text-gray-600 mt-1">Data ini langsung tampil di halaman publik. Master jabatan dikelola dari modul Settings.</p>
                            </div>
                            @permission('village_organizations.edit')
                                <button type="button" class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-5 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300" data-open-modal="member-modal" data-member-action="create">
                                    Tambah Data Struktur
                                </button>
                            @endpermission
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Foto</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Jabatan</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Kelompok</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Nama / Keterangan</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Urutan</th>
                                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse ($members as $member)
                                        <tr class="text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300">
                                            <td class="px-6 py-5">
                                                <img src="{{ $resolvePhotoUrl($member['photo_path'] ?? null) }}" alt="{{ $member['position_title'] }}" class="h-12 w-12 rounded-xl border border-gray-200 object-cover shadow-sm">
                                            </td>
                                            <td class="px-6 py-5">
                                                <p class="font-semibold text-gray-900">{{ $member['position_title'] }}</p>
                                                <p class="mt-1 text-gray-500">{{ $member['position_label'] }}</p>
                                            </td>
                                            <td class="px-6 py-5">{{ $member['group_label'] }}</td>
                                            <td class="px-6 py-5">{{ $member['name'] }}</td>
                                            <td class="px-6 py-5">{{ $member['sort_order'] ?? 0 }}</td>
                                            <td class="px-6 py-5">
                                                <div class="flex justify-end gap-2">
                                                    @permission('village_organizations.edit')
                                                        <button type="button" class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition-all duration-200 hover:scale-105 hover:bg-blue-100 hover:text-blue-700"
                                                            data-open-modal="member-modal"
                                                            data-member-action="edit"
                                                            data-member='@json($member)'>Edit</button>
                                                        <form method="POST" action="{{ route('village-organizations.members.destroy', $member['id']) }}" onsubmit="return confirm('Hapus data struktur ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition-all duration-200 hover:scale-105 hover:bg-red-100 hover:text-red-700">Hapus</button>
                                                        </form>
                                                    @endpermission
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada data struktur organisasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
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
