@php
    $publicGalleryUrl = route('public.galleries.index');
    $galleryStats = [
        'total' => $galleries->count(),
        'published' => $galleries->where('status', 'published')->count(),
        'draft' => $galleries->where('status', 'draft')->count(),
        'featured' => $galleries->where('is_featured', true)->count(),
    ];
    $serializedGalleries = $galleries->map(fn ($gallery) => [
        'id' => $gallery->id,
        'title' => $gallery->title,
        'slug' => $gallery->slug,
        'category' => $gallery->category,
        'excerpt' => $gallery->excerpt,
        'description' => $gallery->description,
        'location_name' => $gallery->location_name,
        'photo_count' => $gallery->photo_count,
        'sort_order' => $gallery->sort_order,
        'status' => $gallery->status,
        'is_featured' => $gallery->is_featured,
        'gallery_date' => optional($gallery->gallery_date)->format('Y-m-d'),
        'cover_image_url' => $gallery->cover_image_url,
    ])->values();
@endphp

@extends('layouts.app')

@section('content')
    <div class="space-y-8 animate-fadeInUp" id="gallery-admin-page"
        data-galleries='@json($serializedGalleries)'
        data-open-modal-on-load="{{ $errors->any() ? '1' : '0' }}">
        <div class="admin-module-hero">
            <div class="admin-module-hero-band px-6 py-6">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="admin-module-icon">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2 1.586-1.586a2 2 0 012.828 0L20 14m-8-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="admin-module-kicker">Informasi Publik</p>
                            <h1 class="admin-module-title">Manajemen Galeri Desa</h1>
                            <p class="admin-module-description">Kelola album galeri desa, status publikasi, kategori, dan foto sampul dari satu halaman admin.</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <div class="admin-module-toolbar-card">
                            <div class="text-sm font-medium text-gray-500">Desa Aktif</div>
                            <div class="text-lg font-semibold text-gray-900 mt-1">{{ $village->name }}</div>
                        </div>
                        <a href="{{ $publicGalleryUrl }}" target="_blank" rel="noopener noreferrer"
                            class="module-primary-btn px-6 py-3 text-sm inline-flex items-center justify-center">
                            Buka Halaman Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="admin-module-hero">
            <div class="admin-module-hero-band px-6 py-6">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <h2 class="admin-module-title">Galeri Desa</h2>
                        <p class="admin-module-description">Halaman ini menampilkan hasil album yang tersimpan. Tambah dan edit dilakukan lewat modal agar tetap ringkas seperti modul admin lainnya.</p>
                    </div>
                    @permission('galleries.create')
                        <button type="button" class="module-primary-btn px-5 py-3 text-sm" data-open-gallery-modal data-mode="create">
                            Tambah Album
                        </button>
                    @endpermission
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2 2xl:grid-cols-4">
                    <div class="admin-module-summary-card min-h-[132px]">
                        <p class="admin-module-summary-label">Total Album</p>
                        <p class="admin-module-summary-value">{{ $galleryStats['total'] }}</p>
                        <p class="admin-module-summary-note text-blue-600">Data galeri tersimpan</p>
                    </div>
                    <div class="admin-module-summary-card min-h-[132px]">
                        <p class="admin-module-summary-label">Sudah Publish</p>
                        <p class="admin-module-summary-value">{{ $galleryStats['published'] }}</p>
                        <p class="admin-module-summary-note text-emerald-600">Siap tampil di publik</p>
                    </div>
                    <div class="admin-module-summary-card min-h-[132px]">
                        <p class="admin-module-summary-label">Draft</p>
                        <p class="admin-module-summary-value">{{ $galleryStats['draft'] }}</p>
                        <p class="admin-module-summary-note text-amber-600">Belum dipublikasikan</p>
                    </div>
                    <div class="admin-module-summary-card min-h-[132px]">
                        <p class="admin-module-summary-label">Album Unggulan</p>
                        <p class="admin-module-summary-value">{{ $galleryStats['featured'] }}</p>
                        <p class="admin-module-summary-note text-fuchsia-600">Ditandai featured</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 bg-white px-6 py-6 space-y-8">
                <section class="admin-module-section">
                    <div class="admin-module-section-header px-6 py-5">
                        <div>
                            <h3 class="admin-module-section-title">Daftar Album Galeri</h3>
                            <p class="admin-module-section-description">Setiap baris menampilkan ringkasan album, kategori, status publikasi, dan tindakan cepat.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="module-table-head">
                                <tr class="text-left">
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Album</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Kategori</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Foto</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Tanggal</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse ($galleries as $gallery)
                                    <tr class="module-table-row align-top text-sm text-gray-700">
                                        <td class="px-6 py-5">
                                            <div class="flex items-start gap-4">
                                                <img src="{{ $gallery->cover_image_url ?: asset('img/bg.jpg') }}" alt="{{ $gallery->title }}" class="h-20 w-28 rounded-2xl object-cover border border-gray-200">
                                                <div class="min-w-0">
                                                    <p class="font-semibold text-gray-900">{{ $gallery->title }}</p>
                                                    <p class="mt-1 text-xs uppercase tracking-[0.18em] text-blue-600">{{ $gallery->slug }}</p>
                                                    <p class="mt-2 max-w-md text-sm leading-6 text-gray-500">{{ $gallery->excerpt ?: 'Belum ada ringkasan album.' }}</p>
                                                    @if ($gallery->is_featured)
                                                        <span class="mt-3 inline-flex rounded-full bg-fuchsia-50 px-3 py-1 text-xs font-semibold text-fuchsia-700 ring-1 ring-fuchsia-100">Unggulan</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                                {{ $gallery->category ?: 'Tanpa kategori' }}
                                            </span>
                                            @if ($gallery->location_name)
                                                <p class="mt-2 text-sm text-gray-500">{{ $gallery->location_name }}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 font-semibold text-gray-900">{{ $gallery->photo_count }}</td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $gallery->status === 'published' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100' : 'bg-amber-50 text-amber-700 ring-1 ring-amber-100' }}">
                                                {{ $gallery->status === 'published' ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-gray-500">{{ optional($gallery->gallery_date)->translatedFormat('d M Y') ?: '-' }}</td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-wrap justify-end gap-2">
                                                @permission('galleries.edit')
                                                    <button type="button" class="module-edit-btn" data-open-gallery-modal data-mode="edit" data-gallery-id="{{ $gallery->id }}">Edit</button>
                                                @endpermission
                                                @permission('galleries.publish')
                                                    @if ($gallery->status === 'published')
                                                        <form method="POST" action="{{ route('galleries.draft', $gallery) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="module-neutral-btn px-4 py-2 text-xs">Jadikan Draft</button>
                                                        </form>
                                                    @else
                                                        <form method="POST" action="{{ route('galleries.publish', $gallery) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="module-neutral-btn px-4 py-2 text-xs">Publish</button>
                                                        </form>
                                                    @endif
                                                @endpermission
                                                @permission('galleries.delete')
                                                    <form method="POST" action="{{ route('galleries.destroy', $gallery) }}" onsubmit="return confirm('Hapus album galeri ini?');">
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
                                        <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">Belum ada album galeri. Tambahkan album pertama dari tombol di atas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="admin-module-section">
                    <div class="admin-module-section-header px-6 py-5">
                        <div>
                            <h3 class="admin-module-section-title">Preview Ringkas</h3>
                            <p class="admin-module-section-description">Ringkasan visual album yang saat ini tersimpan di galeri desa.</p>
                        </div>
                    </div>
                    <div class="grid gap-5 p-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($galleries->take(6) as $gallery)
                            <article class="module-soft-card overflow-hidden rounded-[24px] bg-white">
                                <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
                                    <img src="{{ $gallery->cover_image_url ?: asset('img/bg.jpg') }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover">
                                    <span class="absolute left-4 top-4 inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-blue-700 backdrop-blur ring-1 ring-white/40">
                                        {{ $gallery->category ?: 'Galeri Desa' }}
                                    </span>
                                </div>
                                <div class="p-5">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-700">{{ $gallery->photo_count }} Foto</p>
                                    <h3 class="mt-3 line-clamp-2 text-lg font-bold text-gray-900">{{ $gallery->title }}</h3>
                                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">{{ $gallery->excerpt ?: 'Belum ada ringkasan album.' }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        </section>
    </div>

    @if(auth()->user()->hasAnyPermission(['galleries.create', 'galleries.edit']))
        <div class="app-modal-overlay hidden" data-gallery-modal-overlay data-modal-overlay>
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-4xl">
                    <form method="POST" action="{{ old('gallery_id') ? url('admin/galeri-desa/' . old('gallery_id')) : route('galleries.store') }}" enctype="multipart/form-data" data-gallery-form>
                        @csrf
                        <input type="hidden" name="gallery_id" value="{{ old('gallery_id') }}" data-gallery-id-field>
                        <input type="hidden" name="form_mode" value="{{ old('form_mode', 'create') }}" data-gallery-mode-field>

                        <div class="border-b border-gray-200 px-6 py-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-700">Galeri Desa</p>
                                    <h2 class="mt-1 text-xl font-bold text-gray-900" data-gallery-modal-title>{{ old('gallery_id') ? 'Edit Album Galeri' : 'Tambah Album Galeri' }}</h2>
                                    <p class="mt-2 text-sm text-gray-600">Isi data album, unggah foto sampul, lalu atur status publikasinya.</p>
                                </div>
                                <button type="button" class="module-neutral-btn px-4 py-2 text-sm" data-close-gallery-modal>Tutup</button>
                            </div>
                        </div>

                        <div class="app-modal-body px-6 py-6">
                            <div class="grid gap-6 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Judul Album</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-gallery-title-input>
                                    @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Slug</label>
                                    <input type="text" name="slug" value="{{ old('slug') }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700" data-gallery-slug-input>
                                    @error('slug')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Kategori</label>
                                    <input type="text" name="category" list="gallery-category-options" value="{{ old('category') }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    <datalist id="gallery-category-options">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}"></option>
                                        @endforeach
                                    </datalist>
                                    @error('category')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Ringkasan</label>
                                    <textarea name="excerpt" rows="3" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('excerpt') }}</textarea>
                                    @error('excerpt')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Deskripsi Album</label>
                                    <textarea name="description" rows="5" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">{{ old('description') }}</textarea>
                                    @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Lokasi Dokumentasi</label>
                                    <input type="text" name="location_name" value="{{ old('location_name') }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    @error('location_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Tanggal Album</label>
                                    <input type="date" name="gallery_date" value="{{ old('gallery_date') }}" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    @error('gallery_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Jumlah Foto</label>
                                    <input type="number" name="photo_count" value="{{ old('photo_count', 1) }}" min="1" max="500" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    @error('photo_count')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Urutan Tampil</label>
                                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    @error('sort_order')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Status</label>
                                    <select name="status" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                        <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option>
                                        <option value="published" @selected(old('status') === 'published')>Published</option>
                                    </select>
                                    @error('status')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="flex items-center rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 mt-7">
                                    <input type="checkbox" id="gallery-featured" name="is_featured" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" @checked(old('is_featured'))>
                                    <label for="gallery-featured" class="ml-3 text-sm font-medium text-gray-700">Tandai sebagai album unggulan</label>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700">Foto Sampul</label>
                                    <input type="file" name="cover_image" accept="image/*" class="module-field mt-2 w-full px-4 py-3 text-sm text-gray-700">
                                    @error('cover_image')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    <p class="mt-2 text-xs text-gray-500">Format gambar umum, maksimal 4MB. Jika tidak diisi, foto lama dipertahankan saat edit.</p>
                                </div>
                            </div>
                        </div>

                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" class="module-neutral-btn px-5 py-3 text-sm" data-close-gallery-modal>Batal</button>
                            <button type="submit" class="module-primary-btn px-5 py-3 text-sm">Simpan Album</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.getElementById('gallery-admin-page');
            const modalOverlay = document.querySelector('[data-gallery-modal-overlay]');

            if (!page || !modalOverlay) {
                return;
            }

            const form = modalOverlay.querySelector('[data-gallery-form]');
            const idField = modalOverlay.querySelector('[data-gallery-id-field]');
            const modeField = modalOverlay.querySelector('[data-gallery-mode-field]');
            const titleLabel = modalOverlay.querySelector('[data-gallery-modal-title]');
            const titleInput = modalOverlay.querySelector('[data-gallery-title-input]');
            const slugInput = modalOverlay.querySelector('[data-gallery-slug-input]');
            const galleries = JSON.parse(page.dataset.galleries || '[]');
            const fields = {
                title: form.querySelector('[name="title"]'),
                slug: form.querySelector('[name="slug"]'),
                category: form.querySelector('[name="category"]'),
                excerpt: form.querySelector('[name="excerpt"]'),
                description: form.querySelector('[name="description"]'),
                location_name: form.querySelector('[name="location_name"]'),
                photo_count: form.querySelector('[name="photo_count"]'),
                sort_order: form.querySelector('[name="sort_order"]'),
                status: form.querySelector('[name="status"]'),
                gallery_date: form.querySelector('[name="gallery_date"]'),
                is_featured: form.querySelector('[name="is_featured"]'),
            };
            const baseStoreAction = @json(route('galleries.store'));
            const updateActionPattern = @json(url('admin/galeri-desa/__ID__'));

            const openModal = () => modalOverlay.classList.remove('hidden');
            const closeModal = () => modalOverlay.classList.add('hidden');

            const fillForm = (gallery = null) => {
                if (!gallery) {
                    form.action = baseStoreAction;
                    idField.value = '';
                    modeField.value = 'create';
                    titleLabel.textContent = 'Tambah Album Galeri';
                    fields.title.value = '';
                    fields.slug.value = '';
                    fields.category.value = '';
                    fields.excerpt.value = '';
                    fields.description.value = '';
                    fields.location_name.value = '';
                    fields.photo_count.value = 1;
                    fields.sort_order.value = 0;
                    fields.status.value = 'draft';
                    fields.gallery_date.value = '';
                    fields.is_featured.checked = false;
                    return;
                }

                form.action = updateActionPattern.replace('__ID__', gallery.id);
                idField.value = gallery.id;
                modeField.value = 'edit';
                titleLabel.textContent = 'Edit Album Galeri';
                fields.title.value = gallery.title ?? '';
                fields.slug.value = gallery.slug ?? '';
                fields.category.value = gallery.category ?? '';
                fields.excerpt.value = gallery.excerpt ?? '';
                fields.description.value = gallery.description ?? '';
                fields.location_name.value = gallery.location_name ?? '';
                fields.photo_count.value = gallery.photo_count ?? 1;
                fields.sort_order.value = gallery.sort_order ?? 0;
                fields.status.value = gallery.status ?? 'draft';
                fields.gallery_date.value = gallery.gallery_date ?? '';
                fields.is_featured.checked = Boolean(gallery.is_featured);
            };

            document.querySelectorAll('[data-open-gallery-modal]').forEach((button) => {
                button.addEventListener('click', () => {
                    const mode = button.dataset.mode || 'create';

                    if (mode === 'edit') {
                        const galleryId = button.dataset.galleryId;
                        const gallery = galleries.find((item) => String(item.id) === String(galleryId));
                        fillForm(gallery || null);
                    } else {
                        fillForm(null);
                    }

                    openModal();
                });
            });

            document.querySelectorAll('[data-close-gallery-modal]').forEach((button) => {
                button.addEventListener('click', closeModal);
            });

            modalOverlay.addEventListener('click', (event) => {
                if (event.target === modalOverlay) {
                    closeModal();
                }
            });

            titleInput?.addEventListener('input', () => {
                if (slugInput.dataset.manuallyEdited === '1') {
                    return;
                }

                slugInput.value = titleInput.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            });

            slugInput?.addEventListener('input', () => {
                slugInput.dataset.manuallyEdited = '1';
            });

            if (page.dataset.openModalOnLoad === '1') {
                openModal();
            }
        });
    </script>
@endpush
