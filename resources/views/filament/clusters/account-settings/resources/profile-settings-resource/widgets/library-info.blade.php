<x-filament-widgets::widget>
    <x-filament::section>
        <div class="p-4 bg-white rounded-lg shadow">
            @if ($libraryInfo = $this->getLibraryInfo())
                <h2 class="text-lg font-bold">{{ $libraryInfo->name }}</h2>
                <p><strong>Address:</strong> {{ $libraryInfo->address }}</p>
                <p><strong>Phone:</strong> {{ $libraryInfo->phone }}</p>
                <p><strong>Email:</strong> {{ $libraryInfo->email }}</p>
                <p><strong>Description:</strong> {{ $libraryInfo->description }}</p>
            @else
                <p class="text-red-500">Library not found.</p>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
