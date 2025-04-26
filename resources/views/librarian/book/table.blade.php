<td class="px-4 py-2 border-gray-600">
    <div class="flex  items-center gap-4">
        {{-- Cover --}}
        @if ($getRecord()->getFirstMediaUrl('book'))
            <img
                src="{{ $getRecord()->getFirstMediaUrl('book') }}"
                alt="Cover"
                class="w-full h-64 object-cover rounded"
            />
        @else
            <div class="w-20 h-28 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">
                No Cover
            </div>
        @endif

        {{-- Text Info --}}
        <div class="flex flex-col justify-center">
            <div class="text-sm text-gray-500">ISBN: {{ $getRecord()->isbn }}</div>

            <div class="text-[52px] font-bold capitalize leading-tight">
                {{ Str::limit($getRecord()->title, 30) }}
            </div>

            <div class="text-sm text-gray-600">
                {{ $getRecord()->category?->name }}
            </div>

            <div class="text-sm text-gray-500">
                Published: {{ \Carbon\Carbon::parse($getRecord()->publication_date)->format('d M Y') }}
            </div>

            <div class="text-sm text-gray-500">
                Stock: {{ $getRecord()->stock }}
            </div>
        </div>
    </div>
</td>

