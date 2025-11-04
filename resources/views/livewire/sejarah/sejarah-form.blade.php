<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-start justify-center overflow-y-auto"
            wire:click.self="closeModal">

            <div class="relative top-8 mx-auto w-full max-w-4xl p-6 border shadow-lg rounded-md bg-white">
                <div class="max-h-[80vh] overflow-y-auto">
                    <div class="mt-3">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $isEditing ? 'Edit Sejarah Desa' : 'Create Sejarah Desa' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- GANTI: gunakan $editorId, bukan $wrapId --}}
                        <form id="sejarah-form-{{ $editorId }}" wire:submit.prevent="save" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- LOGO -->
                                {{-- <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                                    <label for="gambar"
                                        class="flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-lg bg-gray-50 hover:bg-gray-100 border-gray-300 cursor-pointer transition">
                                        <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5A1.5 1.5 0 0 0 21 18V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12A1.5 1.5 0 0 0 3.75 19.5Z" />
                                        </svg>
                                        <div class="text-center">
                                            <p class="text-sm text-gray-700 font-medium">Klik untuk pilih gambar / drag
                                                & drop</p>
                                            <p class="text-xs text-gray-500">PNG/JPG, maks. 2 MB</p>
                                        </div>
                                    </label>
                                    <input wire:model="gambar" id="gambar" type="file" accept="image/*"
                                        class="hidden">
                                    @error('gambar')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror

                                    <!-- Preview -->
                                    <div class="mt-4 flex justify-center">
                                        @if ($gambar)
                                            <img src="{{ $gambar->temporaryUrl() }}"
                                                class="w-40 h-40 object-contain rounded-lg border shadow-sm bg-gray-50"
                                                alt="Preview">
                                        @elseif ($gambarLama)
                                            <img src="{{ Storage::url($gambarLama) }}"
                                                class="w-40 h-40 object-contain rounded-lg border shadow-sm bg-gray-50"
                                                alt="Gambar lama">
                                        @endif
                                    </div>
                                </div> --}}

                                <!-- ISI (Trix) -->
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Isi</label>

                                    <input id="isi-input-{{ $editorId }}" type="hidden" wire:model.defer="isi">

                                    {{-- PENTING: wire:key dengan $editorId agar Trix re-init setiap openForm --}}
                                    <trix-editor wire:ignore wire:key="trix-{{ $editorId }}"
                                        input="isi-input-{{ $editorId }}"
                                        class="trix-content rounded-xl border border-gray-300 bg-white p-2"
                                        data-disable-file-uploads="true">
                                    </trix-editor>

                                    @error('isi')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- TANGGAL -->
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                                    <div
                                        class="rounded-lg border border-gray-300 px-3 py-2 bg-white focus-within:ring-2 focus-within:ring-blue-500">
                                        <livewire:components.date-picker wire:model="tanggal" />
                                    </div>
                                    @error('tanggal')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- ACTIVE -->
                                <div class="col-span-2 flex items-center gap-3">
                                    <input id="is_active" type="checkbox" wire:model="is_active"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
                                </div>

                                <!-- ACTIONS -->
                                <div class="col-span-2 flex justify-end gap-3 pt-6 border-t border-gray-200">
                                    <button type="button" wire:click="closeModal"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $isEditing ? 'Update Sejarah' : 'Create Sejarah' }}
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

@push('scripts')
    <script>
        // Muat konten awal dari hidden input saat trix-init
        document.addEventListener('trix-initialize', (e) => {
            const inputId = e.target.getAttribute('input');
            const hidden = document.getElementById(inputId);
            if (hidden) {
                try {
                    e.target.editor.loadHTML(hidden.value || '');
                } catch {}
                const form = e.target.closest('form');
                if (form) {
                    form.addEventListener('submit', () => {
                        hidden.dispatchEvent(new Event('input', {
                            bubbles: true
                        }));
                    });
                }
            }
        });

        // Sync perubahan editor ke hidden input
        document.addEventListener('trix-change', (e) => {
            const inputId = e.target.getAttribute('input');
            const hidden = document.getElementById(inputId);
            if (hidden) {
                hidden.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            }
        });

        // Blokir upload file (opsional)
        document.addEventListener('trix-file-accept', e => e.preventDefault());
        document.addEventListener('trix-attachment-add', e => e.preventDefault());
    </script>
@endpush
