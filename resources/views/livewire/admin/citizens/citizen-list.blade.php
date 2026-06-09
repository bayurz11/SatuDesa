<div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 px-6 py-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5V4H2v16h5m10 0v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5m10 0H7" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Administrasi Penduduk</h2>
                    <p class="mt-1 text-sm text-gray-600">Audit data penduduk, status kependudukan, dan keterhubungan kartu keluarga desa</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if ($search || $status || $gender)
                    <button wire:click="clearFilters"
                        class="inline-flex items-center px-4 py-3 bg-white border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all duration-200">
                        Reset Filter
                    </button>
                @endif
                @permission('citizens.view')
                    <a href="{{ route('citizens.export', ['search' => $search, 'status' => $status, 'gender' => $gender]) }}"
                        class="inline-flex items-center px-4 py-3 bg-white border border-emerald-200 rounded-xl text-sm font-semibold text-emerald-700 hover:bg-emerald-50 transition-all duration-200">
                        Export Excel
                    </a>
                    <a href="{{ route('citizens.template') }}"
                        class="inline-flex items-center px-4 py-3 bg-white border border-blue-200 rounded-xl text-sm font-semibold text-blue-700 hover:bg-blue-50 transition-all duration-200">
                        Template Import
                    </a>
                @endpermission
                @permission('citizens.create')
                    <button wire:click="$dispatch('openCitizenForm')" class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Penduduk
                    </button>
                @endpermission
            </div>
        </div>

        @permission('citizens.create')
            <div class="mt-6 rounded-2xl border border-blue-100 bg-white/80 p-5 shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Import Excel Penduduk</h3>
                        <p class="mt-1 text-sm text-gray-600">Unggah file `.xlsx`, `.xls`, atau `.csv` untuk menambah atau memperbarui data berdasarkan `NIK`.</p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500">File Import</label>
                            <input wire:model="importFile" type="file" accept=".xlsx,.xls,.csv"
                                class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('importFile') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <button wire:click="importCitizens" wire:loading.attr="disabled" wire:target="importCitizens,importFile"
                            class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-60">
                            <span wire:loading.remove wire:target="importCitizens,importFile">Import Excel</span>
                            <span wire:loading wire:target="importCitizens,importFile">Memproses...</span>
                        </button>
                    </div>
                </div>
            </div>
        @endpermission

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mt-6">
            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent"></div>
                <div class="relative p-6">
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Penduduk</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total_citizens'] }}</p>
                    <div class="mt-4 text-sm text-blue-600 font-semibold">Data terdaftar</div>
                </div>
            </div>

            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent"></div>
                <div class="relative p-6">
                    <p class="text-sm font-medium text-gray-600 mb-1">Status Aktif</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['active_citizens'] }}</p>
                    <div class="mt-4 text-sm text-green-600 font-semibold">Siap dilayani</div>
                </div>
            </div>

            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="absolute inset-0 bg-gradient-to-br from-sky-50 to-transparent"></div>
                <div class="relative p-6">
                    <p class="text-sm font-medium text-gray-600 mb-1">Laki-laki</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['male_citizens'] }}</p>
                    <div class="mt-4 text-sm text-sky-600 font-semibold">Komposisi gender</div>
                </div>
            </div>

            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-transparent"></div>
                <div class="relative p-6">
                    <p class="text-sm font-medium text-gray-600 mb-1">Perempuan</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['female_citizens'] }}</p>
                    <div class="mt-4 text-sm text-pink-600 font-semibold">Komposisi gender</div>
                </div>
            </div>

            <div class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent"></div>
                <div class="relative p-6">
                    <p class="text-sm font-medium text-gray-600 mb-1">Total KK</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total_households'] }}</p>
                    <div class="mt-4 text-sm text-amber-600 font-semibold">Kartu keluarga</div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-6">
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Cari nama, NIK, pekerjaan, atau nomor KK..."
                        class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                <select wire:model.live="status"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all duration-200">
                    <option value="">Semua status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                    <option value="moved">Pindah</option>
                    <option value="deceased">Meninggal</option>
                </select>

                <select wire:model.live="gender"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all duration-200">
                    <option value="">Semua gender</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>

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
                    <th wire:click="sortBy('full_name')" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer hover:bg-gray-200 transition-colors duration-200 rounded-tl-xl">
                        <div class="flex items-center space-x-2">
                            <span>Nama</span>
                            @if($sortField === 'full_name')
                                <div class="w-4 h-4 bg-blue-100 rounded flex items-center justify-center">
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </th>
                    <th wire:click="sortBy('nik')" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer hover:bg-gray-200 transition-colors duration-200">
                        <div class="flex items-center space-x-2">
                            <span>NIK</span>
                            @if($sortField === 'nik')
                                <div class="w-4 h-4 bg-blue-100 rounded flex items-center justify-center">
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">KK</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gender</th>
                    <th wire:click="sortBy('birth_date')" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer hover:bg-gray-200 transition-colors duration-200">
                        <div class="flex items-center space-x-2">
                            <span>Lahir</span>
                            @if($sortField === 'birth_date')
                                <div class="w-4 h-4 bg-blue-100 rounded flex items-center justify-center">
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($citizens as $citizen)
                    <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 group">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-md group-hover:shadow-lg transition-shadow duration-300">
                                    <span class="text-sm font-bold text-white">{{ strtoupper(\Illuminate\Support\Str::substr($citizen->full_name, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $citizen->full_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $citizen->family_relationship ?: ($citizen->occupation ?: 'Pekerjaan belum diisi') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $citizen->nik }}</div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $citizen->household?->no_kk ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $citizen->household ? 'Terhubung KK' : 'Belum terhubung' }}</div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm bg-gradient-to-r from-sky-100 to-cyan-100 text-sky-800">
                                {{ $citizen->gender === 'L' ? 'Laki-laki' : ($citizen->gender === 'P' ? 'Perempuan' : $citizen->gender) }}
                            </span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $citizen->birth_place ?: '-' }}
                                @if($citizen->birth_date)
                                    , {{ $citizen->birth_date->format('d M Y') }}
                                @endif
                            </div>
                            <div class="text-xs text-gray-500">{{ $citizen->education ?: 'Pendidikan belum diisi' }}</div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm
                                {{ $citizen->status === 'active'
                                    ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800'
                                    : ($citizen->status === 'moved'
                                        ? 'bg-gradient-to-r from-yellow-100 to-amber-100 text-amber-800'
                                        : 'bg-gradient-to-r from-red-100 to-pink-100 text-red-800') }}">
                                <div class="w-2 h-2 rounded-full mr-2 {{ $citizen->status === 'active' ? 'bg-green-500 animate-pulse' : ($citizen->status === 'moved' ? 'bg-amber-500' : 'bg-red-500') }}"></div>
                                {{ $citizen->status === 'active' ? 'Aktif' : ($citizen->status === 'inactive' ? 'Tidak Aktif' : ($citizen->status === 'moved' ? 'Pindah' : 'Meninggal')) }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm text-gray-700 max-w-xs">{{ $citizen->address ?: ($citizen->household?->address ?: '-') }}</div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                @permission('citizens.edit')
                                    <button wire:click="$dispatch('openCitizenForm', { citizenId: {{ $citizen->id }} })"
                                        class="group/btn inline-flex items-center px-3 py-2 text-xs font-semibold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-1.5 group-hover/btn:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                @endpermission
                                @permission('citizens.delete')
                                    <button wire:click="confirmDeleteCitizen({{ $citizen->id }})"
                                        class="group/btn inline-flex items-center px-3 py-2 text-xs font-semibold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 hover:text-red-700 transition-all duration-200 transform hover:scale-105">
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
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 20h5V4H2v16h5m10 0v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5m10 0H7" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada data penduduk</h3>
                                <p class="text-gray-500 mb-6 max-w-sm text-center">
                                    @if($search || $status || $gender)
                                        Coba ubah kata kunci atau filter untuk menemukan data penduduk yang dicari.
                                    @else
                                        Tabel administrasi penduduk siap digunakan setelah data citizens mulai diinput.
                                    @endif
                                </p>
                                @if($search || $status || $gender)
                                    <button wire:click="clearFilters" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-300">
                                        Reset Filter
                                    </button>
                                @else
                                    @permission('citizens.create')
                                        <button wire:click="$dispatch('openCitizenForm')" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Tambah Penduduk Pertama
                                        </button>
                                    @endpermission
                                @endif
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
                Showing <span class="font-medium">{{ $citizens->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $citizens->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $citizens->total() }}</span> citizens
            </div>
            <div class="flex-1 flex justify-center">
                {{ $citizens->links() }}
            </div>
        </div>
    </div>
</div>
