<div>
    @if($showModal)
        <div class="app-modal-overlay" data-modal-overlay wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-3xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-blue-50 to-indigo-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $isEditing ? 'Edit Kategori Berita' : 'Tambah Kategori Berita' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $isEditing ? 'Perbarui nama, slug, dan deskripsi kategori berita.' : 'Tambahkan kategori baru untuk mengelompokkan artikel berita.' }}
                        </p>
                    </div>

                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Desa</label>
                                    <select wire:model="village_id" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Semua desa</option>
                                        @foreach($villages as $village)
                                            <option value="{{ $village->id }}">{{ $village->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('village_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                                    <input wire:model.live="name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('name') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Slug</label>
                                <input wire:model.live="slug" type="text" readonly class="mt-2 block w-full rounded-xl border border-gray-300 bg-slate-50 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="mt-1 text-xs text-slate-500">Slug dibuat otomatis mengikuti nama kategori.</p>
                                @error('slug') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea wire:model="description" rows="4" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                @error('description') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Batal
                            </button>
                            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                {{ $isEditing ? 'Update Kategori' : 'Simpan Kategori' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
