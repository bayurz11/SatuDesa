<div>
    @if($showModal)
        <div class="app-modal-overlay" data-modal-overlay wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-4xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-blue-50 to-violet-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $isEditing ? 'Edit Kartu Keluarga' : 'Tambah Kartu Keluarga' }}</h3>
                                <p class="mt-1 text-sm text-slate-500">Tetapkan nomor KK, kepala keluarga, dan wilayah administratif.</p>
                            </div>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">X</button>
                        </div>
                    </div>

                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="rounded-2xl border border-indigo-100 bg-indigo-50/60 p-4">
                                <h4 class="text-sm font-semibold text-indigo-900">Identitas Kartu Keluarga</h4>
                                <p class="mt-1 text-xs text-indigo-700">Gunakan nomor KK 16 digit dan pastikan kepala keluarga sudah terdaftar sebagai penduduk.</p>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nomor KK</label>
                                    <input wire:model="no_kk" type="text" inputmode="numeric" maxlength="16" placeholder="16 digit nomor KK" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('no_kk') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kepala Keluarga</label>
                                    <select wire:model="head_citizen_id" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih kepala keluarga</option>
                                        @foreach($citizens as $citizen)
                                            <option value="{{ $citizen->id }}">{{ $citizen->full_name }} - {{ $citizen->nik }}</option>
                                        @endforeach
                                    </select>
                                    @error('head_citizen_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-4">
                                <h4 class="text-sm font-semibold text-blue-900">Wilayah Administratif</h4>
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

                            <div class="rounded-2xl border border-slate-100 bg-slate-50/70 p-4">
                                <h4 class="text-sm font-semibold text-slate-900">Alamat Domisili KK</h4>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat KK</label>
                                <textarea wire:model="address" rows="4" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                @error('address') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-300">Batal</button>
                            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                                {{ $isEditing ? 'Simpan Perubahan' : 'Simpan KK' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
