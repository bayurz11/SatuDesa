<div>
    @if($showModal)
        <div class="app-modal-overlay" data-modal-overlay wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-3xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-blue-50 to-violet-50 px-6 py-5"><div class="flex items-center justify-between"><div><h3 class="text-xl font-semibold text-gray-900">{{ $isEditing ? 'Edit RW' : 'Tambah RW' }}</h3><p class="mt-1 text-sm text-slate-500">Pilih dusun lalu tentukan nomor RW yang berlaku di wilayah tersebut.</p></div><button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">X</button></div></div>
                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col"><div class="app-modal-body space-y-6 px-6 py-6"><div class="grid grid-cols-1 gap-6 md:grid-cols-2"><div><label class="block text-sm font-medium text-gray-700">Dusun</label><select wire:model="hamlet_id" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="">Pilih dusun</option>@foreach($hamlets as $hamlet)<option value="{{ $hamlet->id }}">{{ $hamlet->name }}</option>@endforeach</select>@error('hamlet_id') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror</div><div><label class="block text-sm font-medium text-gray-700">Nomor RW</label><input wire:model="number" type="text" placeholder="Contoh: 001" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">@error('number') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror</div></div></div><div class="app-modal-footer px-6 py-4"><button type="button" wire:click="closeModal" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-300">Batal</button><button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">{{ $isEditing ? 'Simpan Perubahan' : 'Simpan RW' }}</button></div></form>
                </div>
            </div>
        </div>
    @endif
</div>
