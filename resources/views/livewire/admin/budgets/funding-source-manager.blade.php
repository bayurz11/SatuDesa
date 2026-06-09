<div class="module-panel">
    <div class="module-panel-header px-6 py-5">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Sumber Dana</h3>
                <p class="mt-1 text-sm text-gray-600">Kelola referensi sumber pendapatan dan pembiayaan APBDes.</p>
            </div>
            <div class="flex items-center gap-3">
                <input wire:model.live="search" type="text" placeholder="Cari kode atau nama..."
                    class="module-search-input px-4 py-3 text-sm">
                @permission('budgets.create')
                    <button wire:click="openModal" class="module-primary-btn px-5 py-3 text-sm">Tambah Sumber Dana</button>
                @endpermission
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="module-table-head">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Deskripsi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($records as $record)
                    <tr class="module-table-row">
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $record->code }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $record->name }}</td>
                        <td class="px-6 py-4"><span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $record->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $record->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $record->description ?: '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                @permission('budgets.edit')
                                    <button wire:click="openModal({{ $record->id }})" class="module-edit-btn">Edit</button>
                                @endpermission
                                @permission('budgets.delete')
                                    <button wire:click="confirmDelete({{ $record->id }})" class="module-danger-btn">Hapus</button>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">Belum ada sumber dana.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">{{ $records->links() }}</div>
    @if ($showModal)
        <div class="app-modal-overlay" data-modal-overlay wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-2xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-cyan-50 to-sky-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $isEditing ? 'Edit Sumber Dana' : 'Tambah Sumber Dana' }}</h3>
                            </div>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">X</button>
                        </div>
                    </div>
                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div><label class="block text-sm font-medium text-gray-700">Kode</label><input wire:model="code" type="text" class="module-field mt-2 block w-full px-4 py-3"></div>
                                <div><label class="block text-sm font-medium text-gray-700">Nama</label><input wire:model="name" type="text" class="module-field mt-2 block w-full px-4 py-3"></div>
                            </div>
                            <div><label class="block text-sm font-medium text-gray-700">Deskripsi</label><textarea wire:model="description" rows="4" class="module-field mt-2 block w-full px-4 py-3"></textarea></div>
                            <label class="inline-flex items-center gap-3 text-sm text-gray-700"><input wire:model="is_active" type="checkbox" class="rounded border-gray-300 text-blue-600"> Aktif digunakan</label>
                        </div>
                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="module-neutral-btn px-5 py-3 text-sm">Batal</button>
                            <button type="submit" class="module-primary-btn px-5 py-3 text-sm">{{ $isEditing ? 'Simpan Perubahan' : 'Simpan Sumber Dana' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
