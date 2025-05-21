
<section class="py-20 px-32 transform -translate-y-10 bg-white rounded-t-[46px]">
    <div class="flex justify-between items-center mb-12">
        <div>
            <h3 class="text-lg">
                {{count($rooms)}} Rooms Found
            </h3>
        </div>

        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3 px-4 py-2 bg-bgWidget rounded-full">
                <input
                    type="text"
                    class="border-none focus:ring-0 bg-transparent w-72 placeholder:text-font/40"
                    placeholder="Search Books"
                    wire:model.live="search"
                >
                <button type="button" class="p-2 rounded-full bg-white">
                    <x-heroicon-o-magnifying-glass class="size-6"/>
                </button>
            </div>


            <div class="relative inline-block text-left">
                <div  id="sortForm">
                    <select wire:model.live="sort" class="appearance-none capitalize first:text-lg pr-10  focus:outline-none focus:ring-0 border-none  cursor-pointer font-light ">
                        <option value="">Default</option>
                        @foreach($sortItems as $sort)
                            <option value="{{ $sort }}">{{ ucfirst($sort) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="flex gap-5">
        <div class="bg-bgWidget p-6 min-w-[25%] h-fit rounded-xl sticky top-12">
            <div>
                <h3 class="text-xl mb-3">Categories</h3>
                @foreach($categoryList as $i => $name)
                    <div class="py-2 flex gap-3 items-center">
                        <input
                            type="checkbox"
                            wire:model.live="categories"
                            value="{{ $name }}"
                            id="category_{{ $i }}"
                            class="peer size-5 cursor-pointer transition-all appearance-none rounded  border border-slate-300 checked:bg-primary-300 checked:border-primary-200  checked:hover:bg-primary-300 focus:bg-primary-100 checked:focus:bg-primary-100 "

                        >
                        <label for="category_{{ $i }}">{{ $name }}</label>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="grid grid-cols-1 w-full gap-y-6">
            @foreach($rooms as $room)
                <x-card.room-card :$room/>
{{--                <x-card.book-card :$book/>--}}
            @endforeach
        </div>

        {{--        {{ $books->links() }}--}}
    </div>
</section>
