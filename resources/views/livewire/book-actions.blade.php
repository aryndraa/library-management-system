<div class="flex gap-4">
    <button class="w-full bg-bgWidget text-lg    p-3 rounded-lg ">
        Borrow Book
    </button>
    <button wire:click="toggleLike" class="rounded-full p-4 bg-bgWidget">

            <x-heroicon-s-heart class="size-7  transform transition ease-in-out duration-300 {{
                 $isLiked ? 'text-red-500 scale-125' : 'text-font/60'
            }}"/>
    </button>
</div>
