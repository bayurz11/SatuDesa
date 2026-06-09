<div>
    @if($showModal)
        <div class="app-modal-overlay" wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-6xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-emerald-50 to-teal-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $isEditing ? 'Edit Pindah Datang' : 'Tambah Pindah Datang' }}</h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">X</button>
                        </div>
                    </div>
                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-4">
                                <h4 class="text-sm font-semibold text-emerald-900">Identitas Penduduk Datang</h4>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                                    <input wire:model="nik" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    @error('nik') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <input wire:model="full_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                                    <select wire:model="gender" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        @foreach($genderOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                    <input wire:model="birth_place" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input wire:model="birth_date" type="date" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                                    <select wire:model="citizenship" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        @foreach($citizenshipOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Agama</label>
                                    <select wire:model="religion" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        <option value="">Pilih agama</option>
                                        @foreach($religionOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                                    <select wire:model="marital_status" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        <option value="">Pilih status perkawinan</option>
                                        @foreach($maritalStatusOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pendidikan</label>
                                    <select wire:model="education" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        <option value="">Pilih pendidikan</option>
                                        @foreach($educationOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                    <select wire:model="occupation" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        <option value="">Pilih pekerjaan</option>
                                        @foreach($occupationOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-teal-100 bg-teal-50/50 p-4">
                                <h4 class="text-sm font-semibold text-teal-900">Data Perpindahan</h4>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Datang</label>
                                    <input wire:model="arrival_date" type="date" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No Surat Pindah</label>
                                    <input wire:model="moving_certificate_number" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Klasifikasi Datang</label>
                                    <select wire:model="arrival_classification" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        <option value="">Pilih klasifikasi datang</option>
                                        @foreach($arrivalClassificationOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Alasan Datang</label>
                                    <select wire:model="arrival_reason" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        <option value="">Pilih alasan</option>
                                        @foreach($arrivalReasonOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Asal Wilayah</label>
                                    <input wire:model="origin_region" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No KK Asal</label>
                                    <input wire:model="origin_no_kk" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jumlah Anggota Ikut Datang</label>
                                    <input wire:model="moved_member_count" type="number" min="1" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kartu Keluarga Tujuan</label>
                                    <select wire:model="household_id" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        <option value="">Belum dihubungkan</option>
                                        @foreach($households as $household)
                                            <option value="{{ $household->id }}">{{ $household->no_kk }} - {{ $household->address }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-cyan-100 bg-cyan-50/50 p-4">
                                <h4 class="text-sm font-semibold text-cyan-900">Pelapor dan Domisili</h4>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Asal</label>
                                <textarea wire:model="origin_address" rows="3" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Tinggal Sekarang</label>
                                <textarea wire:model="address" rows="3" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Pelapor</label>
                                    <input wire:model="reporter_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Hubungan Pelapor</label>
                                    <select wire:model="reporter_relation" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        <option value="">Pilih hubungan pelapor</option>
                                        @foreach($reporterRelationOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                <textarea wire:model="notes" rows="3" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                            </div>
                        </div>
                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-300">Batal</button>
                            <button type="submit" class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
