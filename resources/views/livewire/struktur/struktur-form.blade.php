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
                                {{ $isEditing ? 'Edit Personel Struktur' : 'Tambah Personel Struktur' }}
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

                                <!-- NAMA -->
                                <div class="flex flex-col">
                                    <label for="nama" class="text-sm font-medium text-gray-700 mb-2">Nama</label>
                                    <input id="nama" type="text" wire:model.defer="nama"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm"
                                        placeholder="Nama personel">
                                    @error('nama')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- JABATAN -->
                                <div class="flex flex-col">
                                    <label for="jabatan" class="text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                                    <div class="relative">
                                        <select id="jabatan" wire:model="jabatan"
                                            class="custom-select w-full rounded-xl border border-gray-300 bg-white px-4 py-3 pr-10 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm cursor-pointer">
                                            <option value="" disabled {{ $jabatan === '' ? 'selected' : '' }}>
                                                Pilih
                                                jabatan</option>
                                            <optgroup label="Pimpinan">
                                                <option value="Kepala Desa">Kepala Desa</option>
                                            </optgroup>

                                            <optgroup label="Sekretariat">
                                                <option value="Sekretaris Desa">Sekretaris Desa</option>
                                                <option value="Kaur TU & Umum">Kaur TU & Umum</option>
                                                <option value="Kaur Keuangan">Kaur Keuangan</option>
                                                <option value="Kaur Perencanaan">Kaur Perencanaan</option>
                                            </optgroup>

                                            <optgroup label="Seksi">
                                                <option value="Kasi Pemerintahan">Kasi Pemerintahan</option>
                                                <option value="Kasi Kesejahteraan">Kasi Kesejahteraan</option>
                                                <option value="Kasi Pelayanan">Kasi Pelayanan</option>
                                            </optgroup>

                                            <optgroup label="Kewilayahan">
                                                <option value="Kepala Dusun Mentuda">Kepala Dusun Mentuda</option>
                                                <option value="Kepala Dusun Pulun">Kepala Dusun Pulun</option>
                                                <option value="Kepala Dusun Tembok">Kepala Dusun Tembok</option>
                                                <option value="Kepala Dusun Jelutung Mentengah">Kepala Dusun Jelutung
                                                    Mentengah</option>
                                            </optgroup>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('jabatan')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- LEVEL -->
                                <div class="flex flex-col">
                                    <label for="level" class="text-sm font-medium text-gray-700 mb-2">Level</label>
                                    <div class="relative">
                                        <select id="level" wire:model="level"
                                            class="custom-select w-full rounded-xl border border-gray-300 bg-white px-4 py-3 pr-10 text-sm text-gray-700 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 shadow-sm cursor-pointer">
                                            <option value="" disabled {{ $level === '' ? 'selected' : '' }}>Pilih
                                                Level</option>
                                            <option value="pimpinan">Pimpinan</option>
                                            <option value="struktural">Struktural</option>
                                            <option value="kewilayahan">Kewilayahan (RT/RW)</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('level')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <style>
                                    .custom-select {
                                        -webkit-appearance: none;
                                        -moz-appearance: none;
                                        appearance: none;
                                        background-color: #fff;
                                        background-image: none;
                                        font-family: inherit;
                                        font-size: .95rem;
                                        line-height: 1.4
                                    }

                                    .custom-select:focus {
                                        outline: none;
                                        box-shadow: 0 0 0 2px #bbf7d0, 0 0 0 4px #dcfce7
                                    }

                                    select.custom-select option {
                                        background: #fff;
                                        color: #374151;
                                        padding: .75rem 1rem;
                                        font-size: .95rem
                                    }

                                    select.custom-select option:hover,
                                    select.custom-select option:focus {
                                        background: #ecfdf5;
                                        color: #065f46
                                    }

                                    select.custom-select option[disabled] {
                                        color: #9ca3af;
                                        background: #f9fafb
                                    }

                                    select.custom-select::-webkit-scrollbar {
                                        width: 6px
                                    }

                                    select.custom-select::-webkit-scrollbar-thumb {
                                        background: #d1fae5;
                                        border-radius: 6px
                                    }

                                    select.custom-select::-webkit-scrollbar-thumb:hover {
                                        background: #10b981
                                    }
                                </style>

                                <!-- FOTO -->
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-2">Foto </label>
                                    <label for="foto"
                                        class="flex flex-col items-center justify-center w-full p-5 border-2 border-dashed rounded-xl bg-gray-50 hover:bg-gray-100 border-gray-300 cursor-pointer transition-all duration-200 shadow-sm">
                                        <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 15l5.159-5.159a2.25 2.25 0 013.182 0L16.5 15M5.25 6.75h13.5a1.5 1.5 0 011.5 1.5v9a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-9a1.5 1.5 0 011.5-1.5z" />
                                        </svg>
                                        <div class="text-center">
                                            <p class="text-sm text-gray-700 font-medium">Klik untuk pilih foto / drag &
                                                drop</p>
                                            <p class="text-xs text-gray-500">PNG/JPG maks. 2 MB</p>
                                        </div>
                                    </label>
                                    <input wire:model="foto" id="foto" type="file" accept="image/*"
                                        class="hidden">
                                    @error('foto')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror>

                                    {{-- Preview Foto --}}
                                    @if ($foto || $fotoLama)
                                        <div class="mt-3 flex justify-center">
                                            <img src="{{ $foto ? $foto->temporaryUrl() : asset('public/' . ltrim($fotoLama, '/')) }}"
                                                alt="Preview Foto"
                                                class="w-28 h-28 object-cover rounded-lg border shadow-sm bg-white ring-1 ring-gray-100">
                                        </div>
                                    @endif

                                </div>

                                <!-- STATUS -->
                                <div class="col-span-2 flex items-center gap-3">
                                    <input id="is_active" type="checkbox" wire:model="is_active"
                                        class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <label for="is_active" class="text-sm font-medium text-gray-700">
                                        Active
                                    </label>
                                </div>

                                <!-- ACTION BUTTONS -->
                                <div class="col-span-2 flex justify-end gap-3 pt-6 border-t border-gray-200">
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
