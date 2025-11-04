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
                                {{ $isEditing ? 'Edit Visi & Misi Desa' : 'Tambah Visi & Misi Desa' }}
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

                                <!-- BARIS KATEGORI & GAMBAR -->
                                <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <!-- KATEGORI -->
                                    <div class="flex flex-col">
                                        <label for="kategori"
                                            class="text-sm font-medium text-gray-700 mb-2">Kategori</label>

                                        <div class="relative">
                                            <select id="kategori" wire:model="kategori"
                                                class="custom-select w-full rounded-xl border border-gray-300 bg-white px-4 py-3 pr-10 text-sm text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-all duration-200 shadow-sm cursor-pointer">
                                                <option value="" disabled
                                                    {{ $kategori === '' ? 'selected' : '' }}>Pilih Kategori</option>
                                                <option value="visi">Visi — Tujuan utama pembangunan desa</option>
                                                <option value="misi">Misi — Langkah & strategi pencapaian visi
                                                </option>
                                            </select>

                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 transition-transform duration-200">
                                                <svg class="w-4 h-4 text-gray-400 group-focus-within:text-blue-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>

                                        @error('kategori')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <style>
                                        /* --- Custom Select Styling (neutralize browser style) --- */
                                        .custom-select {
                                            -webkit-appearance: none;
                                            -moz-appearance: none;
                                            appearance: none;
                                            background-color: #fff;
                                            background-image: none;
                                            font-family: inherit;
                                            font-size: 0.95rem;
                                            line-height: 1.4;
                                        }

                                        /* Saat dropdown dibuka */
                                        .custom-select:focus {
                                            outline: none;
                                            box-shadow: 0 0 0 2px #a7f3d0, 0 0 0 4px #bbf7d0;
                                        }

                                        /* Hilangkan highlight biru dan ubah gaya opsi */
                                        select.custom-select option {
                                            background-color: #ffffff;
                                            color: #374151;
                                            padding: 0.75rem 1rem;
                                            font-size: 0.95rem;
                                        }

                                        select.custom-select option:hover,
                                        select.custom-select option:focus {
                                            background-color: #ecfdf5;
                                            color: #065f46;
                                        }

                                        select.custom-select option[disabled] {
                                            color: #9ca3af;
                                            background-color: #f9fafb;
                                        }

                                        /* Scrollbar opsional (modern & halus) */
                                        select.custom-select::-webkit-scrollbar {
                                            width: 6px;
                                        }

                                        select.custom-select::-webkit-scrollbar-thumb {
                                            background-color: #d1fae5;
                                            border-radius: 6px;
                                        }

                                        select.custom-select::-webkit-scrollbar-thumb:hover {
                                            background-color: #10b981;
                                        }
                                    </style>



                                    <!-- GAMBAR -->
                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-2">Gambar / Ikon
                                            (Opsional)</label>
                                        <label for="gambar"
                                            class="flex flex-col items-center justify-center w-full p-5 border-2 border-dashed rounded-xl bg-gray-50 hover:bg-gray-100 border-gray-300 cursor-pointer transition-all duration-200 shadow-sm">
                                            <svg class="w-10 h-10 text-gray-400 mb-3" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 15l5.159-5.159a2.25 2.25 0 013.182 0L16.5 15M5.25 6.75h13.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-9a1.5 1.5 0 011.5-1.5z" />
                                            </svg>
                                            <div class="text-center">
                                                <p class="text-sm text-gray-700 font-medium">Klik untuk pilih gambar /
                                                    drag & drop</p>
                                                <p class="text-xs text-gray-500">PNG/JPG maks. 2 MB</p>
                                            </div>
                                        </label>
                                        <input wire:model="gambar" id="gambar" type="file" accept="image/*"
                                            class="hidden">
                                        @error('gambar')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror

                                        <!-- Preview -->
                                        @if ($gambar || $gambarLama)
                                            <div class="mt-3 flex justify-center">
                                                <img src="{{ $gambar ? $gambar->temporaryUrl() : Storage::url($gambarLama) }}"
                                                    class="w-28 h-28 object-contain rounded-lg border shadow-sm bg-white ring-1 ring-gray-100"
                                                    alt="Preview">
                                            </div>
                                        @endif
                                    </div>
                                </div>


                                <!-- ISI (Trix) -->
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Isi</label>

                                    <input id="isi-input-{{ $editorId }}" type="hidden" wire:model.defer="isi">
                                    <trix-editor wire:ignore input="isi-input-{{ $editorId }}"
                                        class="trix-content rounded-xl border border-gray-300 bg-white p-3"
                                        data-disable-file-uploads="true"></trix-editor>

                                    @error('isi')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- STATUS -->
                                <div class="col-span-2 flex items-center gap-3">
                                    <input id="is_active" type="checkbox" wire:model="is_active"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="is_active" class="text-sm font-medium text-gray-700">
                                        Tampilkan (Active)
                                    </label>
                                </div>

                                <!-- ACTION BUTTONS -->
                                <div class="col-span-2 flex justify-end gap-3 pt-6 border-t border-gray-200">
                                    <button type="button" wire:click="closeModal"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $isEditing ? 'Perbarui Data' : 'Simpan Data' }}
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

        document.addEventListener('trix-change', (e) => {
            const inputId = e.target.getAttribute('input');
            const hidden = document.getElementById(inputId);
            if (hidden) hidden.dispatchEvent(new Event('input', {
                bubbles: true
            }));
        });

        document.addEventListener('trix-file-accept', e => e.preventDefault());
        document.addEventListener('trix-attachment-add', e => e.preventDefault());
    </script>
@endpush
