<div class="flex items-center gap-4 fixed lg:relative left-0 right-0 bottom-0 py-3 px-5 lg:p-0  bg-white shadow-[12px_12px_12px_5px] lg:shadow-none">

    @if($isBorrowed)
        <a
            href="{{ route('member.profile.borrowedBooks') }}"
            class="w-full bg-bgWidget lg:text-lg p-3 rounded-lg h-full flex items-center justify-center gap-2"
        >
            Borrowed Detail
        </a>
    @else
        @if($book->stock > 0)
            <div x-data="{ showModal: false, loading: false }" class="w-full h-full",>
            <button
                @click="showModal = true"
                class="w-full bg-primary-300 text-white lg:text-lg p-3 rounded-lg h-full flex items-center justify-center gap-2"
            >
                <svg x-show="loading" class="animate-spin h-5 w-5 text-font/60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span x-text="loading ? 'Loading...' : 'Borrow Book'"></span>
            </button>
            <div
                x-show="showModal"
                x-cloak
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
        @else
            <div
                class="w-full bg-bgWidget text-lg p-3 rounded-lg h-full flex items-center justify-center gap-2 cursor-not-allowed"
            >
                Book Is Empty
            </div>
        @endif
    @endif


    <button wire:click="toggleLike" class="rounded-full p-4 bg-bgWidget">
            <x-heroicon-s-heart class="size-6 lg:size-7  transform transition ease-in-out duration-300 {{
                 $isLiked ? 'text-red-500 scale-125' : 'text-font/60'
            }}"/>
    </button>
</div>
