<div>
    @if($showModal)
        <div class="app-modal-overlay" data-modal-overlay wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-5xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-blue-50 to-indigo-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $isEditing ? 'Edit Penduduk' : 'Tambah Penduduk' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $isEditing ? 'Perbarui identitas dan status administrasi penduduk.' : 'Tambahkan data penduduk baru dan hubungkan ke kartu keluarga bila tersedia.' }}
                        </p>
                    </div>

                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                                    <input wire:model="nik" type="text" inputmode="numeric" maxlength="16" placeholder="16 digit NIK" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('nik') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <input wire:model="full_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('full_name') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                                    <select wire:model="gender" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @foreach($genderOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('gender') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                    <input wire:model="birth_place" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('birth_place') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input wire:model="birth_date" type="date" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('birth_date') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select wire:model="status" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @foreach($statusOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="rounded-2xl border border-sky-100 bg-sky-50/60 p-4">
                                <h4 class="text-sm font-semibold text-sky-900">Identitas Dasar Kependudukan</h4>
                                <p class="mt-1 text-xs text-sky-700">Gunakan NIK 16 digit, pilih hubungan keluarga sesuai KK, dan isi status penduduk sesuai kondisi administrasi terakhir.</p>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Agama</label>
                                    <select wire:model="religion" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih agama</option>
                                        @foreach($religionOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('religion') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                                    <select wire:model="marital_status" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih status perkawinan</option>
                                        @foreach($maritalStatusOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('marital_status') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Hubungan Dalam Keluarga</label>
                                    <select wire:model="family_relationship" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih hubungan keluarga</option>
                                        @foreach($familyRelationshipOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('family_relationship') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pendidikan</label>
                                    <select wire:model="education" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih pendidikan terakhir</option>
                                        @foreach($educationOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('education') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                    <select wire:model="occupation" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih pekerjaan</option>
                                        @foreach($occupationOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('occupation') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                                    <select wire:model="citizenship" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @foreach($citizenshipOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('citizenship') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                                    <select wire:model="household_id" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Belum dihubungkan</option>
                                        @foreach($households as $household)
                                            <option value="{{ $household->id }}">{{ $household->no_kk }} - {{ $household->address }}</option>
                                        @endforeach
                                    </select>
                                    @error('household_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="rounded-2xl border border-indigo-100 bg-indigo-50/60 p-4">
                                <h4 class="text-sm font-semibold text-indigo-900">Wilayah Administratif dan KK</h4>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dusun</label>
                                    <select wire:model.live="hamlet_id" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">{{ count($hamlets) ? 'Pilih dusun' : 'Belum ada data dusun' }}</option>
                                        @foreach($hamlets as $hamlet)
                                            <option value="{{ $hamlet->id }}">{{ $hamlet->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('hamlet_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">RW</label>
                                    <select wire:model.live="rw_id" @disabled($hamlet_id === '') class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm disabled:cursor-not-allowed disabled:bg-gray-100 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">{{ $hamlet_id === '' ? 'Pilih dusun terlebih dahulu' : (count($rws) ? 'Pilih RW' : 'Belum ada data RW') }}</option>
                                        @foreach($rws as $rw)
                                            <option value="{{ $rw->id }}">RW {{ $rw->number }}</option>
                                        @endforeach
                                    </select>
                                    @error('rw_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">RT</label>
                                    <select wire:model="rt_id" @disabled($rw_id === '') class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm disabled:cursor-not-allowed disabled:bg-gray-100 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">{{ $rw_id === '' ? 'Pilih RW terlebih dahulu' : (count($rts) ? 'Pilih RT' : 'Belum ada data RT') }}</option>
                                        @foreach($rts as $rt)
                                            <option value="{{ $rt->id }}">RT {{ $rt->number }}</option>
                                        @endforeach
                                    </select>
                                    @error('rt_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <label class="flex items-center gap-3 rounded-2xl border border-gray-200 bg-slate-50 px-4 py-4">
                                <input wire:model="is_head_of_household" type="checkbox" class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">Tetapkan sebagai kepala keluarga</div>
                                    <div class="text-xs text-gray-500">Jika aktif, warga ini akan menjadi kepala keluarga pada KK yang dipilih.</div>
                                </div>
                            </label>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea wire:model="address" rows="4" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                @error('address') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Batal
                            </button>
                            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                {{ $isEditing ? 'Simpan Perubahan' : 'Simpan Penduduk' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
