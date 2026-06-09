<div class="module-panel">
    <div class="module-panel-header px-6 py-5">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Tahun Anggaran</h3>
                <p class="mt-1 text-sm text-gray-600">Kelola tahun anggaran APBDes, status penetapan, dan dasar regulasinya.</p>
            </div>
            <div class="flex items-center gap-3">
                <input wire:model.live="search" type="text" placeholder="Cari tahun atau judul..."
                    class="module-search-input px-4 py-3 text-sm">
                @permission('budgets.create')
                    <button wire:click="openModal"
                        class="module-primary-btn px-5 py-3 text-sm">Tambah Tahun</button>
                @endpermission
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="module-table-head">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Tahun</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Judul</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Perdes</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Periode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($records as $record)
                    <tr class="module-table-row">
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $record->year }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $record->title }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $record->status === 'active' ? 'bg-green-100 text-green-700' : ($record->status === 'reported' ? 'bg-indigo-100 text-indigo-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $record->apbdes_regulation_number ?: '-' }}
                            <div class="text-xs text-gray-500">{{ optional($record->apbdes_regulation_date)->format('d M Y') ?: 'Tanggal belum diisi' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ optional($record->start_date)->format('d M Y') ?: '-' }} - {{ optional($record->end_date)->format('d M Y') ?: '-' }}
                        </td>
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
                    <tr><td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">Belum ada tahun anggaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
        {{ $records->links() }}
    </div>

    @if ($showModal)
        <div class="app-modal-overlay" data-modal-overlay wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-3xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-emerald-50 to-teal-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $isEditing ? 'Edit Tahun Anggaran' : 'Tambah Tahun Anggaran' }}</h3>
                                <p class="mt-1 text-sm text-slate-500">Tetapkan periode dan status dasar APBDes.</p>
                            </div>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">X</button>
                        </div>
                    </div>
                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tahun</label>
                                    <input wire:model="year" type="number" class="module-field mt-2 block w-full px-4 py-3">
                                    @error('year') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select wire:model="status" class="module-field mt-2 block w-full px-4 py-3">
                                        <option value="draft">Draft</option>
                                        <option value="active">Aktif</option>
                                        <option value="revised">Perubahan</option>
                                        <option value="reported">Pertanggungjawaban</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul</label>
                                    <input wire:model="title" type="text" class="module-field mt-2 block w-full px-4 py-3">
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                    <input wire:model="start_date" type="date" class="module-field mt-2 block w-full px-4 py-3">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                    <input wire:model="end_date" type="date" class="module-field mt-2 block w-full px-4 py-3">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nomor Perdes APBDes</label>
                                    <input wire:model="apbdes_regulation_number" type="text" class="module-field mt-2 block w-full px-4 py-3">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Perdes APBDes</label>
                                    <input wire:model="apbdes_regulation_date" type="date" class="module-field mt-2 block w-full px-4 py-3">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                <textarea wire:model="notes" rows="4" class="module-field mt-2 block w-full px-4 py-3"></textarea>
                            </div>
                        </div>
                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="module-neutral-btn px-5 py-3 text-sm">Batal</button>
                            <button type="submit" class="module-primary-btn px-5 py-3 text-sm">{{ $isEditing ? 'Simpan Perubahan' : 'Simpan Tahun' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
