<div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 px-6 py-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V8a2 2 0 012-2h1l1-2h10l1 2h1a2 2 0 012 2v10a2 2 0 01-2 2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12h10M7 16h6">
                        </path>
                    </svg>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Manajemen Berita</h2>
                    <p class="mt-1 text-sm text-gray-600">Kelola artikel, status publikasi, dan kategori berita desa</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                @if ($search || $status || $categoryId)
                    <button wire:click="clearFilters"
                        class="inline-flex items-center px-4 py-3 bg-white border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all duration-200">
                        Reset Filter
                    </button>
                @endif

                @permission('posts.create')
                    <button wire:click="$dispatch('openPostForm')"
                        class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tulis Berita
                    </button>
                @endpermission
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            <button type="button" wire:click="setStatusFilter('')"
                class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-1 text-left {{ $status === '' ? 'border-blue-300 shadow-2xl' : '' }}">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ $status === '' ? 'opacity-100' : '' }}">
                </div>

                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 20H5a2 2 0 01-2-2V8a2 2 0 012-2h1l1-2h10l1 2h1a2 2 0 012 2v10a2 2 0 01-2 2z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 12h10M7 16h6"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Total Artikel</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span class="text-sm text-blue-600 font-semibold">Semua status</span>
                                </div>
                                <div class="text-xs text-gray-500">Filter aktif</div>
                            </div>
                        </div>
                    </div>
                </div>
            </button>

            <button type="button" wire:click="setStatusFilter('published')"
                class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-green-300 transition-all duration-300 transform hover:-translate-y-1 text-left {{ $status === 'published' ? 'border-green-300 shadow-2xl' : '' }}">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ $status === 'published' ? 'opacity-100' : '' }}">
                </div>

                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Sudah Terbit</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['published'] }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-green-600 font-semibold">Siap dibaca warga</span>
                                </div>
                                <div class="text-xs text-gray-500">Live</div>
                            </div>
                        </div>
                    </div>
                </div>
            </button>

            <button type="button" wire:click="setStatusFilter('review')"
                class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-purple-300 transition-all duration-300 transform hover:-translate-y-1 text-left {{ $status === 'review' ? 'border-purple-300 shadow-2xl' : '' }}">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ $status === 'review' ? 'opacity-100' : '' }}">
                </div>

                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Perlu Review</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['review'] }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                    <span class="text-sm text-purple-600 font-semibold">Menunggu editor</span>
                                </div>
                                <div class="text-xs text-gray-500">Editorial</div>
                            </div>
                        </div>
                    </div>
                </div>
            </button>

            <button type="button" wire:click="setStatusFilter('draft')"
                class="group relative bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200 hover:shadow-2xl hover:border-yellow-300 transition-all duration-300 transform hover:-translate-y-1 text-left {{ $status === 'draft' ? 'border-yellow-300 shadow-2xl' : '' }}">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-yellow-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ $status === 'draft' ? 'opacity-100' : '' }}">
                </div>

                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Draft</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $stats['draft'] }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                    <span class="text-sm text-yellow-600 font-semibold">Dalam penulisan</span>
                                </div>
                                <div class="text-xs text-gray-500">Internal</div>
                            </div>
                        </div>
                    </div>
                </div>
            </button>
        </div>

        <div
            class="mt-6 flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-6">
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <input wire:model.live="search" type="text"
                        placeholder="Cari judul, slug, ringkasan, atau isi artikel..."
                        class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                <select wire:model.live="status"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all duration-200">
                    <option value="">Semua status</option>
                    <option value="draft">Draft</option>
                    <option value="review">Review</option>
                    <option value="published">Published</option>
                </select>

                <select wire:model.live="categoryId"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all duration-200">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
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

    <div class="bg-white p-6">
        @forelse($posts as $post)
            @if ($loop->first)
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            @endif

            <div
                class="group flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:border-blue-200 hover:shadow-xl">
                <div class="relative h-40 shrink-0 overflow-hidden bg-gray-100">
                    @if ($post->cover_image_url)
                        <img src="{{ $post->cover_image_url }}" alt="{{ $post->cover_image_alt ?: $post->title }}"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div
                            class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-400 to-purple-500">
                            <span class="text-2xl font-bold text-white">
                                {{ strtoupper(substr($post->title, 0, 2)) }}
                            </span>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                    <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                        <span
                            class="inline-flex items-center rounded-xl bg-white/90 px-3 py-1.5 text-xs font-semibold text-blue-800 shadow-sm">
                            {{ $post->category?->name ?? 'Tanpa kategori' }}
                        </span>

                        <span
                            class="inline-flex items-center rounded-xl px-3 py-1.5 text-xs font-semibold shadow-sm
                            {{ $post->status === 'published'
                                ? 'bg-green-100 text-green-800'
                                : ($post->status === 'review'
                                    ? 'bg-purple-100 text-purple-800'
                                    : 'bg-yellow-100 text-yellow-800') }}">
                            <span
                                class="mr-2 h-2 w-2 rounded-full
                                {{ $post->status === 'published'
                                    ? 'bg-green-500 animate-pulse'
                                    : ($post->status === 'review'
                                        ? 'bg-purple-500'
                                        : 'bg-yellow-500') }}">
                            </span>
                            {{ $post->status === 'published' ? 'Published' : ($post->status === 'review' ? 'Review' : 'Draft') }}
                        </span>
                    </div>

                    @if ($post->is_featured)
                        <div class="absolute top-4 right-4">
                            <span
                                class="inline-flex items-center rounded-md bg-amber-400/90 px-2 py-1 text-[10px] font-medium text-white shadow">
                                Unggulan
                            </span>
                        </div>
                    @endif

                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <h3 class="min-h-[3rem] overflow-hidden text-sm font-semibold leading-6 text-white">
                            {{ $post->title }}
                        </h3>

                        <p class="mt-1 text-[11px] text-white/80">
                            {{ optional($post->published_at)->format('M d, Y') ?? 'Belum dipublish' }}
                            <span class="mx-1">&bull;</span>{{ $post->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-1 flex-col p-5">
                    <p class="min-h-[4.5rem] overflow-hidden text-sm leading-6 text-gray-500">
                        {{ \Illuminate\Support\Str::limit($post->excerpt ?: strip_tags($post->content), 110) }}
                    </p>

                    <div class="mt-4 min-h-[3.5rem]">
                        <div class="flex flex-wrap gap-2">
                            @forelse(($post->tags ?? []) as $tag)
                                <span
                                    class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                    #{{ $tag }}
                                </span>
                            @empty
                                <span class="text-sm text-gray-400">Belum ada tag</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-4 flex items-center border-t border-gray-100 pt-4">
                        <div
                            class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-400 to-purple-500 shadow-md">
                            <span class="text-sm font-bold text-white">
                                {{ strtoupper(substr($post->author?->name ?? 'A', 0, 1)) }}
                            </span>
                        </div>

                        <div>
                            <div class="text-sm font-medium text-gray-900">
                                {{ $post->author?->name ?? '-' }}
                            </div>

                            <div class="text-xs text-gray-500">
                                {{ $post->village?->name ?? '-' }}
                            </div>
                        </div>
                    </div>

                    @if ($post->cover_image_caption)
                        <div class="mt-3 min-h-[2rem] text-[11px] text-gray-400">
                            {{ $post->cover_image_caption }}
                        </div>
                    @else
                        <div class="mt-3 min-h-[2rem]"></div>
                    @endif

                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <div class="flex flex-wrap gap-2">
                            @permission('posts.edit')
                                <button wire:click="$dispatch('openPostForm', { postId: {{ $post->id }} })"
                                    class="group/btn inline-flex items-center rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition-all duration-200 hover:bg-blue-100 hover:text-blue-700 hover:scale-105">
                                    <svg class="mr-1.5 h-4 w-4 transition-transform duration-200 group-hover/btn:rotate-12"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Edit
                                </button>
                            @endpermission

                            @if ($post->status !== 'published')
                                @permission('posts.publish')
                                    <button wire:click="publishPost({{ $post->id }})"
                                        class="group/btn inline-flex items-center rounded-lg bg-green-50 px-3 py-2 text-xs font-semibold text-green-600 transition-all duration-200 hover:bg-green-100 hover:text-green-700 hover:scale-105">
                                        <svg class="mr-1.5 h-4 w-4 transition-transform duration-200 group-hover/btn:scale-110"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Publish
                                    </button>
                                @endpermission
                            @else
                                @permission('posts.edit')
                                    <button wire:click="moveToDraft({{ $post->id }})"
                                        class="group/btn inline-flex items-center rounded-lg bg-yellow-50 px-3 py-2 text-xs font-semibold text-yellow-600 transition-all duration-200 hover:bg-yellow-100 hover:text-yellow-700 hover:scale-105">
                                        <svg class="mr-1.5 h-4 w-4 transition-transform duration-300 group-hover/btn:rotate-180"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                            </path>
                                        </svg>
                                        Pindah ke Draft
                                    </button>
                                @endpermission
                            @endif

                            @permission('posts.delete')
                                <button wire:click="confirmDeletePost({{ $post->id }})"
                                    class="group/btn inline-flex items-center rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition-all duration-200 hover:bg-red-100 hover:text-red-700 hover:scale-105">
                                    <svg class="mr-1.5 h-4 w-4 group-hover/btn:animate-bounce" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Hapus
                                </button>
                            @endpermission
                        </div>
                    </div>
                </div>
            </div>

            @if ($loop->last)
                </div>
            @endif
        @empty
            <div class="flex flex-col items-center justify-center py-16">
                <div
                    class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V8a2 2 0 012-2h1l1-2h10l1 2h1a2 2 0 012 2v10a2 2 0 01-2 2zM7 12h10M7 16h6">
                        </path>
                    </svg>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada artikel</h3>

                <p class="text-gray-500 mb-6 max-w-sm text-center">
                    @if ($search || $status || $categoryId)
                        Coba ubah kata kunci atau filter untuk menemukan artikel yang dicari.
                    @else
                        Mulai dengan membuat artikel pertama untuk kanal berita publik.
                    @endif
                </p>

                @if (!$search && !$status && !$categoryId)
                    @permission('posts.create')
                        <button wire:click="$dispatch('openPostForm')"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Artikel Pertama
                        </button>
                    @endpermission
                @else
                    <button wire:click="clearFilters"
                        class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-300">
                        Reset Filter
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-t border-gray-200 rounded-b-2xl">
        <div class="flex items-center justify-between gap-4">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-medium">{{ $posts->firstItem() ?? 0 }}</span> sampai <span
                    class="font-medium">{{ $posts->lastItem() ?? 0 }}</span> dari <span
                    class="font-medium">{{ $posts->total() }}</span> artikel
            </div>

            <div class="flex-1 flex justify-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
