<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-start justify-center overflow-y-auto"
            wire:click.self="closeModal">
            <div class="relative top-8 mx-auto w-full max-w-xl p-6 border shadow-lg rounded-2xl bg-white">
                <div class="max-h-[80vh] overflow-y-auto">
                    <div class="mt-3">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $isEditing ? 'Edit Tag' : 'Tambah Tag' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form wire:submit.prevent="save" class="space-y-6">
                            <div class="grid grid-cols-1 gap-6">
                                <div class="flex flex-col">
                                    <label for="name" class="text-sm font-medium text-gray-700 mb-2">Nama</label>
                                    <input id="name" type="text" wire:model.defer="name"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm"
                                        placeholder="Nama tag">
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col">
                                    <label for="slug" class="text-sm font-medium text-gray-700 mb-2">Slug
                                        (opsional)</label>
                                    <input id="slug" type="text" wire:model.defer="slug"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm"
                                        placeholder="otomatis dibuat dari nama jika dikosongkan">
                                    @error('slug')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center gap-3">
                                    <input id="is_active" type="checkbox" wire:model="is_active"
                                        class="h-4 w-4 rounded border-gray-300 text-green-800 focus:ring-green-800">
                                    <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
                                </div>

                                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
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
                                        {{ $isEditing ? 'Perbarui' : 'Simpan' }}
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
