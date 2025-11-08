<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-start justify-center overflow-y-auto"
            wire:click.self="closeModal">

            <div class="relative top-8 mx-auto w-full max-w-4xl p-6 border shadow-lg rounded-2xl bg-white">
                <div class="max-h-[80vh] overflow-y-auto">
                    <div class="mt-3">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $isEditing ? 'Edit Post' : 'Tambah Post' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- FORM -->
                        <form wire:submit.prevent="save" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- Tipe Konten -->
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Tipe Konten</label>
                                    <select wire:model="content_type"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm">
                                        <option value="announcement">Pengumuman</option>
                                        <option value="news">Berita</option>
                                    </select>
                                    @error('content_type')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kategori -->
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                    <select wire:model="category_id"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm">
                                        <option value="">— Pilih —</option>
                                        @foreach ($categories as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Judul -->
                                <div class="md:col-span-2 flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Judul</label>
                                    <input type="text" wire:model.defer="title"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm"
                                        placeholder="Judul…">
                                    @error('title')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="md:col-span-2 flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Slug</label>
                                    <input type="text" wire:model.defer="slug"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm"
                                        placeholder="otomatis dari judul…">
                                    @error('slug')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Ringkasan -->
                                <div class="md:col-span-2 flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Ringkasan</label>
                                    <textarea wire:model.defer="summary" rows="3"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm"></textarea>
                                    @error('summary')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Isi -->
                                <div class="md:col-span-2 flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Isi (HTML)</label>
                                    <textarea wire:model.defer="body_html" rows="8"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm"
                                        placeholder="<p>…</p>"></textarea>
                                    @error('body_html')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Announcement Fields --}}
                                @if ($content_type === 'announcement')
                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                                        <input type="text" wire:model.defer="location"
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm">
                                        @error('location')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-2">Penyelenggara</label>
                                        <input type="text" wire:model.defer="organizer"
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm">
                                        @error('organizer')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-2">Mulai</label>
                                        <input type="datetime-local" wire:model="start_at"
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm">
                                        @error('start_at')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-2">Selesai</label>
                                        <input type="datetime-local" wire:model="end_at"
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm">
                                        @error('end_at')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2 flex items-center gap-3">
                                        <input id="is_all_day" type="checkbox" wire:model="is_all_day"
                                            class="h-4 w-4 rounded border-gray-300 text-green-800 focus:ring-green-800">
                                        <label for="is_all_day" class="text-sm font-medium text-gray-700">
                                            Seharian
                                        </label>
                                    </div>
                                @endif

                                {{-- News Fields --}}
                                @if ($content_type === 'news')
                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-2">Penulis</label>
                                        <input type="text" wire:model.defer="author_name"
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm">
                                        @error('author_name')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-2">Menit Baca</label>
                                        <input type="number" min="0" wire:model.defer="read_minutes"
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm">
                                        @error('read_minutes')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2 flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-2">Sumber (URL)</label>
                                        <input type="url" wire:model.defer="source_url"
                                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm"
                                            placeholder="https://…">
                                        @error('source_url')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif

                                <!-- Cover -->
                                <div class="md:col-span-2 flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Cover</label>

                                    <!-- Dropzone -->
                                    <label for="cover"
                                        class="flex flex-col items-center justify-center w-full p-5 border-2 border-dashed rounded-xl bg-gray-50 hover:bg-gray-100 border-gray-300 cursor-pointer transition-all duration-200 shadow-sm">
                                        <svg class="w-10 h-10 text-gray-400 mb-3" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 15l5.159-5.159a2.25 2.25 0 013.182 0L16.5 15M5.25 6.75h13.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-9a1.5 1.5 0 011.5-1.5z" />
                                        </svg>
                                        <div class="text-center">
                                            <p class="text-sm text-gray-700 font-medium">Klik untuk pilih cover / drag
                                                & drop</p>
                                            <p class="text-xs text-gray-500">PNG/JPG maks. 4 MB</p>
                                        </div>
                                    </label>
                                    <input id="cover" type="file" accept="image/*" wire:model="cover"
                                        class="hidden">
                                    @error('cover')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror

                                    {{-- Preview Cover --}}
                                    @if ($cover || (!empty($cover_path) && file_exists(public_path($cover_path))))
                                        <div class="mt-3 flex justify-center">
                                            <img src="{{ $cover ? $cover->temporaryUrl() : asset($cover_path) }}"
                                                alt="Cover Preview"
                                                class="h-40 w-full max-w-2xl object-cover rounded-lg border shadow-sm bg-white ring-1 ring-gray-100">
                                        </div>
                                        @if (!$cover && !empty($cover_path))
                                            <p class="mt-2 text-xs text-gray-500 text-center">
                                                Sumber: {{ asset($cover_path) }}
                                            </p>
                                        @endif
                                    @endif

                                </div>

                                <!-- Tags -->
                                <div class="md:col-span-2 flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Tag</label>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        @foreach ($tags as $t)
                                            <label class="inline-flex items-center gap-2">
                                                <input type="checkbox" value="{{ $t->id }}"
                                                    wire:model="tag_ids"
                                                    class="rounded border-gray-300 text-green-600 focus:ring-green-700">
                                                <span class="text-sm text-gray-700">{{ $t->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Status & Publish -->
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select wire:model="status"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm">
                                        <option value="draft">Draft</option>
                                        <option value="scheduled">Scheduled</option>
                                        <option value="published">Published</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Tanggal Terbit</label>
                                    <input type="datetime-local" wire:model="published_at"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm">
                                    @error('published_at')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="md:col-span-2 flex justify-end gap-3 pt-6 border-t border-gray-200">
                                    <button type="button" wire:click="closeModal"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $isEditing ? 'Perbarui Post' : 'Simpan Post' }}
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
