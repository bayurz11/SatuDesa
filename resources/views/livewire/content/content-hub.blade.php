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
    {{-- Pagination (selaras gaya contoh, tapi pakai paginator Laravel) --}}
    @if ($showPagination && $items->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $items->onEachSide(1)->links() }}
        </div>
    @endif
</div>
