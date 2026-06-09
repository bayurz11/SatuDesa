<div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 px-6 py-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5m10 0H7" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Kartu Keluarga</h2>
                    <p class="mt-1 text-sm text-gray-600">Kelola nomor KK, kepala keluarga, jumlah anggota, dan wilayah administrasi keluarga.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @permission('households.create')
                    <button wire:click="$dispatch('openHouseholdForm')" class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah KK
                    </button>
                @endpermission
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent"></div>
                <div class="relative p-6">
                    <p class="text-sm font-medium text-gray-600 mb-1">Total KK</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total_households'] }}</p>
                    <div class="mt-4 text-sm text-blue-600 font-semibold">Nomor keluarga aktif</div>
                </div>
            </div>
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent"></div>
                <div class="relative p-6">
                    <p class="text-sm font-medium text-gray-600 mb-1">Dengan Kepala Keluarga</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['with_head'] }}</p>
                    <div class="mt-4 text-sm text-emerald-600 font-semibold">Siap dipakai layanan</div>
                </div>
            </div>
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent"></div>
                <div class="relative p-6">
                    <p class="text-sm font-medium text-gray-600 mb-1">Belum Ada Kepala Keluarga</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['without_head'] }}</p>
                    <div class="mt-4 text-sm text-amber-600 font-semibold">Perlu dilengkapi</div>
                </div>
            </div>
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent"></div>
                <div class="relative p-6">
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Anggota Terhubung</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total_members'] }}</p>
                    <div class="mt-4 text-sm text-purple-600 font-semibold">Sinkron data keluarga</div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-6">
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Cari nomor KK, alamat, atau kepala keluarga..."
                        class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                <select wire:model.live="perPage"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all duration-200">
                    <option value="10">10 per halaman</option>
                    <option value="25">25 per halaman</option>
                    <option value="50">50 per halaman</option>
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tl-xl">No KK</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kepala Keluarga</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Wilayah</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Anggota</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($households as $household)
                    <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 group">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $household->no_kk }}</div>
                            <div class="text-xs text-gray-500">Dokumen keluarga</div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $household->headCitizen?->full_name ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $household->headCitizen?->nik ?? 'Belum ditetapkan' }}</div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-700">
                            <div>{{ $household->hamlet?->name ?? '-' }}</div>
                            <div class="text-xs text-gray-500">RW {{ $household->rw?->number ?? '-' }} / RT {{ $household->rt?->number ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm text-gray-700 max-w-xs">{{ $household->address }}</div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center rounded-xl bg-gradient-to-r from-indigo-100 to-purple-100 px-3 py-1.5 text-xs font-semibold text-indigo-700 shadow-sm">
                                {{ $household->citizens_count }} anggota
                            </span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                @permission('households.edit')
                                    <button wire:click="$dispatch('openHouseholdForm', { householdId: {{ $household->id }} })" class="group/btn inline-flex items-center px-3 py-2 text-xs font-semibold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-1.5 group-hover/btn:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                @endpermission
                                @permission('households.delete')
                                    <button wire:click="confirmDeleteHousehold({{ $household->id }})" class="group/btn inline-flex items-center px-3 py-2 text-xs font-semibold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 hover:text-red-700 transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-1.5 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </button>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5V4H2v16h5m10 0v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5m10 0H7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada data kartu keluarga</h3>
                                <p class="text-gray-500 mb-6 max-w-sm text-center">
                                    Tambahkan data KK agar relasi kepala keluarga, wilayah, dan anggota penduduk dapat dikelola lebih rapi.
                                </p>
                                @permission('households.create')
                                    <button wire:click="$dispatch('openHouseholdForm')" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Tambah KK Pertama
                                    </button>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-t border-gray-200 rounded-b-2xl">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-medium">{{ $households->firstItem() ?? 0 }}</span> sampai <span class="font-medium">{{ $households->lastItem() ?? 0 }}</span> dari <span class="font-medium">{{ $households->total() }}</span> data KK
            </div>
            <div class="flex-1 flex justify-center">
                {{ $households->links() }}
            </div>
        </div>
    </div>
</div>
