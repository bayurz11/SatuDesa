@extends('layouts.app')

@section('content')
    @php
        $positionOptions = collect($organizationPositionOptions ?? [])->values();
    @endphp

    <div class="space-y-6 animate-fadeInUp">
        <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 px-6 py-6 border-b border-gray-200">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.25 6.75h9m-9 5.25h9m-9 5.25h9M3.75 7.5h.008v.008H3.75V7.5Zm0 5.25h.008v.008H3.75v-.008Zm0 5.25h.008v.008H3.75V18Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-700">Settings</p>
                            <h2 class="text-2xl font-bold text-gray-900 mt-1">Master Jabatan Struktur Organisasi</h2>
                            <p class="text-sm text-gray-600 mt-1">Kelola daftar jabatan untuk dropdown struktur organisasi publik dari satu tabel ringkas.</p>
                        </div>
                    </div>

                    @permission('village_organizations.edit')
                        <button type="button" class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300" data-open-modal="position-modal">
                            Tambah Jabatan
                        </button>
                    @endpermission
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 shadow-sm">
                        <p class="text-sm text-gray-500">Total Jabatan</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $positionOptions->count() }}</p>
                        <p class="text-sm font-semibold text-blue-600 mt-3">Siap dipakai di dropdown</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 shadow-sm">
                        <p class="text-sm text-gray-500">Desa Aktif</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $village->name }}</p>
                        <p class="text-sm font-semibold text-emerald-600 mt-3">Sumber data publik aktif</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl px-5 py-4 shadow-sm">
                        <p class="text-sm text-gray-500">Modul Terkait</p>
                        <p class="text-lg font-bold text-gray-900 mt-2">Struktur Organisasi</p>
                        <a href="{{ route('village-organizations.index') }}" class="inline-flex mt-3 text-sm font-semibold text-purple-600 hover:text-purple-700">
                            Buka modul terkait
                        </a>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Label</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Judul Jabatan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Kelompok</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Urutan</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($positionOptions as $option)
                            <tr class="text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300">
                                <td class="px-6 py-5 font-semibold text-gray-900">{{ $option['label'] }}</td>
                                <td class="px-6 py-5">{{ $option['title'] }}</td>
                                <td class="px-6 py-5">{{ $organizationGroups[$option['group']] ?? $option['group'] }}</td>
                                <td class="px-6 py-5">{{ $option['sort_order'] ?? 0 }}</td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        @permission('village_organizations.edit')
                                            <button type="button" class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition-all duration-200 hover:scale-105 hover:bg-blue-100 hover:text-blue-700"
                                                data-open-modal="position-modal"
                                                data-position-action="edit"
                                                data-position='@json($option)'>Edit</button>
                                            <form method="POST" action="{{ route('village-organizations.positions.destroy', $option['id']) }}" onsubmit="return confirm('Hapus jabatan ini? Anggota yang memakai jabatan ini juga akan ikut terhapus.')">
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
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">Belum ada data jabatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @permission('village_organizations.edit')
        <div class="app-modal-overlay hidden" data-modal="position-modal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-2xl">
                    <form method="POST" action="{{ route('village-organizations.positions.store') }}" data-position-form>
                        @csrf
                        <input type="hidden" name="_method" value="POST" data-position-method>
                        <div class="module-panel-header px-6 py-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Settings</p>
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

                        openModal('position-modal');
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
    @endpermission
@endsection
