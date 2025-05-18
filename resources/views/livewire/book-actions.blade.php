<div class="flex items-center gap-4">
    @if($isBorrowed)
        <a
            href="#"
            class="w-full bg-bgWidget text-lg p-3 rounded-lg h-full flex items-center justify-center gap-2"
        >
            Borrowed Detail
        </a>
    @else
        <div x-data="{ showModal: false, loading: false }" class="w-full h-full">
            <button
                @click="showModal = true"
                class="w-full bg-primary-300 text-white text-lg p-3 rounded-lg h-full flex items-center justify-center gap-2"
            >
                <svg x-show="loading" class="animate-spin h-5 w-5 text-font/60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span x-text="loading ? 'Loading...' : 'Borrow Book'"></span>
            </button>

            <div
                x-show="showModal"
                x-transition.opacity
                class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
            >
                <div
                    @click.away="showModal = false"
                    x-show="showModal"
                    x-transition.scale
                    x-transition:enter.duration.300ms
                    class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl"
                >
                    <h2 class="text-xl font-semibold mb-4">Confirm Borrow</h2>
                    <p class="mb-6">Are you sure you want to borrow <strong>{{ $book->title }}</strong>?</p>
                    <div class="flex justify-end gap-4">
                        <button @click="showModal = false" class="px-4 py-2 bg-gray-200 rounded-lg">
                            Cancel
                        </button>
                        <button
                            x-on:click="
                            loading = true;
                            $wire.borrowBook().then(() => {
                                loading = false;
                                showModal = false;
                            });
                        "
                            class="px-4 py-2 bg-primary-300 text-white rounded-lg"
                        >
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <button wire:click="toggleLike" class="rounded-full p-4 bg-bgWidget">
            <x-heroicon-s-heart class="size-7  transform transition ease-in-out duration-300 {{
                 $isLiked ? 'text-red-500 scale-125' : 'text-font/60'
            }}"/>
    </button>
</div>
