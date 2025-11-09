<div class="p-6">
    {{-- 🔦 Spotlight hanya untuk beranda + mode news --}}
    @if ($homeSpotlight && $mode === 'news' && isset($spotlight) && $spotlight->count())
        @include('livewire.content.partials.home-news-grid', ['news' => $spotlight])
    @else
        {{-- Mode normal (announcement / news / potensi) --}}
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
