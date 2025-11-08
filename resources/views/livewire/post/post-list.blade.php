<div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">

    {{-- HEADER + FILTERS --}}
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
                    <h2 class="text-2xl font-bold text-gray-900">Postingan</h2>
                    <p class="text-sm text-gray-600 mt-1">Kelola Berita & Pengumuman</p>
                </div>
            </div>

            @permission('informasi.create')
                <button wire:click="$dispatch('openPostForm')"
                    class="group bg-gradient-to-r from-green-400 to-green-600 hover:from-green-700 hover:to-green-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Post
                </button>
            @endpermission
        </div>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-5 gap-3">
            <div class="lg:col-span-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Cari judul / ringkas / penulis…"
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

            <select wire:model.live="type"
                class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                <option value="">Semua Tipe</option>
                <option value="announcement">Pengumuman</option>
                <option value="news">Berita</option>
            </select>

            <div class="flex gap-3">
                <select wire:model.live="status"
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </select>

                <select wire:model.live="perPage"
                    class="px-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Judul</th>
                    <th wire:click="sortBy('content_type')"
                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase cursor-pointer hover:bg-gray-200">
                        Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                    <th wire:click="sortBy('status')"
                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase cursor-pointer hover:bg-gray-200">
                        Status</th>
                    <th wire:click="sortBy('published_at')"
                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase cursor-pointer hover:bg-gray-200">
                        Published</th>
                    <th wire:click="sortBy('created_at')"
                        class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase cursor-pointer hover:bg-gray-200">
                        Dibuat</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($data as $item)
                    <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all">
                        <td class="px-6 py-5">
                            <div class="font-semibold text-gray-900">{{ $item->title }}</div>
                            <div class="text-xs text-gray-500 line-clamp-1">{{ $item->summary }}</div>
                            <div class="mt-1 text-xs text-gray-500">Tag:
                                @foreach ($item->tags as $t)
                                    <span
                                        class="inline-block bg-emerald-50 ring-1 ring-emerald-200 text-emerald-700 rounded px-2 py-0.5 text-[11px]">#{{ $t->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-800">
                            {{ $item->content_type === 'news' ? 'Berita' : 'Pengumuman' }}</td>
                        <td class="px-6 py-5 text-sm text-gray-800">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold
                            {{ [
                                'draft' => 'bg-gray-100 text-gray-700',
                                'scheduled' => 'bg-yellow-100 text-yellow-800',
                                'published' => 'bg-green-100 text-green-800',
                                'archived' => 'bg-red-100 text-red-800',
                            ][$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-800">
                            {{ $item->published_at?->format('d M Y H:i') ?? '-' }}
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-600">
                            <div class="font-medium">{{ $item->created_at->format('d M Y') }}</div>
                            <div class="text-xs">{{ $item->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                @permission('informasi.edit')
                                    <button wire:click="$dispatch('openPostForm', { id: @js($item->id) })"
                                        class="inline-flex items-center px-3 py-2 text-xs font-semibold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100">
                                        Edit
                                    </button>
                                    <button type="button" wire:click="togglePublish(@js($item->id))"
                                        class="inline-flex items-center px-3 py-2 text-xs font-semibold text-yellow-700 bg-yellow-50 rounded-lg hover:bg-yellow-100">
                                        {{ $item->status === 'published' ? 'Unpublish' : 'Publish' }}
                                    </button>
                                @endpermission

                                @permission('informasi.delete')
                                    <button type="button" wire:click="delete(@js($item->id))"
                                        class="inline-flex items-center px-3 py-2 text-xs font-semibold text-red-600 bg-red-50 rounded-lg hover:bg-red-100">
                                        Delete
                                    </button>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-gray-500">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-t border-gray-200 rounded-b-2xl">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-medium">{{ $data->firstItem() ?? 0 }}</span>
                sampai <span class="font-medium">{{ $data->lastItem() ?? 0 }}</span>
                dari <span class="font-medium">{{ $data->total() }}</span> data
            </div>
            <div class="flex-1 flex justify-center">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>
