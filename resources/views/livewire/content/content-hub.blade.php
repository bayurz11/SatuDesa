<div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-green-50 via-green-100 to-purple-50 px-6 py-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-400 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V8l6-4h10a2 2 0 012 2v12a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $title }}</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $subtitle }}</p>
                </div>
            </div>

            {{-- Toggle cepat antar mode (opsional, bisa dihilangkan di produksi) --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('pengumuman') }}"
                    class="px-3 py-2 text-xs rounded-lg {{ request()->routeIs('pengumuman') ? 'bg-green-600 text-white' : 'bg-white border text-gray-700 hover:bg-gray-50' }}">Pengumuman</a>
                <a href="{{ route('berita') }}"
                    class="px-3 py-2 text-xs rounded-lg {{ request()->routeIs('berita') ? 'bg-green-600 text-white' : 'bg-white border text-gray-700 hover:bg-gray-50' }}">Berita</a>
                <a href="{{ route('potensi-desa') }}"
                    class="px-3 py-2 text-xs rounded-lg {{ request()->routeIs('potensi-desa') ? 'bg-green-600 text-white' : 'bg-white border text-gray-700 hover:bg-gray-50' }}">Potensi
                    Desa</a>
            </div>
        </div>

        {{-- FILTER BAR (reusable) --}}
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-5 gap-3">
            <div class="lg:col-span-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live="q" type="text" placeholder="Cari judul / ringkasan…"
                        class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                </div>
            </div>

            <select wire:model.live="category"
                class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="perPage"
                class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                <option value="10">10 / halaman</option>
                <option value="12">12 / halaman</option>
                <option value="25">25 / halaman</option>
                <option value="50">50 / halaman</option>
            </select>

            <div class="flex gap-3">
                <select wire:model.live="sortField"
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                    <option value="published_at">Tanggal Terbit</option>
                    <option value="created_at">Dibuat</option>
                    <option value="title">Judul</option>
                </select>
                <select wire:model.live="sortDirection"
                    class="px-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                    <option value="desc">↓</option>
                    <option value="asc">↑</option>
                </select>
            </div>
        </div>
    </div>

    {{-- BODY: Pilih partial sesuai mode --}}
    <div class="p-6">
        @switch($mode)
            @case('announcement')
                @include('livewire.content.partials.announcements', ['items' => $items])
            @break

            @case('news')
                @include('livewire.content.partials.news', ['items' => $items])
            @break

            @case('potensi')
                @include('livewire.content.partials.potensi', ['items' => $items])
            @break
        @endswitch
    </div>

    {{-- FOOTER PAGINATION (sama utk semua) --}}
    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-t border-gray-200 rounded-b-2xl">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-medium">{{ $items->firstItem() ?? 0 }}</span>
                sampai <span class="font-medium">{{ $items->lastItem() ?? 0 }}</span>
                dari <span class="font-medium">{{ $items->total() }}</span> data
            </div>
            <div class="flex-1 flex justify-center">
                {{ $items->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
