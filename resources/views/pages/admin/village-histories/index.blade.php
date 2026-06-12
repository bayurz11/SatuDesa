@extends('layouts.app')

@section('content')
    @php
        $historyCards = collect(old('history_cards', $historyCards ?? []))
            ->map(function ($card) {
                $imagePath = $card['image_path'] ?? null;
                $card['image_url'] = $imagePath
                    ? ((str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://'))
                        ? $imagePath
                        : (\Illuminate\Support\Str::startsWith($imagePath, 'img/')
                        ? asset($imagePath)
                        : \App\Support\UploadStorage::url($imagePath)))
                    : null;

                return $card;
            })
            ->values()
            ->all();
        $timelineItems = collect(old('history_timeline_items', $timelineItems ?? []))
            ->map(function ($item) {
                $iconImagePath = $item['icon_image_path'] ?? null;
                $item['icon_image_url'] = $iconImagePath
                    ? (\Illuminate\Support\Str::startsWith($iconImagePath, 'img/')
                        ? asset($iconImagePath)
                        : \App\Support\UploadStorage::url($iconImagePath))
                    : null;

                return $item;
            })
            ->values()
            ->all();
        $publicHistoryUrl = route('public.history');
        $coverImageUrl = filled($profile->history_cover_image_path)
            ? (str_starts_with($profile->history_cover_image_path, 'img/')
                ? asset($profile->history_cover_image_path)
                : \App\Support\UploadStorage::url($profile->history_cover_image_path))
            : asset('img/bg.jpg');
    @endphp

    <div class="space-y-8 animate-fadeInUp">
        <div class="profile-module-hero">
            <div class="p-8">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                    <div class="flex max-w-3xl gap-5">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="profile-module-kicker">Profil Desa</p>
                            <h1 class="profile-module-heading">Manajemen Sejarah Desa</h1>
                            <p class="profile-module-copy">
                                Kelola judul, narasi utama, kartu sejarah, dan linimasa publik dari satu halaman yang lebih ringkas dan mudah dipahami.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row xl:flex-col">
                        <div class="profile-module-stat">
                            <p class="profile-module-stat-label">Desa Aktif</p>
                            <p class="text-lg font-semibold text-slate-900 mt-2">{{ $village->name }}</p>
                        </div>
                        <a href="{{ $publicHistoryUrl }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-4 text-sm font-semibold text-white shadow-lg shadow-blue-500/25 transition hover:brightness-95">
                            Buka Halaman Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('village-histories.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <main class="space-y-8">
                <section class="module-panel">
                    <div class="module-panel-header px-6 py-6">
                        <div class="flex items-center justify-between gap-4 flex-col sm:flex-row">
                            <div>
                                <h2 class="profile-module-section-title">Identitas Halaman Publik</h2>
                                <p class="profile-module-section-copy">Bagian ini mengatur judul utama, deskripsi, badge hero, dan gambar sampul.</p>
                            </div>
                            @permission('village_histories.edit')
                                <button type="submit" class="module-primary-btn px-6 py-3 text-sm">Simpan Perubahan</button>
                            @endpermission
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 space-y-6">
                        <div class="rounded-2xl border border-blue-200 bg-gradient-to-r from-blue-50 to-indigo-50 p-6">
                            <div class="flex flex-col gap-5 lg:flex-row lg:items-start">
                                <div class="w-full max-w-xs">
                                    <img src="{{ $coverImageUrl }}" alt="{{ $profile->history_cover_title }}" class="h-48 w-full rounded-2xl object-cover shadow-lg">
                                </div>

                                <div class="flex-1 space-y-4">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900">Foto Sampul Sejarah</h4>
                                        <p class="mt-1 text-sm text-gray-600">Upload foto langsung seperti di modul berita. Foto baru akan menggantikan foto lama setelah data disimpan.</p>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-3">
                                        <label for="history-cover-image" class="cursor-pointer inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            Upload / Ganti Foto
                                        </label>
                                        <input type="file" id="history-cover-image" name="history_cover_image" accept="image/*" class="hidden">
                                        <span class="text-sm text-slate-500">Format gambar umum, maksimal 4MB.</span>
                                    </div>
                                    @error('history_cover_image')<span class="block text-xs text-red-500">{{ $message }}</span>@enderror

                                    <div class="rounded-xl bg-white/80 px-4 py-3 text-sm text-slate-600 ring-1 ring-blue-100">
                                        Saran:
                                        pakai foto yang jelas, tidak terlalu gelap, dan tetap terbaca saat diberi teks judul di halaman publik.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Judul Halaman</label>
                            <input type="text" name="history_title" value="{{ old('history_title', $profile->history_title) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            @error('history_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Halaman</label>
                            <textarea name="history_description" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('history_description', $profile->history_description) }}</textarea>
                            @error('history_description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Badge Hero</label>
                            <input type="text" name="history_cover_badge" value="{{ old('history_cover_badge', $profile->history_cover_badge) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            @error('history_cover_badge')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Judul Hero</label>
                            <input type="text" name="history_cover_title" value="{{ old('history_cover_title', $profile->history_cover_title) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            @error('history_cover_title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">Narasi Pembuka</label>
                            <textarea name="history_intro_text" rows="5" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('history_intro_text', $profile->history_intro_text) }}</textarea>
                            @error('history_intro_text')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        </div>
                    </div>
                </section>

                <section class="module-panel">
                    <div class="module-panel-header px-6 py-5">
                        <div class="flex items-center justify-between gap-4 flex-col sm:flex-row">
                            <div>
                                <h2 class="profile-module-section-title">Kartu Sejarah</h2>
                                <p class="profile-module-section-copy">Tampilkan dua kartu ringkas untuk bagian awal sejarah. Tambah dan edit dilakukan lewat modal agar lebih cepat dipakai.</p>
                            </div>
                            <button type="button" class="module-neutral-btn px-4 py-2 text-sm" data-open-history-card-modal data-history-card-mode="create">
                                Tambah Kartu
                            </button>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 grid gap-6">
                        @error('history_cards')
                            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ $message }}</div>
                        @enderror
                        @error('history_card_images.*')
                            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ $message }}</div>
                        @enderror
                        <div class="hidden" data-history-card-hidden-inputs></div>
                        <div class="space-y-4" id="history-cards-admin" data-max-history-cards="2" data-initial-history-cards='@json($historyCards)'>
                            <div class="grid gap-4 lg:grid-cols-2" data-history-card-list-display></div>
                            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-500 hidden" data-empty-history-card-state>
                                Belum ada kartu sejarah. Gunakan tombol `Tambah Kartu` untuk mulai mengisi ringkasan sejarah desa.
                            </div>
                        </div>
                    </div>
                </section>

                <section class="module-panel">
                    <div class="module-panel-header px-6 py-5">
                        <div class="flex items-center justify-between gap-4 flex-col sm:flex-row">
                            <div>
                                <h2 class="profile-module-section-title">Linimasa Sejarah</h2>
                                <p class="profile-module-section-copy">Item linimasa bisa ditambah sebanyak yang dibutuhkan. Tambah dan edit dilakukan lewat modal agar lebih mudah dipakai.</p>
                            </div>
                            <button type="button" class="module-neutral-btn px-4 py-2 text-sm" data-open-timeline-modal data-timeline-mode="create">
                                Tambah Linimasa
                            </button>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 grid gap-6">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Badge Linimasa</label>
                                <input type="text" name="history_timeline_badge" value="{{ old('history_timeline_badge', $profile->history_timeline_badge) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Judul Linimasa</label>
                                <input type="text" name="history_timeline_title" value="{{ old('history_timeline_title', $profile->history_timeline_title) }}"
                                    class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                            </div>
                        </div>
                        <div class="hidden" data-timeline-hidden-inputs></div>
                        <div class="space-y-4" id="history-timeline-admin" data-initial-timeline-items='@json($timelineItems)'>
                            <div class="space-y-4" data-timeline-list-display></div>
                            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-500 hidden" data-empty-timeline-state>
                                Belum ada item linimasa. Gunakan tombol `Tambah Linimasa` untuk menambahkan riwayat baru.
                            </div>
                        </div>
                    </div>
                </section>

                <section class="module-panel">
                    <div class="module-panel-header px-6 py-5">
                        <h2 class="profile-module-section-title">Catatan Samping</h2>
                    </div>

                    <div class="p-6 sm:p-8 grid gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Judul Catatan</label>
                            <input type="text" name="history_sidebar_title" value="{{ old('history_sidebar_title', $profile->history_sidebar_title) }}"
                                class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi Catatan</label>
                            <textarea name="history_sidebar_description" rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('history_sidebar_description', $profile->history_sidebar_description) }}</textarea>
                        </div>
                    </div>
                </section>
            </main>
        </form>

        <div class="app-modal-overlay hidden" data-history-card-modal-overlay>
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-2xl">
                    <div class="module-panel-header px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Kartu Sejarah</p>
                                <h2 class="mt-1 text-xl font-semibold text-gray-900" data-history-card-modal-title>Tambah Kartu</h2>
                                <p class="mt-2 text-sm text-gray-600">
                                    Isi ringkasan kartu terlebih dahulu. Foto kartu bisa diunggah langsung dari card setelah item tersimpan di daftar.
                                </p>
                            </div>
                            <button type="button" class="module-neutral-btn px-3 py-2 text-sm" data-close-history-card-modal>Tutup</button>
                        </div>
                    </div>

                    <div class="app-modal-body px-6 py-6">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Badge</label>
                                <input type="text" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-history-card-form-badge>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Ikon Cadangan</label>
                                <select class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-history-card-form-icon>
                                    <option value="home">Home</option>
                                    <option value="building">Building</option>
                                    <option value="spark">Spark</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Judul</label>
                                <input type="text" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-history-card-form-title>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                                <textarea rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-history-card-form-description></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="app-modal-footer px-6 py-4">
                        <button type="button" class="module-neutral-btn px-4 py-3 text-sm" data-close-history-card-modal>Batal</button>
                        <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-save-history-card-modal>Simpan Kartu</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-modal-overlay hidden" data-timeline-modal-overlay>
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-2xl">
                    <div class="module-panel-header px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Linimasa Modal</p>
                                <h2 class="mt-1 text-xl font-semibold text-gray-900" data-timeline-modal-title>Tambah Linimasa</h2>
                                <p class="mt-2 text-sm text-gray-600">
                                    Isi detail linimasa terlebih dahulu. Setelah item tersimpan di daftar, ikon gambarnya bisa diunggah langsung dari kartu item.
                                </p>
                            </div>
                            <button type="button" class="module-neutral-btn px-3 py-2 text-sm" data-close-timeline-modal>Tutup</button>
                        </div>
                    </div>

                    <div class="app-modal-body px-6 py-6">
                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Label</label>
                                <input type="text" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-timeline-form-label>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Ikon Cadangan</label>
                                <select class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-timeline-form-icon>
                                    <option value="home">Home</option>
                                    <option value="building">Building</option>
                                    <option value="spark">Spark</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Judul</label>
                                <input type="text" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-timeline-form-title>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                                <textarea rows="4" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-timeline-form-desc></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="app-modal-footer px-6 py-4">
                        <button type="button" class="module-neutral-btn px-4 py-3 text-sm" data-close-timeline-modal>Batal</button>
                        <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-save-timeline-modal>Simpan Linimasa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const historyCardPage = document.getElementById('history-cards-admin');
            const timelinePage = document.getElementById('history-timeline-admin');

            if (!historyCardPage || !timelinePage) {
                return;
            }

            const escapeHtml = (value) => String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

            const iconOptions = {
                home: 'Home',
                building: 'Building',
                spark: 'Spark',
            };

            const historyCardHiddenInputs = document.querySelector('[data-history-card-hidden-inputs]');
            const historyCardDisplay = document.querySelector('[data-history-card-list-display]');
            const emptyHistoryCardState = document.querySelector('[data-empty-history-card-state]');
            const historyCardModalOverlay = document.querySelector('[data-history-card-modal-overlay]');
            const historyCardModalTitle = document.querySelector('[data-history-card-modal-title]');
            const openHistoryCardButtons = document.querySelectorAll('[data-open-history-card-modal]');
            const closeHistoryCardButtons = document.querySelectorAll('[data-close-history-card-modal]');
            const saveHistoryCardButton = document.querySelector('[data-save-history-card-modal]');
            const maxHistoryCards = Number(historyCardPage.dataset.maxHistoryCards || 2);

            const historyCardModalFields = {
                badge: document.querySelector('[data-history-card-form-badge]'),
                title: document.querySelector('[data-history-card-form-title]'),
                description: document.querySelector('[data-history-card-form-description]'),
                icon: document.querySelector('[data-history-card-form-icon]'),
            };

            const timelineHiddenInputs = document.querySelector('[data-timeline-hidden-inputs]');
            const timelineDisplay = document.querySelector('[data-timeline-list-display]');
            const emptyTimelineState = document.querySelector('[data-empty-timeline-state]');
            const timelineModalOverlay = document.querySelector('[data-timeline-modal-overlay]');
            const timelineModalTitle = document.querySelector('[data-timeline-modal-title]');
            const openTimelineButtons = document.querySelectorAll('[data-open-timeline-modal]');
            const closeTimelineButtons = document.querySelectorAll('[data-close-timeline-modal]');
            const saveTimelineButton = document.querySelector('[data-save-timeline-modal]');

            const timelineModalFields = {
                label: document.querySelector('[data-timeline-form-label]'),
                title: document.querySelector('[data-timeline-form-title]'),
                desc: document.querySelector('[data-timeline-form-desc]'),
                icon: document.querySelector('[data-timeline-form-icon]'),
            };

            let historyCards = [];
            try {
                historyCards = JSON.parse(historyCardPage.dataset.initialHistoryCards || '[]');
            } catch (error) {
                historyCards = [];
            }

            let timelineItems = [];
            try {
                timelineItems = JSON.parse(timelinePage.dataset.initialTimelineItems || '[]');
            } catch (error) {
                timelineItems = [];
            }

            let historyCardMode = 'create';
            let editingHistoryCardIndex = null;
            let timelineMode = 'create';
            let editingTimelineIndex = null;

            const clearHistoryCardModal = () => {
                historyCardModalFields.badge.value = '';
                historyCardModalFields.title.value = '';
                historyCardModalFields.description.value = '';
                historyCardModalFields.icon.value = 'home';
            };

            const openHistoryCardModal = (mode = 'create', index = null) => {
                historyCardMode = mode;
                editingHistoryCardIndex = index;
                clearHistoryCardModal();

                if (mode === 'edit' && index !== null && historyCards[index]) {
                    const item = historyCards[index];
                    historyCardModalTitle.textContent = 'Edit Kartu';
                    historyCardModalFields.badge.value = item.badge || '';
                    historyCardModalFields.title.value = item.title || '';
                    historyCardModalFields.description.value = item.description || '';
                    historyCardModalFields.icon.value = item.icon || 'home';
                } else {
                    if (historyCards.length >= maxHistoryCards) {
                        window.showError('Batas kartu tercapai', `Maksimal ${maxHistoryCards} kartu sejarah dapat ditampilkan.`);
                        return;
                    }

                    historyCardModalTitle.textContent = 'Tambah Kartu';
                }

                historyCardModalOverlay.classList.remove('hidden');
                document.body.classList.add('modal-open');
            };

            const closeHistoryCardModal = () => {
                historyCardModalOverlay.classList.add('hidden');
                document.body.classList.remove('modal-open');
                editingHistoryCardIndex = null;
            };

            const clearTimelineModal = () => {
                timelineModalFields.label.value = '';
                timelineModalFields.title.value = '';
                timelineModalFields.desc.value = '';
                timelineModalFields.icon.value = 'home';
            };

            const openTimelineModal = (mode = 'create', index = null) => {
                timelineMode = mode;
                editingTimelineIndex = index;
                clearTimelineModal();

                if (mode === 'edit' && index !== null && timelineItems[index]) {
                    const item = timelineItems[index];
                    timelineModalTitle.textContent = 'Edit Linimasa';
                    timelineModalFields.label.value = item.label || '';
                    timelineModalFields.title.value = item.title || '';
                    timelineModalFields.desc.value = item.desc || '';
                    timelineModalFields.icon.value = item.icon || 'home';
                } else {
                    timelineModalTitle.textContent = 'Tambah Linimasa';
                }

                timelineModalOverlay.classList.remove('hidden');
                document.body.classList.add('modal-open');
            };

            const closeTimelineModal = () => {
                timelineModalOverlay.classList.add('hidden');
                document.body.classList.remove('modal-open');
                editingTimelineIndex = null;
            };

            const refreshHistoryCardHiddenInputs = () => {
                historyCardHiddenInputs.innerHTML = '';

                historyCards.forEach((item, index) => {
                    ['badge', 'title', 'description', 'icon', 'image_path'].forEach((field) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `history_cards[${index}][${field}]`;
                        input.value = item[field] ?? '';
                        historyCardHiddenInputs.appendChild(input);
                    });
                });
            };

            const refreshTimelineHiddenInputs = () => {
                timelineHiddenInputs.innerHTML = '';

                timelineItems.forEach((item, index) => {
                    ['label', 'title', 'desc', 'icon', 'icon_image_path'].forEach((field) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `history_timeline_items[${index}][${field}]`;
                        input.value = item[field] ?? '';
                        timelineHiddenInputs.appendChild(input);
                    });
                });
            };

            const createHistoryCardVisualMarkup = (item) => {
                if (item.image_url) {
                    return `<img src="${escapeHtml(item.image_url)}" alt="${escapeHtml(item.title || 'Foto kartu sejarah')}" class="h-28 w-full rounded-2xl object-cover">`;
                }

                if ((item.icon || 'home') === 'building') {
                    return `<span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6" /></svg></span>`;
                }

                if ((item.icon || 'home') === 'spark') {
                    return `<span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l1.8 5.4L19 10l-5.2 1.6L12 17l-1.8-5.4L5 10l5.2-1.6L12 3z" /></svg></span>`;
                }

                return `<span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 11l9-7 9 7M5 10v10h14V10M9 20v-6h6v6" /></svg></span>`;
            };

            const createTimelineIconMarkup = (item) => {
                if (item.icon_image_url) {
                    return `<img src="${escapeHtml(item.icon_image_url)}" alt="${escapeHtml(item.title || 'Ikon Linimasa')}" class="h-12 w-12 rounded-2xl object-cover shadow-lg">`;
                }

                if ((item.icon || 'home') === 'building') {
                    return `<span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-700 text-white shadow-lg shadow-green-700/20"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 21V5a2 2 0 012-2h8a2 2 0 012 2v16M9 7h2M9 11h2M9 15h2M18 21v-8h2v8" /></svg></span>`;
                }

                if ((item.icon || 'home') === 'spark') {
                    return `<span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-700 text-white shadow-lg shadow-green-700/20"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l1.8 5.4L19 10l-5.2 1.6L12 17l-1.8-5.4L5 10l5.2-1.6L12 3z" /></svg></span>`;
                }

                return `<span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-700 text-white shadow-lg shadow-green-700/20"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 11l9-7 9 7M5 10v10h14V10M9 20v-6h6v6" /></svg></span>`;
            };

            const renderHistoryCards = () => {
                historyCardDisplay.innerHTML = '';

                if (historyCards.length === 0) {
                    emptyHistoryCardState.classList.remove('hidden');
                    refreshHistoryCardHiddenInputs();
                } else {
                    emptyHistoryCardState.classList.add('hidden');

                    historyCards.forEach((item, index) => {
                        const imageStateText = item.image_path
                            ? 'Foto kartu aktif'
                            : `Menggunakan ikon ${escapeHtml(iconOptions[item.icon || 'home'] || 'Home')}`;
                        const card = document.createElement('div');
                        card.className = 'rounded-2xl border border-gray-200 bg-gray-50 p-5';
                        card.innerHTML = `
                            <div class="flex h-full flex-col gap-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">${escapeHtml(item.badge || 'Tanpa Badge')}</span>
                                        <h3 class="mt-3 text-lg font-semibold text-gray-900">${escapeHtml(item.title || '-')}</h3>
                                    </div>
                                    <div class="shrink-0">
                                        ${createHistoryCardVisualMarkup(item)}
                                    </div>
                                </div>
                                <p class="line-clamp-3 text-sm leading-6 text-gray-600">${escapeHtml(item.description || 'Tanpa deskripsi.')}</p>
                                <div class="rounded-xl bg-white px-4 py-3 ring-1 ring-gray-100">
                                    <label class="block text-sm font-semibold text-gray-700">Upload Foto / Ikon Kartu</label>
                                    <div class="mt-2 flex flex-wrap items-center gap-3">
                                        <input type="file" name="history_card_images[${index}]" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-semibold file:text-blue-700 hover:file:bg-blue-100">
                                        <span class="text-xs text-gray-500">${imageStateText}</span>
                                    </div>
                                </div>
                                <div class="flex gap-2 pt-1">
                                    <button type="button" class="module-edit-btn" data-edit-history-card="${index}">Edit</button>
                                    <button type="button" class="module-danger-btn" data-delete-history-card="${index}">Hapus</button>
                                </div>
                            </div>
                        `;
                        historyCardDisplay.appendChild(card);
                    });

                    historyCardDisplay.querySelectorAll('[data-edit-history-card]').forEach((button) => {
                        button.addEventListener('click', () => openHistoryCardModal('edit', Number(button.dataset.editHistoryCard)));
                    });

                    historyCardDisplay.querySelectorAll('[data-delete-history-card]').forEach((button) => {
                        button.addEventListener('click', () => {
                            historyCards.splice(Number(button.dataset.deleteHistoryCard), 1);
                            renderHistoryCards();
                        });
                    });
                }

                openHistoryCardButtons.forEach((button) => {
                    button.disabled = historyCards.length >= maxHistoryCards;
                    button.classList.toggle('opacity-60', historyCards.length >= maxHistoryCards);
                    button.classList.toggle('cursor-not-allowed', historyCards.length >= maxHistoryCards);
                });

                refreshHistoryCardHiddenInputs();
            };

            const renderTimelineCards = () => {
                timelineDisplay.innerHTML = '';

                if (timelineItems.length === 0) {
                    emptyTimelineState.classList.remove('hidden');
                    refreshTimelineHiddenInputs();
                    return;
                }

                emptyTimelineState.classList.add('hidden');

                timelineItems.forEach((item, index) => {
                    const card = document.createElement('div');
                    card.className = 'rounded-2xl border border-gray-200 bg-gray-50 p-5';
                    card.innerHTML = `
                        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex min-w-0 gap-4">
                                <div class="shrink-0">
                                    ${createTimelineIconMarkup(item)}
                                </div>
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">${escapeHtml(item.label || 'Tanpa Label')}</span>
                                        <span class="text-xs text-gray-500">${item.icon_image_path ? 'Ikon gambar aktif' : 'Ikon standar aktif'}</span>
                                    </div>
                                    <h3 class="mt-3 text-lg font-semibold text-gray-900">${escapeHtml(item.title || '-')}</h3>
                                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-600">${escapeHtml(item.desc || 'Tanpa deskripsi.')}</p>
                                    <div class="mt-4 rounded-xl bg-white px-4 py-3 ring-1 ring-gray-100">
                                        <label class="block text-sm font-semibold text-gray-700">Upload Ikon Item</label>
                                        <div class="mt-2 flex flex-wrap items-center gap-3">
                                            <input type="file" name="history_timeline_icons[${index}]" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:font-semibold file:text-emerald-700 hover:file:bg-emerald-100">
                                            <span class="text-xs text-gray-500">Opsional. Jika tidak diisi, sistem memakai ikon standar.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" class="module-edit-btn" data-edit-timeline="${index}">Edit</button>
                                <button type="button" class="module-danger-btn" data-delete-timeline="${index}">Hapus</button>
                            </div>
                        </div>
                    `;
                    timelineDisplay.appendChild(card);
                });

                timelineDisplay.querySelectorAll('[data-edit-timeline]').forEach((button) => {
                    button.addEventListener('click', () => openTimelineModal('edit', Number(button.dataset.editTimeline)));
                });

                timelineDisplay.querySelectorAll('[data-delete-timeline]').forEach((button) => {
                    button.addEventListener('click', () => {
                        timelineItems.splice(Number(button.dataset.deleteTimeline), 1);
                        renderTimelineCards();
                    });
                });

                refreshTimelineHiddenInputs();
            };

            const saveHistoryCardFromModal = () => {
                const payload = {
                    badge: historyCardModalFields.badge.value.trim(),
                    title: historyCardModalFields.title.value.trim(),
                    description: historyCardModalFields.description.value.trim(),
                    icon: historyCardModalFields.icon.value,
                    image_path: historyCardMode === 'edit' && editingHistoryCardIndex !== null
                        ? (historyCards[editingHistoryCardIndex]?.image_path || null)
                        : null,
                    image_url: historyCardMode === 'edit' && editingHistoryCardIndex !== null
                        ? (historyCards[editingHistoryCardIndex]?.image_url || null)
                        : null,
                };

                if (!payload.badge || !payload.title || !payload.description) {
                    window.showError('Data kartu belum lengkap', 'Badge, judul, dan deskripsi harus diisi.');
                    return;
                }

                if (historyCardMode === 'edit' && editingHistoryCardIndex !== null) {
                    historyCards[editingHistoryCardIndex] = payload;
                } else {
                    historyCards.push(payload);
                }

                renderHistoryCards();
                closeHistoryCardModal();
            };

            const saveTimelineFromModal = () => {
                const payload = {
                    label: timelineModalFields.label.value.trim(),
                    title: timelineModalFields.title.value.trim(),
                    desc: timelineModalFields.desc.value.trim(),
                    icon: timelineModalFields.icon.value,
                    icon_image_path: timelineMode === 'edit' && editingTimelineIndex !== null
                        ? (timelineItems[editingTimelineIndex]?.icon_image_path || null)
                        : null,
                    icon_image_url: timelineMode === 'edit' && editingTimelineIndex !== null
                        ? (timelineItems[editingTimelineIndex]?.icon_image_url || null)
                        : null,
                };

                if (!payload.label || !payload.title || !payload.desc) {
                    window.showError('Data linimasa belum lengkap', 'Label, judul, dan deskripsi harus diisi.');
                    return;
                }

                if (timelineMode === 'edit' && editingTimelineIndex !== null) {
                    timelineItems[editingTimelineIndex] = payload;
                } else {
                    timelineItems.push(payload);
                }

                renderTimelineCards();
                closeTimelineModal();
            };

            openHistoryCardButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    if (!button.disabled) {
                        openHistoryCardModal(button.dataset.historyCardMode || 'create');
                    }
                });
            });

            closeHistoryCardButtons.forEach((button) => {
                button.addEventListener('click', closeHistoryCardModal);
            });

            openTimelineButtons.forEach((button) => {
                button.addEventListener('click', () => openTimelineModal(button.dataset.timelineMode || 'create'));
            });

            closeTimelineButtons.forEach((button) => {
                button.addEventListener('click', closeTimelineModal);
            });

            timelineModalOverlay.addEventListener('click', function(event) {
                if (event.target === timelineModalOverlay) {
                    closeTimelineModal();
                }
            });

            historyCardModalOverlay.addEventListener('click', function(event) {
                if (event.target === historyCardModalOverlay) {
                    closeHistoryCardModal();
                }
            });

            saveHistoryCardButton.addEventListener('click', saveHistoryCardFromModal);
            saveTimelineButton.addEventListener('click', saveTimelineFromModal);

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !historyCardModalOverlay.classList.contains('hidden')) {
                    closeHistoryCardModal();
                }

                if (event.key === 'Escape' && !timelineModalOverlay.classList.contains('hidden')) {
                    closeTimelineModal();
                }
            });

            renderHistoryCards();
            renderTimelineCards();
        });
    </script>
@endsection
