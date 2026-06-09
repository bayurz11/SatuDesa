<div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-50 via-emerald-50 to-teal-50 px-6 py-6 border-b border-gray-200">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Pindah Datang Penduduk</h2>
                <p class="mt-1 text-sm text-gray-600">Pencatatan warga yang masuk atau pindah datang ke desa.</p>
            </div>
            <div class="flex items-center gap-3">
                <input wire:model.live="search" type="text" placeholder="Cari nama, NIK, asal wilayah..."
                    class="w-72 rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @permission('citizen_arrivals.create')
                    <button wire:click="$dispatch('openCitizenArrivalForm')" class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">
                        Tambah Pindah Datang
                    </button>
                @endpermission
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Penduduk</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Tanggal Datang</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Asal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Alasan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">KK</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($arrivals as $arrival)
                    <tr class="hover:bg-emerald-50/60 transition-colors">
                        <td class="px-6 py-5">
                            <div class="font-semibold text-gray-900">{{ $arrival->citizen?->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $arrival->citizen?->nik }}</div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-700">{{ $arrival->arrival_date?->format('d M Y') }}</td>
                        <td class="px-6 py-5 text-sm text-gray-700">
                            <div>{{ $arrival->origin_region ?: '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $arrival->origin_address ?: '-' }}</div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-700">{{ $arrival->arrival_reason ?: '-' }}</td>
                        <td class="px-6 py-5 text-sm text-gray-700">{{ $arrival->household?->no_kk ?: '-' }}</td>
                        <td class="px-6 py-5">
                            <div class="flex gap-2">
                                @permission('citizen_arrivals.edit')
                                    <button wire:click="$dispatch('openCitizenArrivalForm', { arrivalId: {{ $arrival->id }} })" class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-100">Edit</button>
                                @endpermission
                                @permission('citizen_arrivals.delete')
                                    <button wire:click="confirmDeleteArrival({{ $arrival->id }})"
                                        class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">Hapus</button>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-16 text-center text-gray-500">Belum ada data pindah datang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $arrivals->links() }}
    </div>
</div>
