<x-filament-widgets::widget>
    <x-filament::section>
        <div >
            @if ($libraryInfo = $this->getLibraryInfo())
                <div>
                    <h1 class="font-semibold mb-4 pb-4 border-b">Library</h1>
                    <h2 class="text-lg font-bold">{{ $libraryInfo->name }}</h2>
                    <p>{{ $libraryInfo->address }}</p>
                </div>

            @else
                <p class="text-red-500">Library not found.</p>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
