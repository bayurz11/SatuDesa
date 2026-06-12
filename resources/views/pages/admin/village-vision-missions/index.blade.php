@extends('layouts.app')

@section('content')
    @php
        $missionItems = collect(old('vision_mission_mission_items', $missionItems ?? []))->values()->all();
    @endphp

    <div class="space-y-8 animate-fadeInUp">
        <div class="admin-module-hero">
            <div class="admin-module-hero-band px-6 py-6">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="admin-module-icon">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M12 3l7 4v5c0 5-3 8-7 9-4-1-7-4-7-9V7l7-4z" />
                            </svg>
                        </div>
                        <div>
                            <p class="admin-module-kicker">Profil Desa</p>
                            <h1 class="admin-module-title">Manajemen Visi &amp; Misi Desa</h1>
                            <p class="admin-module-description">Kelola judul halaman, visi utama, daftar misi, dan panel samping untuk halaman publik.</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <div class="admin-module-toolbar-card">
                            <div class="text-sm font-medium text-gray-500">Desa Aktif</div>
                            <div class="text-lg font-semibold text-gray-900 mt-1">{{ $village->name }}</div>
                        </div>
                        <a href="{{ route('public.vision-mission') }}" target="_blank" rel="noopener noreferrer"
                            class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300">
                            Buka Halaman Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('village-vision-missions.update') }}" class="space-y-8">
            @csrf
            @method('PUT')

            <section class="admin-module-hero">
                <div class="admin-module-hero-band px-6 py-6 border-b border-gray-200">
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                            <div>
                                <h2 class="admin-module-title">Visi &amp; Misi</h2>
                                <p class="admin-module-description">Atur keseluruhan konten publik dari satu form. Item misi ditambah dan diedit lewat modal.</p>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="admin-module-summary-card">
                                    <p class="admin-module-summary-label">Visi Aktif</p>
                                    <p class="admin-module-summary-value">1</p>
                                    <p class="admin-module-summary-note text-blue-600">Pernyataan utama</p>
                                </div>
                                <div class="admin-module-summary-card">
                                    <p class="admin-module-summary-label">Daftar Misi</p>
                                    <p class="admin-module-summary-value" data-mission-count>{{ count($missionItems) }}</p>
                                    <p class="admin-module-summary-note text-emerald-600">Item publik aktif</p>
                                </div>
                                <div class="admin-module-summary-card">
                                    <p class="admin-module-summary-label">Panel Samping</p>
                                    <p class="admin-module-summary-value">1</p>
                                    <p class="admin-module-summary-note text-amber-600">Info arah pembangunan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 bg-white px-6 py-6 space-y-8">
                    <section class="admin-module-section">
                        <div class="admin-module-section-header px-6 py-5">
                            <div class="flex items-center justify-between gap-4 flex-col sm:flex-row">
                                <div>
                                    <h3 class="admin-module-section-title">Identitas Halaman Publik</h3>
                                    <p class="admin-module-section-description">Bagian ini mengatur hero halaman, badge, dan deskripsi pembuka.</p>
                                </div>
                                @permission('village_vision_missions.edit')
                                    <button type="submit" class="module-primary-btn px-6 py-3 text-sm">Simpan Perubahan</button>
                                @endpermission
                            </div>
                        </div>

                        <div class="p-6 sm:p-8 grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Badge Hero</label>
                                <input type="text" name="vision_mission_hero_badge" value="{{ old('vision_mission_hero_badge', $profile->vision_mission_hero_badge) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Judul Halaman</label>
                                <input type="text" name="vision_mission_title" value="{{ old('vision_mission_title', $profile->vision_mission_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Deskripsi Halaman</label>
                                <textarea name="vision_mission_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('vision_mission_description', $profile->vision_mission_description) }}</textarea>
                            </div>
                        </div>
                    </section>

                    <section class="admin-module-section">
                        <div class="admin-module-section-header px-6 py-5">
                            <div>
                                <h3 class="admin-module-section-title">Visi Desa</h3>
                                <p class="admin-module-section-description">Isi pernyataan visi utama dan narasi pendukung yang tampil pada kartu hero publik.</p>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8 grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Badge Visi</label>
                                <input type="text" name="vision_mission_vision_badge" value="{{ old('vision_mission_vision_badge', $profile->vision_mission_vision_badge) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Judul Kartu Visi</label>
                                <input type="text" name="vision_mission_vision_title" value="{{ old('vision_mission_vision_title', $profile->vision_mission_vision_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Pernyataan Visi</label>
                                <textarea name="vision" rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('vision', $profile->vision) }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Deskripsi Visi</label>
                                <textarea name="vision_mission_vision_description" rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('vision_mission_vision_description', $profile->vision_mission_vision_description) }}</textarea>
                            </div>
                        </div>
                    </section>

                    <section class="admin-module-section">
                        <div class="admin-module-section-header px-6 py-5">
                            <div class="flex items-center justify-between gap-4 flex-col sm:flex-row">
                                <div>
                                    <h3 class="admin-module-section-title">Daftar Misi Desa</h3>
                                    <p class="admin-module-section-description">Kelola daftar langkah strategis pembangunan desa. Tambah dan edit item dilakukan lewat modal.</p>
                                </div>
                                @permission('village_vision_missions.edit')
                                    <button type="button" class="module-neutral-btn px-4 py-2 text-sm" data-open-mission-modal data-mission-mode="create">
                                        Tambah Misi
                                    </button>
                                @endpermission
                            </div>
                        </div>

                        <div class="p-6 sm:p-8 grid gap-6">
                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Badge Misi</label>
                                    <input type="text" name="vision_mission_mission_badge" value="{{ old('vision_mission_mission_badge', $profile->vision_mission_mission_badge) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Judul Bagian Misi</label>
                                    <input type="text" name="vision_mission_mission_title" value="{{ old('vision_mission_mission_title', $profile->vision_mission_mission_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                </div>
                            </div>

                            <div class="hidden" data-mission-hidden-inputs></div>
                            <div class="space-y-4" id="vision-mission-admin" data-initial-mission-items='@json($missionItems)'>
                                <div class="grid gap-4 lg:grid-cols-2" data-mission-list-display></div>
                                <div class="admin-module-empty hidden" data-empty-mission-state>
                                    Belum ada item misi. Gunakan tombol `Tambah Misi` untuk menambahkan langkah strategis desa.
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="admin-module-section">
                        <div class="admin-module-section-header px-6 py-5">
                            <h3 class="admin-module-section-title">Catatan Samping</h3>
                        </div>

                        <div class="p-6 sm:p-8 grid gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Judul Panel Samping</label>
                                <input type="text" name="vision_mission_sidebar_title" value="{{ old('vision_mission_sidebar_title', $profile->vision_mission_sidebar_title) }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Deskripsi Panel Samping</label>
                                <textarea name="vision_mission_sidebar_description" rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('vision_mission_sidebar_description', $profile->vision_mission_sidebar_description) }}</textarea>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </form>

        @permission('village_vision_missions.edit')
            <div class="app-modal-overlay hidden" data-mission-modal-overlay>
                <div class="app-modal-shell">
                    <div class="app-modal-panel max-w-2xl">
                        <div class="module-panel-header px-6 py-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Daftar Misi</p>
                                    <h2 class="mt-1 text-xl font-semibold text-gray-900" data-mission-modal-title>Tambah Misi</h2>
                                </div>
                                <button type="button" class="module-neutral-btn px-3 py-2 text-sm" data-close-mission-modal>Tutup</button>
                            </div>
                        </div>

                        <div class="app-modal-body px-6 py-6">
                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Ikon</label>
                                    <select class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-mission-form-icon>
                                        <option value="service">Service</option>
                                        <option value="chart">Chart</option>
                                        <option value="users">Users</option>
                                        <option value="document">Document</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Judul Misi</label>
                                    <input type="text" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-mission-form-title>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Deskripsi Misi</label>
                                    <textarea rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-mission-form-desc></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" class="module-neutral-btn px-4 py-3 text-sm" data-close-mission-modal>Batal</button>
                            <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-save-mission-modal>Simpan Misi</button>
                        </div>
                    </div>
                </div>
            </div>
        @endpermission
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const missionPage = document.getElementById('vision-mission-admin');

            if (!missionPage) {
                return;
            }

            const escapeHtml = (value) => String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

            const missionHiddenInputs = document.querySelector('[data-mission-hidden-inputs]');
            const missionDisplay = document.querySelector('[data-mission-list-display]');
            const missionCount = document.querySelector('[data-mission-count]');
            const emptyMissionState = document.querySelector('[data-empty-mission-state]');
            const missionModalOverlay = document.querySelector('[data-mission-modal-overlay]');
            const missionModalTitle = document.querySelector('[data-mission-modal-title]');
            const openMissionButtons = document.querySelectorAll('[data-open-mission-modal]');
            const closeMissionButtons = document.querySelectorAll('[data-close-mission-modal]');
            const saveMissionButton = document.querySelector('[data-save-mission-modal]');

            const missionModalFields = {
                title: document.querySelector('[data-mission-form-title]'),
                desc: document.querySelector('[data-mission-form-desc]'),
                icon: document.querySelector('[data-mission-form-icon]'),
            };

            if (!missionHiddenInputs || !missionDisplay || !missionCount || !emptyMissionState) {
                return;
            }

            let missionItems = [];
            try {
                missionItems = JSON.parse(missionPage.dataset.initialMissionItems || '[]');
            } catch (error) {
                missionItems = [];
            }

            let missionMode = 'create';
            let editingMissionIndex = null;

            const clearMissionModal = () => {
                missionModalFields.title.value = '';
                missionModalFields.desc.value = '';
                missionModalFields.icon.value = 'service';
            };

            const openMissionModal = (mode = 'create', index = null) => {
                if (!missionModalOverlay || !missionModalTitle || !missionModalFields.title || !missionModalFields.desc || !missionModalFields.icon) {
                    return;
                }

                missionMode = mode;
                editingMissionIndex = index;
                clearMissionModal();

                if (mode === 'edit' && index !== null && missionItems[index]) {
                    const item = missionItems[index];
                    missionModalTitle.textContent = 'Edit Misi';
                    missionModalFields.title.value = item.title || '';
                    missionModalFields.desc.value = item.desc || '';
                    missionModalFields.icon.value = item.icon || 'service';
                } else {
                    missionModalTitle.textContent = 'Tambah Misi';
                }

                missionModalOverlay.classList.remove('hidden');
                document.body.classList.add('modal-open');
            };

            const closeMissionModal = () => {
                if (!missionModalOverlay) {
                    return;
                }

                missionModalOverlay.classList.add('hidden');
                document.body.classList.remove('modal-open');
                editingMissionIndex = null;
            };

            const refreshMissionHiddenInputs = () => {
                missionHiddenInputs.innerHTML = '';

                missionItems.forEach((item, index) => {
                    ['title', 'desc', 'icon'].forEach((field) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `vision_mission_mission_items[${index}][${field}]`;
                        input.value = item[field] ?? '';
                        missionHiddenInputs.appendChild(input);
                    });
                });
            };

            const createMissionIconMarkup = (item) => {
                if ((item.icon || 'service') === 'chart') {
                    return `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M8 16v-5M12 16V8M16 16v-8" /></svg>`;
                }

                if ((item.icon || 'service') === 'users') {
                    return `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11a4 4 0 100-8 4 4 0 000 8zM4 21a8 8 0 0116 0M17 11a3 3 0 100-6" /></svg>`;
                }

                if ((item.icon || 'service') === 'document') {
                    return `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 6h8M8 10h8M8 14h5M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z" /></svg>`;
                }

                return `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" /></svg>`;
            };

            const renderMissionCards = () => {
                missionDisplay.innerHTML = '';
                missionCount.textContent = missionItems.length;

                if (missionItems.length === 0) {
                    emptyMissionState.classList.remove('hidden');
                    refreshMissionHiddenInputs();
                    return;
                }

                emptyMissionState.classList.add('hidden');

                missionItems.forEach((item, index) => {
                    const card = document.createElement('div');
                    card.className = 'module-soft-card rounded-2xl bg-white p-5';
                    const canEdit = Boolean(missionModalOverlay);
                    card.innerHTML = `
                        <div class="flex h-full flex-col gap-4">
                            <div class="flex items-start gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-green-50 text-green-700 ring-1 ring-green-100">
                                    ${createMissionIconMarkup(item)}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-green-700">Misi ${index + 1}</p>
                                    <h3 class="mt-1 text-lg font-bold text-gray-900">${escapeHtml(item.title || '-')}</h3>
                                    <p class="mt-2 text-sm leading-7 text-gray-600">${escapeHtml(item.desc || '-')}</p>
                                </div>
                            </div>
                            ${canEdit ? `<div class="flex gap-2 pt-1">
                                <button type="button" class="module-edit-btn" data-edit-mission="${index}">Edit</button>
                                <button type="button" class="module-danger-btn" data-delete-mission="${index}">Hapus</button>
                            </div>` : ''}
                        </div>
                    `;
                    missionDisplay.appendChild(card);
                });

                missionDisplay.querySelectorAll('[data-edit-mission]').forEach((button) => {
                    button.addEventListener('click', () => openMissionModal('edit', Number(button.dataset.editMission)));
                });

                missionDisplay.querySelectorAll('[data-delete-mission]').forEach((button) => {
                    button.addEventListener('click', () => {
                        missionItems.splice(Number(button.dataset.deleteMission), 1);
                        renderMissionCards();
                    });
                });

                refreshMissionHiddenInputs();
            };

            const saveMissionFromModal = () => {
                const payload = {
                    title: missionModalFields.title.value.trim(),
                    desc: missionModalFields.desc.value.trim(),
                    icon: missionModalFields.icon.value,
                };

                if (!payload.title || !payload.desc) {
                    window.showError('Data misi belum lengkap', 'Judul dan deskripsi misi harus diisi.');
                    return;
                }

                if (missionMode === 'edit' && editingMissionIndex !== null) {
                    missionItems[editingMissionIndex] = payload;
                } else {
                    missionItems.push(payload);
                }

                renderMissionCards();
                closeMissionModal();
            };

            openMissionButtons.forEach((button) => {
                button.addEventListener('click', () => openMissionModal(button.dataset.missionMode || 'create'));
            });

            closeMissionButtons.forEach((button) => {
                button.addEventListener('click', closeMissionModal);
            });

            if (missionModalOverlay) {
                missionModalOverlay.addEventListener('click', function(event) {
                    if (event.target === missionModalOverlay) {
                        closeMissionModal();
                    }
                });
            }

            if (saveMissionButton) {
                saveMissionButton.addEventListener('click', saveMissionFromModal);
            }

            document.addEventListener('keydown', function(event) {
                if (missionModalOverlay && event.key === 'Escape' && !missionModalOverlay.classList.contains('hidden')) {
                    closeMissionModal();
                }
            });

            renderMissionCards();
        });
    </script>
@endsection
