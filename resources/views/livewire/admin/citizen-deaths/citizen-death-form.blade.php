<div>
    @if($showModal)
        <div class="app-modal-overlay" wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-4xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-rose-50 to-red-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $isEditing ? 'Edit Kematian' : 'Tambah Kematian' }}</h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">X</button>
                        </div>
                    </div>
                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="rounded-2xl border border-rose-100 bg-rose-50/60 p-4">
                                <h4 class="text-sm font-semibold text-rose-900">Identitas Peristiwa Kematian</h4>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penduduk</label>
                                <select wire:model="citizen_id" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                    <option value="">Pilih penduduk</option>
                                    @foreach($citizens as $citizen)
                                        <option value="{{ $citizen->id }}">{{ $citizen->full_name }} - {{ $citizen->nik }} ({{ $citizen->status }})</option>
                                    @endforeach
                                </select>
                                    @error('citizen_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Kematian</label>
                                    <input wire:model="death_date" type="date" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jam Kematian</label>
                                    <input wire:model="death_time" type="time" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tempat Kematian</label>
                                    <input wire:model="death_place" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Sebab Kematian</label>
                                    <select wire:model="cause_of_death" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                        <option value="">Pilih sebab kematian</option>
                                        @foreach($deathCauseOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="rounded-2xl border border-red-100 bg-red-50/50 p-4">
                                <h4 class="text-sm font-semibold text-red-900">Dokumen dan Pelapor</h4>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Yang Menerangkan</label>
                                    <input wire:model="certifier" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No Surat Kematian</label>
                                    <input wire:model="death_certificate_number" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pelapor</label>
                                    <input wire:model="reporter_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Hubungan Pelapor</label>
                                    <select wire:model="reporter_relation" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
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
                                    <input wire:model="witness_1_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Saksi 2</label>
                                    <input wire:model="witness_2_name" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tempat Pemakaman</label>
                                    <input wire:model="burial_place" type="text" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <textarea wire:model="notes" rows="3" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-300">Batal</button>
                            <button type="submit" class="rounded-xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white hover:bg-rose-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
