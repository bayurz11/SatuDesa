<div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-50 via-rose-50 to-red-50 px-6 py-6 border-b border-gray-200">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kematian Penduduk</h2>
                <p class="mt-1 text-sm text-gray-600">Pencatatan kematian dan perubahan status penduduk menjadi meninggal.</p>
            </div>
            <div class="flex items-center gap-3">
                <input wire:model.live="search" type="text" placeholder="Cari nama, NIK, sebab kematian..."
                    class="w-72 rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @permission('citizen_deaths.create')
                    <button wire:click="$dispatch('openCitizenDeathForm')" class="rounded-xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white hover:bg-rose-700">
                        Tambah Kematian
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
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Tempat</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Sebab</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Pelapor</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($deaths as $death)
                    <tr class="hover:bg-rose-50/60 transition-colors">
                        <td class="px-6 py-5">
                            <div class="font-semibold text-gray-900">{{ $death->citizen?->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $death->citizen?->nik }}</div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-700">
                            {{ $death->death_date?->format('d M Y') }}{{ $death->death_time ? ' • ' . $death->death_time : '' }}
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-700">{{ $death->death_place ?: '-' }}</td>
                        <td class="px-6 py-5 text-sm text-gray-700">{{ $death->cause_of_death ?: '-' }}</td>
                        <td class="px-6 py-5 text-sm text-gray-700">{{ $death->reporter_name ?: '-' }}</td>
                        <td class="px-6 py-5">
                            <div class="flex gap-2">
                                @permission('citizen_deaths.edit')
                                    <button wire:click="$dispatch('openCitizenDeathForm', { deathId: {{ $death->id }} })" class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-100">Edit</button>
                                @endpermission
                                @permission('citizen_deaths.delete')
                                    <button wire:click="confirmDeleteDeath({{ $death->id }})"
                                        class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">Hapus</button>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-16 text-center text-gray-500">Belum ada data kematian.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $deaths->links() }}
    </div>
</div>
