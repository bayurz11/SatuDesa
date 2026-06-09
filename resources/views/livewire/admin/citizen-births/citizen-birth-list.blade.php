<div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-50 via-sky-50 to-cyan-50 px-6 py-6 border-b border-gray-200">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kelahiran Penduduk</h2>
                <p class="mt-1 text-sm text-gray-600">Pencatatan peristiwa kelahiran untuk penambahan data penduduk baru.</p>
            </div>
            <div class="flex items-center gap-3">
                <input wire:model.live="search" type="text" placeholder="Cari nama anak, NIK, orang tua..."
                    class="w-72 rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @permission('citizen_births.create')
                    <button wire:click="$dispatch('openCitizenBirthForm')" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Tambah Kelahiran
                    </button>
                @endpermission
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Anak</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Tanggal Lahir</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Orang Tua</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">KK</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Pelapor</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($births as $birth)
                    <tr class="hover:bg-blue-50/60 transition-colors">
                        <td class="px-6 py-5">
                            <div class="font-semibold text-gray-900">{{ $birth->citizen?->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $birth->citizen?->nik }} • {{ $birth->citizen?->gender }}</div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-700">
                            {{ $birth->citizen?->birth_place }}{{ $birth->citizen?->birth_date ? ', ' . $birth->citizen?->birth_date->format('d M Y') : '' }}
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-700">
                            <div>Ayah: {{ $birth->father_name ?: '-' }}</div>
                            <div>Ibu: {{ $birth->mother_name ?: '-' }}</div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-700">{{ $birth->household?->no_kk ?: '-' }}</td>
                        <td class="px-6 py-5 text-sm text-gray-700">{{ $birth->reporter_name ?: '-' }}</td>
                        <td class="px-6 py-5">
                            <div class="flex gap-2">
                                @permission('citizen_births.edit')
                                    <button wire:click="$dispatch('openCitizenBirthForm', { birthId: {{ $birth->id }} })" class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-100">
                                        Edit
                                    </button>
                                @endpermission
                                @permission('citizen_births.delete')
                                    <button wire:click="confirmDeleteBirth({{ $birth->id }})"
                                        class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">
                                        Hapus
                                    </button>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-500">Belum ada data kelahiran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $births->links() }}
    </div>
</div>
