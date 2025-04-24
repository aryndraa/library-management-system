<x-filament-widgets::widget>
    <x-filament::section>
        <div >
            @if ($libraryInfo = $this->getLibraryInfo())
                <div>
                    <div class="mb-4 pb-4 border-b flex items-center justify-between">
                        <h1 class="font-semibold">Library</h1>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold mb-1.5">{{ $libraryInfo->name }}</h2>
                            <p>{{ $libraryInfo->address }}</p>
                        </div>
                        {{$this->getActions()}}
                    </div>
                </div>

            @else
                <p class="text-red-500">Library not found.</p>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
