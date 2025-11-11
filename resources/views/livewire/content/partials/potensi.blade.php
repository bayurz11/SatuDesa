{{-- resources/views/livewire/content/partials/potensi.blade.php --}}
@php
    use Illuminate\Support\Str;
@endphp

@if ($items->count())
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($items as $it)
            @php
                $img = $it->cover_url ?? asset('public/img/potensi1.jpg');
                $badge = $it->potensi_category ?: optional($it->category)->name ?: 'Potensi';
                $detailUrl = route('potensi-desa.detail', $it->slug ?? $it->id); // sesuaikan route detail-mu
            @endphp
            <article class="group rounded-2xl bg-white shadow ring-1 ring-black/5 overflow-hidden">
                <a href="{{ $detailUrl }}" class="block aspect-[16/9] bg-gray-100">
                    <img src="{{ $img }}" alt="{{ $it->title }}"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02] group-hover:grayscale"
                        loading="lazy" decoding="async">
                </a>
                <div class="p-4">
                    <div class="mb-1 flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-medium text-green-700 ring-1 ring-green-200">
                            <x-heroicon-o-tag class="size-4" /> {{ $badge }}
                        </span>
                    </div>
                    <h3 class="text-sm md:text-base font-semibold text-gray-900 line-clamp-2">
                        <a href="{{ $detailUrl }}" class="hover:text-green-700">{{ $it->title }}</a>
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                        {{ Str::limit(strip_tags($it->summary ?: strip_tags($it->body_html ?? '')), 120) }}
                    </p>

                    <div class="mt-3 flex items-center justify-between">
                        <a href="{{ $detailUrl }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-green-600 px-3 py-1.5 text-sm font-medium text-green-700 hover:bg-green-600 hover:text-white transition">
                            <x-heroicon-o-eye class="size-4" /> Detail
                        </a>
                        <a href="{{ $detailUrl }}"
                            class="inline-flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-green-700 transition">
                            <x-heroicon-o-arrows-pointing-out class="size-4" /> Pratayang
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@else
    <div class="py-8 text-center text-gray-500">
        Belum ada data potensi.
    </div>
@endif
