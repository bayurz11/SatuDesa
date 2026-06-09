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

        .tag-chip-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
            min-height: 3.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            background: #ffffff;
            box-shadow: 0 1px 2px 0 rgba(15, 23, 42, 0.04);
        }

        .tag-chip-wrap:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .tag-chip-input {
            flex: 1 1 180px;
            min-width: 180px;
            border: 0;
            outline: 0;
            background: transparent;
            color: #0f172a;
            font-size: 0.875rem;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        .tag-chip-input::placeholder {
            color: #94a3b8;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        (() => {
            const editorId = 'post-content-editor';
            const sourceId = 'post-content-source';
            const formSelector = '[data-post-form]';
            let editorInstance = null;
            let observerInitialized = false;
            let formListenerInitialized = false;

            function getEditorElement() {
                return document.getElementById(editorId);
            }

            function getSourceElement() {
                return document.getElementById(sourceId);
            }

            function getContentValue() {
                return getSourceElement()?.value || '';
            }

            function normalizeHtml(content) {
                if (!content || content === '<p><br></p>') {
                    return '';
                }

                return content;
            }

            function syncToLivewire(content, shouldDispatch = false) {
                const source = getSourceElement();
                if (!source) {
                    return;
                }

                source.value = content;

                if (shouldDispatch) {
                    source.dispatchEvent(new Event('input', { bubbles: true }));
                    source.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }

            function destroyEditor() {
                editorInstance = null;
            }

            function syncEditorContent(content) {
                if (!editorInstance) {
                    return;
                }

                const normalizedContent = normalizeHtml(content);
                const currentContent = normalizeHtml(editorInstance.root.innerHTML);

                if (normalizedContent === currentContent) {
                    return;
                }

                editorInstance.clipboard.dangerouslyPasteHTML(normalizedContent || '');
            }

            function setupQuill() {
                const editor = getEditorElement();

                if (!editor || !window.Quill) {
                    if (!editor) {
                        destroyEditor();
                    }
                    return;
                }

                if (!editorInstance) {
                    editor.innerHTML = '';

                    editorInstance = new window.Quill(editor, {
                        theme: 'snow',
                        placeholder: 'Tulis isi {{ strtolower($contentLabel) }} di sini...',
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

                    syncEditorContent(getContentValue());

                    editorInstance.on('text-change', (_delta, _oldDelta, source) => {
                        if (source !== 'user') {
                            return;
                        }

                        syncToLivewire(normalizeHtml(editorInstance.root.innerHTML), false);
                    });

                    editorInstance.root.addEventListener('blur', () => {
                        syncToLivewire(normalizeHtml(editorInstance.root.innerHTML), true);
                    });
                }
            }

            function attachFormListener() {
                if (formListenerInitialized) {
                    return;
                }

                document.addEventListener('submit', (event) => {
                    if (!event.target.matches(formSelector) || !editorInstance) {
                        return;
                    }

                    syncToLivewire(normalizeHtml(editorInstance.root.innerHTML), true);
                }, true);

                formListenerInitialized = true;
            }

            function bootstrapEditorWatcher() {
                if (observerInitialized) {
                    return;
                }

                observerInitialized = true;

                const observer = new MutationObserver(() => {
                    if (!getEditorElement()) {
                        destroyEditor();
                        return;
                    }

                    if (!editorInstance) {
                        setupQuill();
                    }
                });

                observer.observe(document.body, {
                    childList: true,
                    subtree: true,
                });
            }

            document.addEventListener('DOMContentLoaded', () => {
                bootstrapEditorWatcher();
                attachFormListener();
                setupQuill();
            });

            document.addEventListener('livewire:init', () => {
                bootstrapEditorWatcher();
                attachFormListener();
                setupQuill();
            });

            document.addEventListener('livewire:navigated', () => {
                bootstrapEditorWatcher();
                attachFormListener();
                setupQuill();
            });

            document.addEventListener('livewire:initialized', () => {
                bootstrapEditorWatcher();
                attachFormListener();
                setupQuill();
            });
        })();
    </script>
@endpush

<div>
    @php
        $contentLabelLower = $this->contentLabelLower();
    @endphp

    @if($showModal)
        <div class="app-modal-overlay" data-modal-overlay wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-4xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-blue-50 to-indigo-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $isEditing ? 'Edit ' . $contentLabel : 'Tambah ' . $contentLabel }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $isEditing ? 'Perbarui detail ' . $contentLabelLower . ' dan status publikasinya.' : 'Tambahkan ' . $contentLabelLower . ' baru untuk kanal informasi publik.' }}
                        </p>
                    </div>

                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col" data-post-form>
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="rounded-2xl border border-blue-200 bg-gradient-to-r from-blue-50 to-indigo-50 p-6">
                                <div class="flex flex-col gap-5 lg:flex-row lg:items-start">
                                    <div class="w-full max-w-xs">
                                        @if($cover_image)
                                            <img src="{{ $cover_image->temporaryUrl() }}" alt="Preview cover {{ $contentLabelLower }}" class="h-48 w-full rounded-2xl object-cover shadow-lg">
                                        @elseif($existing_cover_image_url)
                                            <img src="{{ $existing_cover_image_url }}" alt="{{ $cover_image_alt ?: $title }}" class="h-48 w-full rounded-2xl object-cover shadow-lg">
                                        @else
                                            <div class="flex h-48 w-full items-center justify-center rounded-2xl bg-gradient-to-br from-slate-100 to-blue-100 shadow-inner">
                                                <div class="text-center">
                                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-blue-600 shadow">
                                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V7a2 2 0 012-2h4l2-2h2l2 2h4a2 2 0 012 2v12a2 2 0 01-2 2z"></path>
                                                            <circle cx="12" cy="13" r="4"></circle>
                                                        </svg>
                                                    </div>
                                                    <p class="mt-3 text-sm font-medium text-slate-600">Belum ada cover</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 space-y-4">
                                        <div>
                                            <h4 class="text-base font-semibold text-gray-900">Cover {{ $contentLabel }}</h4>
                                            <p class="mt-1 text-sm text-gray-600">Unggah gambar utama agar {{ $contentLabelLower }} tampil lebih menarik saat dibuka atau dibagikan.</p>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-3">
                                            <label for="cover-image" class="cursor-pointer inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 hover:bg-gray-50">
                                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                                Pilih Cover
                                            </label>
                                            <input type="file" id="cover-image" wire:model="cover_image" accept="image/*" class="hidden">
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
                                                <input wire:model.live="cover_image_caption" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Dokumentasi kegiatan desa">
                                                @error('cover_image_caption') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <label class="inline-flex items-center rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">
                                            <input wire:model="is_featured" type="checkbox" class="rounded border-amber-300 text-amber-500 focus:ring-amber-500 focus:ring-offset-0">
                                            <span class="ml-3 text-sm font-medium text-amber-800">Tandai sebagai {{ $contentLabelLower }} unggulan</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                                <div class="mb-4">
                                    <h4 class="text-base font-semibold text-gray-900">Informasi Utama</h4>
                                    <p class="mt-1 text-sm text-gray-600">Isi data dasar {{ $contentLabelLower }} terlebih dahulu agar sistem bisa membentuk struktur konten dengan rapi.</p>
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
                                        <input wire:model.live="title" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan judul {{ $contentLabelLower }}">
                                        <p class="mt-1 text-xs text-slate-500">Gunakan judul yang jelas dan mudah dipahami warga.</p>
                                        @error('title') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Slug</label>
                                        <input wire:model.live="slug" type="text" readonly class="mt-2 block w-full rounded-xl border border-gray-300 bg-slate-50 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <p class="mt-1 text-xs text-slate-500">Slug dibuat otomatis mengikuti judul {{ $contentLabelLower }}.</p>
                                        @error('slug') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700">Ringkasan</label>
                                    <textarea wire:model.live="excerpt" rows="4" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tulis ringkasan singkat isi {{ $contentLabelLower }}"></textarea>
                                    <div class="mt-1 flex items-center justify-between text-xs text-slate-500">
                                        <span>Ringkasan ini juga dipakai sebagai deskripsi singkat {{ $contentLabelLower }}.</span>
                                        <span>{{ strlen($excerpt ?? '') }}/500</span>
                                    </div>
                                    @error('excerpt') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>

                                @if ($type === \App\Domains\Post\Models\Post::TYPE_ANNOUNCEMENT)
                                    <div class="mt-6 rounded-2xl border border-emerald-100 bg-emerald-50/60 p-5">
                                        <div class="mb-4">
                                            <h5 class="text-sm font-semibold text-emerald-900">Detail Pelaksanaan</h5>
                                            <p class="mt-1 text-xs text-emerald-800/80">Hari akan mengikuti tanggal pelaksanaan yang dipilih.</p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Hari</label>
                                                <input type="text" value="{{ $this->eventDayLabel() }}" readonly class="mt-2 block w-full rounded-xl border border-emerald-200 bg-white px-4 py-3 text-gray-700 shadow-sm">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Tanggal Pelaksanaan</label>
                                                <input wire:model="event_at" type="datetime-local" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                @error('event_at') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Lokasi Pelaksanaan</label>
                                                <input wire:model.live="event_location" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Balai Desa Mentuda">
                                                @error('event_location') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                                <div class="mb-4">
                                    <h4 class="text-base font-semibold text-gray-900">Isi {{ $contentLabel }}</h4>
                                    <p class="mt-1 text-sm text-gray-600">Tulis isi lengkap {{ $contentLabelLower }} dan lengkapi tag agar konten lebih mudah dicari.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Isi Artikel</label>
                                    <input id="post-content-source" type="hidden" wire:model.defer="content">
                                    <div wire:ignore class="mt-2 quill-wrapper">
                                        <div id="post-content-editor"></div>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500">Editor mendukung heading, tebal, miring, daftar, kutipan, tautan, dan perataan paragraf agar penulisan {{ $contentLabelLower }} lebih mudah.</p>
                                    @error('content') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700">Tag {{ $contentLabel }}</label>
                                    <div class="mt-2 tag-chip-wrap">
                                    @php
                                        $tagBadgeClasses = [
                                            'bg-gray-400/10 text-gray-500 ring-1 ring-inset ring-gray-400/20',
                                            'bg-red-400/10 text-red-400 ring-1 ring-inset ring-red-400/20',
                                            'bg-yellow-400/10 text-yellow-500 ring-1 ring-inset ring-yellow-400/20',
                                            'bg-green-400/10 text-green-500 ring-1 ring-inset ring-green-500/20',
                                            'bg-blue-400/10 text-blue-500 ring-1 ring-inset ring-blue-400/30',
                                            'bg-indigo-400/10 text-indigo-500 ring-1 ring-inset ring-indigo-400/30',
                                            'bg-purple-400/10 text-purple-500 ring-1 ring-inset ring-purple-400/30',
                                            'bg-pink-400/10 text-pink-500 ring-1 ring-inset ring-pink-400/20',
                                        ];
                                    @endphp

                                        @foreach($tags as $index => $tag)
                                            <span class="inline-flex items-center gap-2 rounded-md px-2 py-1 text-xs font-medium {{ $tagBadgeClasses[$index % count($tagBadgeClasses)] }}">
                                                <span>{{ $tag }}</span>
                                                <button type="button" wire:click="removeTag({{ $index }})" class="opacity-70 transition hover:opacity-100">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </span>
                                        @endforeach

                                    <input wire:model.defer="newTag" wire:keydown.enter.prevent="addTag" type="text" class="tag-chip-input" placeholder="Ketik tag lalu tekan Enter">
                                        <button type="button" wire:click="addTag" class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition hover:bg-blue-100">
                                            Tambah
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500">Tag bisa ditambahkan lebih dari satu. Contoh: pelayanan, warga, agenda.</p>
                                    @error('tags') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    @error('tags.*') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    @error('newTag') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                                <div class="mb-4">
                                    <h4 class="text-base font-semibold text-gray-900">Publikasi</h4>
                                    <p class="mt-1 text-sm text-gray-600">Tentukan status {{ $contentLabelLower }} dan kapan konten ini akan diterbitkan.</p>
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

                            <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6">
                                <div class="mb-4">
                                    <h4 class="text-base font-semibold text-gray-900">Metadata SEO</h4>
                                    <p class="mt-1 text-sm text-gray-600">Metadata SEO dibuat otomatis dari judul dan ringkasan. Anda tetap bisa mengubahnya bila diperlukan.</p>
                                </div>

                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <div class="flex items-center justify-between gap-3">
                                            <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                                            <button type="button" wire:click="resetMetaTitle" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                                Gunakan Otomatis
                                            </button>
                                        </div>
                                        <input wire:model.live="meta_title" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Otomatis mengikuti judul {{ $contentLabelLower }}">
                                        <div class="mt-1 flex items-center justify-between text-xs text-slate-500">
                                            <span>{{ $metaTitleLocked ? 'Mode otomatis aktif.' : 'Mode manual aktif.' }}</span>
                                            <span>{{ strlen($meta_title ?? '') }}/255</span>
                                        </div>
                                        @error('meta_title') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <div class="flex items-center justify-between gap-3">
                                            <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                                            <button type="button" wire:click="resetMetaDescription" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                                Gunakan Otomatis
                                            </button>
                                        </div>
                                        <textarea wire:model.live="meta_description" rows="3" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Otomatis mengikuti ringkasan {{ $contentLabelLower }}"></textarea>
                                        <div class="mt-1 flex items-center justify-between text-xs text-slate-500">
                                            <span>{{ $metaDescriptionLocked ? 'Mode otomatis aktif.' : 'Mode manual aktif.' }}</span>
                                            <span>{{ strlen($meta_description ?? '') }}/320</span>
                                        </div>
                                        @error('meta_description') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Batal
                            </button>
                            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                {{ $isEditing ? 'Update ' . $contentLabel : 'Simpan ' . $contentLabel }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
