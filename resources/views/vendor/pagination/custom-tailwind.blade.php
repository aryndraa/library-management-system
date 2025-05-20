@if ($paginator->hasPages())
    <nav role="navigation" class="flex justify-center mt-4" aria-label="Pagination Navigation">
        <ul class="inline-flex items-center gap-1 rounded-md bg-bgWidget p-2 py-3  ">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="px-3 py-1 text-gray-400 cursor-not-allowed">
                    <x-heroicon-o-chevron-double-left class="size-4"/>
                </li>
            @else
                <li>
                    <button
                        wire:click="previousPage"
                        wire:loading.attr="disabled"
                        class="px-3 py-1 text-sm hover:bg-gray-200 rounded"
                    >
                        <x-heroicon-o-chevron-double-left class="size-4"/>
                    </button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-3 py-1 text-sm text-gray-400">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-3 py-1 text-sm bg-primary-300 text-white font-semibold rounded">{{ $page }}</li>
                        @else
                            <li>
                                <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 text-sm hover:bg-gray-200 rounded">{{ $page }}</button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button
                        wire:click="nextPage"
                        wire:loading.attr="disabled"
                        class="px-3 py-1 text-sm hover:bg-gray-200 rounded"
                    >
                        <x-heroicon-o-chevron-double-right class="size-4"/>
                    </button>
                </li>
            @else
                <li class="px-3 py-1 text-sm text-gray-400 cursor-not-allowed">
                    <x-heroicon-o-chevron-double-right class="size-4"/>
                </li>
            @endif
        </ul>
    </nav>
@endif
