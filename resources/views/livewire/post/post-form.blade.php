<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-gray-600/50 z-50 flex items-start justify-center overflow-y-auto"
            wire:click.self="closeModal">
            <div class="relative top-8 mx-auto w-full max-w-4xl p-6 border shadow-lg rounded-2xl bg-white">
                <div class="max-h-[80vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $isEditing ? 'Edit Post' : 'Tambah Post' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-700 mb-2">Tipe Konten</label>
                                <select wire:model="content_type" class="w-full rounded-xl border-gray-300">
                                    <option value="announcement">Pengumuman</option>
                                    <option value="news">Berita</option>
                                </select>
                                @error('content_type')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                <select wire:model="category_id" class="w-full rounded-xl border-gray-300">
                                    <option value="">— Pilih —</option>
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-700 mb-2">Judul</label>
                                <input type="text" wire:model.defer="title" class="w-full rounded-xl border-gray-300"
                                    placeholder="Judul…">
                                @error('title')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-700 mb-2">Slug</label>
                                <input type="text" wire:model.defer="slug" class="w-full rounded-xl border-gray-300"
                                    placeholder="otomatis dari judul…">
                                @error('slug')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-700 mb-2">Ringkasan</label>
                                <textarea wire:model.defer="summary" rows="3" class="w-full rounded-xl border-gray-300"></textarea>
                                @error('summary')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-700 mb-2">Isi (HTML)</label>
                                <textarea wire:model.defer="body_html" rows="8" class="w-full rounded-xl border-gray-300" placeholder="<p>…</p>"></textarea>
                                @error('body_html')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Announcement fields --}}
                            @if ($content_type === 'announcement')
                                <div>
                                    <label class="text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                                    <input type="text" wire:model.defer="location"
                                        class="w-full rounded-xl border-gray-300">
                                    @error('location')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700 mb-2">Penyelenggara</label>
                                    <input type="text" wire:model.defer="organizer"
                                        class="w-full rounded-xl border-gray-300">
                                    @error('organizer')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700 mb-2">Mulai</label>
                                    <input type="datetime-local" wire:model="start_at"
                                        class="w-full rounded-xl border-gray-300">
                                    @error('start_at')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700 mb-2">Selesai</label>
                                    <input type="datetime-local" wire:model="end_at"
                                        class="w-full rounded-xl border-gray-300">
                                    @error('end_at')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="inline-flex items-center gap-2">
                                        <input type="checkbox" wire:model="is_all_day"
                                            class="rounded border-gray-300 text-green-600">
                                        <span class="text-sm text-gray-700">Seharian</span>
                                    </label>
                                </div>
                            @endif

                            {{-- News fields --}}
                            @if ($content_type === 'news')
                                <div>
                                    <label class="text-sm font-medium text-gray-700 mb-2">Penulis</label>
                                    <input type="text" wire:model.defer="author_name"
                                        class="w-full rounded-xl border-gray-300">
                                    @error('author_name')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700 mb-2">Menit Baca</label>
                                    <input type="number" min="0" wire:model.defer="read_minutes"
                                        class="w-full rounded-xl border-gray-300">
                                    @error('read_minutes')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Sumber (URL)</label>
                                    <input type="url" wire:model.defer="source_url"
                                        class="w-full rounded-xl border-gray-300" placeholder="https://…">
                                    @error('source_url')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            {{-- Cover --}}
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-700 mb-2">Cover</label>
                                <input type="file" wire:model="cover" accept="image/*"
                                    class="w-full rounded-xl border-gray-300">
                                @error('cover')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror

                                @if ($cover_path || $cover)
                                    <div class="mt-3">
                                        <img src="{{ $cover ? $cover->temporaryUrl() : Storage::url($cover_path) }}"
                                            class="h-32 rounded-lg ring-1 ring-black/10 object-cover"
                                            alt="Cover Preview">
                                    </div>
                                @endif
                            </div>

                            {{-- Tags --}}
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-700 mb-2">Tag</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach ($tags as $t)
                                        <label class="inline-flex items-center gap-2">
                                            <input type="checkbox" value="{{ $t->id }}" wire:model="tag_ids"
                                                class="rounded border-gray-300 text-green-600">
                                            <span class="text-sm text-gray-700">{{ $t->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Publish --}}
                            <div>
                                <label class="text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select wire:model="status" class="w-full rounded-xl border-gray-300">
                                    <option value="draft">Draft</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                                @error('status')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700 mb-2">Tanggal Terbit</label>
                                <input type="datetime-local" wire:model="published_at"
                                    class="w-full rounded-xl border-gray-300">
                                @error('published_at')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                                {{ $isEditing ? 'Perbarui' : 'Simpan' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif
</div>
