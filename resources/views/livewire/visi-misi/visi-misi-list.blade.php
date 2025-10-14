<div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 px-6 py-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Visi & Misi Management</h2>
                    <p class="text-sm text-gray-600 mt-1">Kelola konten visi, misi, nilai-nilai, dan kontak</p>
                </div>
            </div>

            @permission('profil.edit')
                <div class="flex gap-3">
                    <button wire:click="resetToDb"
                        class="group bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl text-sm font-semibold flex items-center shadow-sm transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9M9 4h5" />
                        </svg>
                        Reset Perubahan
                    </button>

                    <button wire:click="save"
                        class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-6 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </button>
                </div>
            @endpermission
        </div>
    </div>

    {{-- BODY: FORM + PREVIEW --}}
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- FORM --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6">
                {{-- Publish Toggle + Info --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="text-sm text-gray-600">
                        <div class="font-semibold">Status</div>
                        <div class="text-xs">
                            Terakhir diperbarui:
                            <span class="font-medium">{{ $updatedAt?->format('d M Y H:i') ?? '-' }}</span>
                        </div>
                    </div>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="form.is_published" class="sr-only peer">
                        <div
                            class="w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer
                                    peer-checked:bg-green-500 relative transition">
                            <div
                                class="absolute top-1 left-1 w-6 h-6 bg-white rounded-full transition
                                        peer-checked:translate-x-6">
                            </div>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700">
                            {{ $form['is_published'] ? 'Published' : 'Draft' }}
                        </span>
                    </label>
                </div>

                {{-- VISI --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Visi Desa</label>
                    <textarea wire:model.defer="form.visi" rows="4"
                        class="block w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('form.visi')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- MISI (Repeatable) --}}
                <div class="mb-5">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700">Misi</label>
                        <button type="button" wire:click="addMisi"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-700">+ Tambah Misi</button>
                    </div>
                    <div class="mt-2 space-y-2">
                        @foreach ($form['misi_items'] as $i => $m)
                            <div class="flex gap-2">
                                <input type="text" wire:model.defer="form.misi_items.{{ $i }}"
                                    class="flex-1 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Tuliskan misi...">
                                <button type="button" wire:click="removeMisi({{ $i }})"
                                    class="px-3 py-2 text-xs rounded-lg bg-red-50 text-red-600 hover:bg-red-100">Hapus</button>
                            </div>
                            @error("form.misi_items.$i")
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        @endforeach
                        @if (empty($form['misi_items']))
                            <p class="text-xs text-gray-500">Belum ada misi. Tambahkan minimal satu.</p>
                        @endif
                    </div>
                </div>

                {{-- NILAI-NILAI (Repeatable objek) --}}
                <div class="mb-5">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700">Nilai-nilai</label>
                        <button type="button" wire:click="addNilai"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-700">+ Tambah Nilai</button>
                    </div>
                    <div class="mt-2 space-y-2">
                        @foreach ($form['nilai_items'] as $i => $n)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <input type="text" wire:model.defer="form.nilai_items.{{ $i }}.judul"
                                    class="rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Judul (Gotong Royong)">
                                <input type="text" wire:model.defer="form.nilai_items.{{ $i }}.deskripsi"
                                    class="rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Deskripsi singkat">
                            </div>
                            <div class="flex justify-end">
                                <button type="button" wire:click="removeNilai({{ $i }})"
                                    class="px-3 py-2 text-xs rounded-lg bg-red-50 text-red-600 hover:bg-red-100">Hapus</button>
                            </div>
                            @error("form.nilai_items.$i.judul")
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            @error("form.nilai_items.$i.deskripsi")
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        @endforeach
                        @if (empty($form['nilai_items']))
                            <p class="text-xs text-gray-500">Belum ada nilai. Tambahkan sesuai kebutuhan.</p>
                        @endif
                    </div>
                </div>

                {{-- KONTAK & TAUTAN --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" wire:model.defer="form.alamat"
                            class="w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('form.alamat')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" wire:model.defer="form.email"
                            class="w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('form.email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" wire:model.defer="form.telepon"
                            class="w-full rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('form.telepon')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-5">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700">Tautan Terkait</label>
                        <button type="button" wire:click="addTautan"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-700">+ Tambah Tautan</button>
                    </div>
                    <div class="mt-2 space-y-2">
                        @foreach ($form['tautan_terkait'] as $i => $t)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <input type="text"
                                    wire:model.defer="form.tautan_terkait.{{ $i }}.judul"
                                    class="rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Judul tautan">
                                <input type="text" wire:model.defer="form.tautan_terkait.{{ $i }}.url"
                                    class="rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="URL, contoh: /profil/struktur">
                            </div>
                            <div class="flex justify-end">
                                <button type="button" wire:click="removeTautan({{ $i }})"
                                    class="px-3 py-2 text-xs rounded-lg bg-red-50 text-red-600 hover:bg-red-100">Hapus</button>
                            </div>
                        @endforeach
                        @if (empty($form['tautan_terkait']))
                            <p class="text-xs text-gray-500">Belum ada tautan.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- PREVIEW --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-0 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="text-sm font-semibold text-gray-700">Live Preview (tampilan user)</div>
                </div>

                <div class="p-6">
                    {{-- Heading --}}
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-extrabold text-green-700">Visi & Misi Desa Mentuda</h1>
                        <p class="text-sm text-gray-600 mt-1">Pratinjau konten seperti di halaman publik</p>
                    </div>

                    {{-- Visi --}}
                    <div class="rounded-xl border p-5 bg-white mb-5">
                        <h2 class="text-lg font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Visi
                        </h2>
                        <div class="mt-3 text-gray-800 leading-relaxed whitespace-pre-line">
                            {{ $form['visi'] ?? '' }}
                        </div>
                    </div>

                    {{-- Misi --}}
                    <div class="rounded-xl border p-5 bg-white mb-5">
                        <h2 class="text-lg font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Misi
                        </h2>
                        <ul class="mt-3 space-y-1 text-gray-800">
                            @forelse($form['misi_items'] as $m)
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-green-600 mt-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ $m }}</span>
                                </li>
                            @empty
                                <li class="text-sm text-gray-500">Belum ada misi.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Nilai-nilai --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($form['nilai_items'] as $n)
                            <div class="rounded-xl border p-4 bg-white">
                                <h4 class="font-semibold">{{ $n['judul'] ?? '' }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $n['deskripsi'] ?? '' }}</p>
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-3 text-sm text-gray-500">Belum ada nilai-nilai.</div>
                        @endforelse
                    </div>

                    {{-- Sidebar: Kontak + Tautan (ringkas) --}}
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2 rounded-xl border p-4 bg-white">
                            <div class="text-sm text-gray-600">
                                <div class="font-semibold text-gray-800">Kontak</div>
                                <div>{{ $form['alamat'] }}</div>
                                <div>Email: {{ $form['email'] }}</div>
                                <div>Telp: {{ $form['telepon'] }}</div>
                            </div>
                        </div>
                        <div class="rounded-xl border p-4 bg-white">
                            <div class="font-semibold text-gray-800 text-sm mb-2">Tautan Terkait</div>
                            <ul class="space-y-1 text-sm">
                                @forelse($form['tautan_terkait'] as $t)
                                    <li>
                                        <span class="text-green-700">{{ $t['judul'] ?? '' }}</span>
                                        <span class="text-gray-500">— {{ $t['url'] ?? '' }}</span>
                                    </li>
                                @empty
                                    <li class="text-gray-500">Belum ada tautan.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    @if (!$form['is_published'])
                        <div class="mt-6 p-4 rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm">
                            Konten dalam status <strong>Draft</strong>. Publikasikan untuk menampilkan di halaman
                            publik.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-t border-gray-200 rounded-b-2xl">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                <span class="font-medium">{{ count($form['misi_items'] ?? []) }}</span> misi •
                <span class="font-medium">{{ count($form['nilai_items'] ?? []) }}</span> nilai-nilai
            </div>
            <div class="text-sm text-gray-600">
                Status: <span class="font-medium">{{ $form['is_published'] ? 'Published' : 'Draft' }}</span>
            </div>
        </div>
    </div>
</div>
