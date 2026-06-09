<div>
    @if($showModal)
        <div class="app-modal-overlay" wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-5xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-blue-50 to-cyan-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $isEditing ? 'Edit Kelahiran' : 'Tambah Kelahiran' }}</h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">X</button>
                        </div>
                    </div>

                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="rounded-2xl border border-sky-100 bg-sky-50/60 p-4">
                                <h4 class="text-sm font-semibold text-sky-900">Identitas Anak</h4>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK Anak</label>
                                    <input wire:model="nik" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('nik') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap Anak</label>
                                    <input wire:model="full_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('full_name') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                                    <select wire:model="gender" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @foreach($genderOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                    <input wire:model="birth_place" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input wire:model="birth_date" type="date" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jam Lahir</label>
                                    <input wire:model="birth_time" type="time" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Anak Ke</label>
                                    <input wire:model="birth_order" type="number" min="1" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Berat Lahir</label>
                                    <input wire:model="birth_weight" type="text" placeholder="Contoh: 3200 gram" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Panjang Lahir</label>
                                    <input wire:model="birth_length" type="text" placeholder="Contoh: 49 cm" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Kelahiran</label>
                                    <select wire:model="birth_type" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih jenis kelahiran</option>
                                        @foreach($birthTypeOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Penolong Kelahiran</label>
                                    <select wire:model="birth_attendant" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih penolong kelahiran</option>
                                        @foreach($birthAttendantOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="rounded-2xl border border-blue-100 bg-blue-50/50 p-4">
                                <h4 class="text-sm font-semibold text-blue-900">Data Orang Tua</h4>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK Ayah</label>
                                    <input wire:model="father_nik" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                                    <input wire:model="father_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK Ibu</label>
                                    <input wire:model="mother_nik" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                                    <input wire:model="mother_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="rounded-2xl border border-cyan-100 bg-cyan-50/50 p-4">
                                <h4 class="text-sm font-semibold text-cyan-900">Dokumen dan Pelapor</h4>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No Dokumen Kelahiran</label>
                                    <input wire:model="birth_certificate_number" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pelapor</label>
                                    <input wire:model="reporter_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Hubungan Pelapor</label>
                                    <select wire:model="reporter_relation" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih hubungan pelapor</option>
                                        @foreach($reporterRelationOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Saksi 1</label>
                                    <input wire:model="witness_1_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Saksi 2</label>
                                    <input wire:model="witness_2_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                                <select wire:model="household_id" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Belum dihubungkan</option>
                                    @foreach($households as $household)
                                        <option value="{{ $household->id }}">{{ $household->no_kk }} - {{ $household->address }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                <textarea wire:model="notes" rows="3" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>
                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-300">Batal</button>
                            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
