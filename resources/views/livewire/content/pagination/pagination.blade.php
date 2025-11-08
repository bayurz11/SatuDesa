@if ($paginator->hasPages())
    <div class="pt-4">
        <nav class="flex justify-center" aria-label="Pagination">
            <ul class="inline-flex items-center gap-2 text-sm">

                {{-- Prev --}}
                <li>
                    @if ($paginator->onFirstPage())
                        <span
                            class="px-3 py-1 rounded-lg border border-gray-300 text-gray-300 cursor-not-allowed">«</span>
                    @else
                        <button wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            class="px-3 py-1 rounded-lg border border-gray-300 text-gray-600 hover:bg-green-600 hover:text-white transition"
                            type="button">«</button>
                    @endif
                </li>

                {{-- Pages --}}
                @foreach ($elements as $element)
                    {{-- Separator (...) --}}
                    @if (is_string($element))
                        <li>
                            <span
                                class="px-3 py-1 rounded-lg border border-gray-300 text-gray-500">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array of links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li>
                                @if ($page == $paginator->currentPage())
                                    <span
                                        class="px-3 py-1 rounded-lg border border-green-600 bg-green-600 text-white">{{ $page }}</span>
                                @else
                                    <button
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                        class="px-3 py-1 rounded-lg border border-gray-300 text-gray-600 hover:bg-green-600 hover:text-white transition"
                                        type="button">{{ $page }}</button>
                                @endif
                            </li>
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                <li>
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            class="px-3 py-1 rounded-lg border border-gray-300 text-gray-600 hover:bg-green-600 hover:text-white transition"
                            type="button">»</button>
                    @else
                        <span
                            class="px-3 py-1 rounded-lg border border-gray-300 text-gray-300 cursor-not-allowed">»</span>
                    @endif
                </li>

            </ul>
        </nav>
    </div>
@endif
