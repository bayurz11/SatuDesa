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
