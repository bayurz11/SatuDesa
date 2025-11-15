<div class="p-6">

    {{-- 🔦 Spotlight hanya untuk beranda + mode news --}}
    @if ($homeSpotlight && $mode === 'news' && isset($spotlight) && $spotlight->count())
        @include('livewire.content.partials.home-news-grid', ['news' => $spotlight])
    @else
        {{-- Filter bar (khusus potensi: tampilkan filter kategori potensi) --}}
        @if ($mode === 'potensi' && isset($potensiCategories) && count($potensiCategories))
            <div class="mb-4 flex flex-wrap items-center gap-3">
                <label class="text-sm text-gray-700">Kategori Potensi:</label>
                <select wire:model.live="potensiCategory"
                    class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    <option value="">Semua</option>
                    @foreach ($potensiCategories as $pc)
                        <option value="{{ $pc }}">{{ $pc }}</option>
                    @endforeach
                </select>
                @if ($potensiCategory)
                    <button wire:click="$set('potensiCategory', null)"
                        class="text-sm px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                        Reset
                    </button>
                @endif
            </div>
        @endif
        {{-- ★ end filter bar --}}

        {{-- Mode normal (announcement / news / potensi) --}}
        @switch($mode)
            @case('announcement')
                @include('livewire.content.partials.announcements', ['items' => $items])
            @break

            @case('news')
                @include('livewire.content.partials.news', ['items' => $items])
            @break

            {{-- 
            @case('potensi')
                @include('livewire.content.partials.potensi', ['items' => $items])
            @break --}}

            @default
                <p class="text-gray-500 text-center py-8">Tidak ada konten untuk ditampilkan.</p>
        @endswitch

        {{-- Pagination --}}
        @if ($showPagination && $items->hasPages())
            <div class="pt-4 flex justify-center">
                {{ $items->onEachSide(1)->links() }}
            </div>
        @endif
    @endif
</div>
