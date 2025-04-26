<x-filament-panels::page>
    <div>
        <form wire:submit.prevent="searchBorrowedBook" class="space-y-4">
            {{ $this->form }}

            <x-filament::button type="submit" color="primary">
                Get Receipt
            </x-filament::button>
        </form>
        <div>

        </div>
    </div>

    @if ($borrowedBook)
        <div class="mt-8 p-6 bg-white shadow rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Borrowing Receipt</h2>
            <p><strong>Code:</strong> {{ $borrowedBook->code }}</p>
            <p><strong>Book:</strong> {{ $borrowedBook->book->title ?? '-' }}</p>
            <p><strong>Borrower:</strong> {{ $borrowedBook->member->name ?? '-' }}</p>
            <p><strong>Library:</strong> {{ $borrowedBook->library->name ?? '-' }}</p>
            <p><strong>Borrowed Date:</strong> {{ \Carbon\Carbon::parse($borrowedBook->borrowed_date)->format('d M Y') }}</p>
            <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($borrowedBook->due_date)->format('d M Y') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($borrowedBook->status) }}</p>
            @if ($borrowedBook->returned_date)
                <p><strong>Returned Date:</strong> {{ \Carbon\Carbon::parse($borrowedBook->returned_date)->format('d M Y') }}</p>
            @endif
        </div>
    @endif
</x-filament-panels::page>
