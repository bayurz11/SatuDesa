<div class="module-panel">
    <div class="module-panel-header px-6 py-5">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Baris Anggaran</h3>
                <p class="mt-1 text-sm text-gray-600">Susun pagu per akun, tahun anggaran, dan sumber dana APBDes.</p>
            </div>
            <div class="flex items-center gap-3">
                <input wire:model.live="search" type="text" placeholder="Cari deskripsi, akun, atau tahun..."
                    class="module-search-input px-4 py-3 text-sm">
                @permission('budgets.create')
                    <button wire:click="openModal" class="module-primary-btn px-5 py-3 text-sm">Tambah Baris</button>
                @endpermission
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="module-table-head">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Tahun</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Akun</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Sumber Dana</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Deskripsi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Anggaran</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Realisasi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($records as $record)
                    <tr class="module-table-row">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $record->fiscalYear?->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $record->account?->code }} - {{ $record->account?->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $record->fundingSource?->name ?: '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $record->description }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp{{ number_format($record->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp{{ number_format($record->realized_amount, 0, ',', '.') }}</td>
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
                    <tr><td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">Belum ada baris anggaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">{{ $records->links() }}</div>
    @if ($showModal)
        <div class="app-modal-overlay" data-modal-overlay wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-4xl" wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-amber-50 to-orange-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $isEditing ? 'Edit Baris Anggaran' : 'Tambah Baris Anggaran' }}</h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">X</button>
                        </div>
                    </div>
                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div><label class="block text-sm font-medium text-gray-700">Tahun Anggaran</label><select wire:model="fiscal_year_id" class="module-field mt-2 block w-full px-4 py-3"><option value="">Pilih tahun</option>@foreach($fiscalYears as $year)<option value="{{ $year->id }}">{{ $year->title }}</option>@endforeach</select></div>
                                <div><label class="block text-sm font-medium text-gray-700">Akun</label><select wire:model="account_id" class="module-field mt-2 block w-full px-4 py-3"><option value="">Pilih akun</option>@foreach($accounts as $account)<option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>@endforeach</select></div>
                                <div><label class="block text-sm font-medium text-gray-700">Sumber Dana</label><select wire:model="funding_source_id" class="module-field mt-2 block w-full px-4 py-3"><option value="">Pilih sumber dana</option>@foreach($fundingSources as $source)<option value="{{ $source->id }}">{{ $source->code }} - {{ $source->name }}</option>@endforeach</select></div>
                            </div>
                            <div><label class="block text-sm font-medium text-gray-700">Deskripsi</label><input wire:model="description" type="text" class="module-field mt-2 block w-full px-4 py-3"></div>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div><label class="block text-sm font-medium text-gray-700">Nilai Anggaran</label><input wire:model="amount" type="number" min="0" step="0.01" class="module-field mt-2 block w-full px-4 py-3"></div>
                                <div><label class="block text-sm font-medium text-gray-700">Realisasi Awal</label><input wire:model="realized_amount" type="number" min="0" step="0.01" class="module-field mt-2 block w-full px-4 py-3"></div>
                                <div><label class="block text-sm font-medium text-gray-700">Urutan</label><input wire:model="sort_order" type="number" min="0" class="module-field mt-2 block w-full px-4 py-3"></div>
                            </div>
                            <div><label class="block text-sm font-medium text-gray-700">Catatan</label><textarea wire:model="notes" rows="4" class="module-field mt-2 block w-full px-4 py-3"></textarea></div>
                        </div>
                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="module-neutral-btn px-5 py-3 text-sm">Batal</button>
                            <button type="submit" class="module-primary-btn px-5 py-3 text-sm">{{ $isEditing ? 'Simpan Perubahan' : 'Simpan Baris' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
