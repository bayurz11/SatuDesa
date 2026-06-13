@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <style>
        .quill-wrapper {
            overflow: hidden;
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            background: #ffffff;
            box-shadow: 0 1px 2px 0 rgba(15, 23, 42, 0.04);
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        .quill-wrapper:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .quill-wrapper .ql-toolbar.ql-snow {
            border: 0;
            border-bottom: 1px solid #e5e7eb;
            background: #f8fafc;
            font-family: inherit;
        }

        .quill-wrapper .ql-container.ql-snow {
            border: 0;
            font-size: 0.875rem;
            color: #0f172a;
            font-family: inherit;
        }

        .quill-wrapper .ql-editor {
            min-height: 16rem;
            padding: 0.9rem 1rem;
            line-height: 1.7;
            font-family: inherit;
        }

        .quill-wrapper .ql-editor.ql-blank::before {
            color: #94a3b8;
            font-style: normal;
            font-family: inherit;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        (() => {
            const formSelector = '[data-potential-form]';
            const editorConfigs = [
                {
                    editorId: 'potential-content-editor',
                    sourceId: 'potential-content-source',
                    placeholder: 'Tulis deskripsi lengkap potensi di sini...'
                },
                {
                    editorId: 'potential-facilities-editor',
                    sourceId: 'potential-facilities-source',
                    placeholder: 'Tulis fasilitas atau nilai pendukung di sini...'
                },
                {
                    editorId: 'potential-opportunities-editor',
                    sourceId: 'potential-opportunities-source',
                    placeholder: 'Tulis peluang pengembangan di sini...'
                },
            ];

            const editorInstances = new Map();
            let observerInitialized = false;
            let formListenerInitialized = false;

            function getEditorElement(editorId) {
                return document.getElementById(editorId);
            }

            function getSourceElement(sourceId) {
                return document.getElementById(sourceId);
            }

            function getContentValue(sourceId) {
                return getSourceElement(sourceId)?.value || '';
            }

            function normalizeHtml(content) {
                if (!content || content === '<p><br></p>') {
                    return '';
                }

                const parser = new DOMParser();
                const doc = parser.parseFromString(`<div>${content}</div>`, 'text/html');
                const root = doc.body.firstElementChild;

                if (!root) {
                    return '';
                }

                root.querySelectorAll('script, style, iframe, object, embed, form, input, button, textarea, select, option').forEach((node) => {
                    node.remove();
                });

                root.querySelectorAll('h1').forEach((node) => {
                    const replacement = doc.createElement('h2');
                    replacement.innerHTML = node.innerHTML;
                    node.replaceWith(replacement);
                });

                root.querySelectorAll('p, div').forEach((node) => {
                    if (node.innerHTML.trim() === '' || node.innerHTML.trim() === '<br>') {
                        node.remove();
                    }
                });

                const normalized = root.innerHTML.trim();

                return normalized === '<p><br></p>' ? '' : normalized;
            }

            function syncToLivewire(sourceId, content, shouldDispatch = false) {
                const source = getSourceElement(sourceId);
                if (!source) {
                    return;
                }

                source.value = content;

                if (shouldDispatch) {
                    source.dispatchEvent(new Event('input', { bubbles: true }));
                    source.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }

            function destroyMissingEditors() {
                editorConfigs.forEach(({ editorId }) => {
                    if (!getEditorElement(editorId)) {
                        editorInstances.delete(editorId);
                    }
                });
            }

            function syncEditorContent(editorId, sourceId) {
                const editorInstance = editorInstances.get(editorId);
                if (!editorInstance) {
                    return;
                }

                const normalizedContent = normalizeHtml(getContentValue(sourceId));
                const currentContent = normalizeHtml(editorInstance.root.innerHTML);

                if (normalizedContent === currentContent) {
                    return;
                }

                editorInstance.clipboard.dangerouslyPasteHTML(normalizedContent || '');
            }

            function setupQuillEditor({ editorId, sourceId, placeholder }) {
                const editor = getEditorElement(editorId);

                if (!editor || !window.Quill) {
                    return;
                }

                if (!editorInstances.has(editorId)) {
                    editor.innerHTML = '';

                    const editorInstance = new window.Quill(editor, {
                        theme: 'snow',
                        placeholder,
                        modules: {
                            toolbar: [
                                [{ header: [2, 3, false] }],
                                ['bold', 'italic', 'underline'],
                                [{ list: 'ordered' }, { list: 'bullet' }],
                                ['blockquote', 'link'],
                                [{ align: [] }],
                                ['clean']
                            ]
                        }
                    });

                    editorInstances.set(editorId, editorInstance);
                    syncEditorContent(editorId, sourceId);

                    editorInstance.on('text-change', (_delta, _oldDelta, source) => {
                        if (source !== 'user') {
                            return;
                        }

                        syncToLivewire(sourceId, normalizeHtml(editorInstance.root.innerHTML), false);
                    });

                    editorInstance.root.addEventListener('blur', () => {
                        syncToLivewire(sourceId, normalizeHtml(editorInstance.root.innerHTML), true);
                    });
                } else {
                    syncEditorContent(editorId, sourceId);
                }
            }

            function setupAllEditors() {
                editorConfigs.forEach(setupQuillEditor);
            }

            function attachFormListener() {
                if (formListenerInitialized) {
                    return;
                }

                document.addEventListener('submit', (event) => {
                    if (!event.target.matches(formSelector)) {
                        return;
                    }

                    editorConfigs.forEach(({ editorId, sourceId }) => {
                        const editorInstance = editorInstances.get(editorId);
                        if (!editorInstance) {
                            return;
                        }

                        syncToLivewire(sourceId, normalizeHtml(editorInstance.root.innerHTML), true);
                    });
                }, true);

                formListenerInitialized = true;
            }

            function bootstrapEditorWatcher() {
                if (observerInitialized) {
                    return;
                }

                observerInitialized = true;

                const observer = new MutationObserver(() => {
                    destroyMissingEditors();
                    setupAllEditors();
                });

                observer.observe(document.body, {
                    childList: true,
                    subtree: true,
                });
            }

            document.addEventListener('DOMContentLoaded', () => {
                bootstrapEditorWatcher();
                attachFormListener();
                setupAllEditors();
            });

            document.addEventListener('livewire:init', () => {
                bootstrapEditorWatcher();
                attachFormListener();
                setupAllEditors();
            });

            document.addEventListener('livewire:navigated', () => {
                bootstrapEditorWatcher();
                attachFormListener();
                setupAllEditors();
            });

            document.addEventListener('livewire:initialized', () => {
                bootstrapEditorWatcher();
                attachFormListener();
                setupAllEditors();
            });
        })();
    </script>
@endpush

<div>
    @if($showModal)
        <div class="app-modal-overlay" data-modal-overlay wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-5xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-blue-50 to-indigo-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $isEditing ? 'Edit Potensi Desa' : 'Tambah Potensi Desa' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $isEditing ? 'Perbarui detail potensi desa dan status publikasinya.' : 'Tambahkan data potensi desa untuk kanal informasi publik.' }}
                        </p>
                    </div>

                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col" data-potential-form>
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="rounded-2xl border border-blue-200 bg-gradient-to-r from-blue-50 to-indigo-50 p-6">
                                <div class="flex flex-col gap-5 lg:flex-row lg:items-start">
                                    <div class="w-full max-w-xs">
                                        @if($cover_image)
                                            <img src="{{ $cover_image->temporaryUrl() }}" alt="Preview cover potensi" class="h-48 w-full rounded-2xl object-cover shadow-lg">
                                        @elseif($existing_cover_image_url)
                                            <img src="{{ $existing_cover_image_url }}" alt="{{ $cover_image_alt ?: $title }}" class="h-48 w-full rounded-2xl object-cover shadow-lg">
                                        @else
                                            <div class="flex h-48 w-full items-center justify-center rounded-2xl bg-gradient-to-br from-slate-100 to-blue-100 shadow-inner">
                                                <div class="text-center">
                                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-blue-600 shadow">
                                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 21c4.97-4.97 7.5-8.328 7.5-10.5a7.5 7.5 0 1 0-15 0c0 2.172 2.53 5.53 7.5 10.5Z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 12.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="mt-3 text-sm font-medium text-slate-600">Belum ada cover</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 space-y-4">
                                        <div>
                                            <h4 class="text-base font-semibold text-gray-900">Cover Potensi</h4>
                                            <p class="mt-1 text-sm text-gray-600">Unggah gambar utama agar potensi tampil lebih menarik saat dibuka atau dibagikan.</p>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-3">
                                            <label for="potential-cover" class="cursor-pointer inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                                                Pilih Cover
                                            </label>
                                            <input type="file" id="potential-cover" wire:model="cover_image" accept="image/*" class="hidden">
                                            @if($cover_image)
                                                <span class="text-sm font-medium text-green-600">{{ $cover_image->getClientOriginalName() }}</span>
                                            @elseif($existing_cover_image_url)
                                                <span class="text-sm font-medium text-slate-500">Cover saat ini aktif</span>
                                            @endif
                                        </div>
                                        @error('cover_image') <span class="block text-xs text-red-500">{{ $message }}</span> @enderror

                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Alt Cover</label>
                                                <input wire:model.live="cover_image_alt" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Deskripsi singkat gambar cover">
                                                @error('cover_image_alt') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Caption Cover</label>
                                                <input wire:model.live="cover_image_caption" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Area utama potensi desa">
                                                @error('cover_image_caption') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <label class="inline-flex items-center rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">
                                            <input wire:model="is_featured" type="checkbox" class="rounded border-amber-300 text-amber-500 focus:ring-amber-500 focus:ring-offset-0">
                                            <span class="ml-3 text-sm font-medium text-amber-800">Tandai sebagai potensi unggulan</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                                <div class="mb-4">
                                    <h4 class="text-base font-semibold text-gray-900">Informasi Utama</h4>
                                    <p class="mt-1 text-sm text-gray-600">Isi data dasar potensi terlebih dahulu agar sistem bisa membentuk struktur konten dengan rapi.</p>
                                </div>

                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Desa</label>
                                        <select wire:model="village_id" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Pilih desa</option>
                                            @foreach($villages as $village)
                                                <option value="{{ $village->id }}">{{ $village->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('village_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                        <select wire:model="category_id" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Pilih kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                                        <input wire:model.live="title" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan judul potensi desa">
                                        <p class="mt-1 text-xs text-slate-500">Gunakan judul yang jelas dan mudah dipahami pengunjung.</p>
                                        @error('title') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Slug</label>
                                        <input wire:model.live="slug" type="text" readonly class="mt-2 block w-full rounded-xl border border-gray-300 bg-slate-50 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <p class="mt-1 text-xs text-slate-500">Slug dibuat otomatis mengikuti judul potensi.</p>
                                        @error('slug') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jenis Potensi</label>
                                        <input wire:model.live="potential_type" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Wisata, UMKM, Budaya">
                                        @error('potential_type') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status Pengembangan</label>
                                        <input wire:model.live="development_status" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Berkembang, Siap dikembangkan">
                                        @error('development_status') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700">Ringkasan</label>
                                    <textarea wire:model.live="excerpt" rows="4" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tulis ringkasan singkat potensi desa"></textarea>
                                    @error('excerpt') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi Lengkap</label>
                                    <input id="potential-content-source" type="hidden" wire:model.defer="content">
                                    <div wire:ignore class="mt-2 quill-wrapper">
                                        <div id="potential-content-editor"></div>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500">Editor mendukung heading, tebal, miring, daftar, kutipan, tautan, dan perataan paragraf.</p>
                                    @error('content') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                                <div class="mb-4">
                                    <h4 class="text-base font-semibold text-gray-900">Lokasi dan Detail Lapangan</h4>
                                    <p class="mt-1 text-sm text-gray-600">Tambahkan informasi lokasi agar potensi lebih mudah dipahami dan dipetakan.</p>
                                </div>

                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Lokasi</label>
                                        <input wire:model.live="location_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Pesisir Timur Mentuda">
                                        @error('location_name') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Urutan Tampil</label>
                                        <input wire:model.live="sort_order" type="number" min="0" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('sort_order') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700">Alamat / Keterangan Lokasi</label>
                                    <textarea wire:model.live="address" rows="3" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    @error('address') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Latitude</label>
                                        <input wire:model.live="latitude" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('latitude') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Longitude</label>
                                        <input wire:model.live="longitude" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('longitude') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                                <div class="mb-4">
                                    <h4 class="text-base font-semibold text-gray-900">Kontak dan Pengembangan</h4>
                                    <p class="mt-1 text-sm text-gray-600">Isi manfaat, fasilitas, peluang, dan kontak yang bisa dihubungi.</p>
                                </div>

                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kontak Person</label>
                                        <input wire:model.live="contact_person" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('contact_person') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nomor Kontak</label>
                                        <input wire:model.live="contact_phone" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('contact_phone') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700">Fasilitas / Nilai Pendukung</label>
                                    <input id="potential-facilities-source" type="hidden" wire:model.defer="facilities">
                                    <div wire:ignore class="mt-2 quill-wrapper">
                                        <div id="potential-facilities-editor"></div>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500">Gunakan daftar poin atau paragraf untuk menjelaskan fasilitas dan nilai pendukung.</p>
                                    @error('facilities') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700">Peluang Pengembangan</label>
                                    <input id="potential-opportunities-source" type="hidden" wire:model.defer="opportunities">
                                    <div wire:ignore class="mt-2 quill-wrapper">
                                        <div id="potential-opportunities-editor"></div>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500">Jelaskan peluang investasi, kolaborasi, atau pengembangan jangka menengah.</p>
                                    @error('opportunities') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                                <div class="mb-4">
                                    <h4 class="text-base font-semibold text-gray-900">Publikasi</h4>
                                    <p class="mt-1 text-sm text-gray-600">Tentukan status potensi dan kapan data akan diterbitkan.</p>
                                </div>

                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <select wire:model="status" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="draft">Draft</option>
                                            <option value="review">Review</option>
                                            <option value="published">Published</option>
                                        </select>
                                        @error('status') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tanggal Publish</label>
                                        <input wire:model="published_at" type="datetime-local" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <p class="mt-1 text-xs text-slate-500">Kosongkan untuk memakai waktu saat ini ketika statusnya dipublish.</p>
                                        @error('published_at') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Batal
                            </button>
                            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                {{ $isEditing ? 'Update Potensi' : 'Simpan Potensi' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
