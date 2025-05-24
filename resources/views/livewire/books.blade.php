@php
    use App\Models\Category;

    $sortItems = [
        'newest',
        'oldest',
        'hots',
        'popular'
    ];
@endphp


<div  x-data="{ showFilter: false }">
    <div class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-50 md:hidden">
        <button
            @click="showFilter = true"
            class="bg-primary-300 text-white px-5 py-2 rounded-xl shadow-lg flex gap-3 items-center"
        >
            <x-heroicon-o-funnel class="size-4"/>
            Filter
        </button>
    </div>

    <div
        x-show="showFilter"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-y-0"
        x-transition:leave-end="translate-y-full"
        class="fixed bottom-0 left-0 w-full bg-white z-50 p-6 rounded-t-xl md:hidden"
        style="display: none;"
    >
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Filter</h3>
            <button @click="showFilter = false" class="text-gray-600">Close</button>
        </div>

        <!-- Isi filter kategori -->
        <div>
            <h3 class="text-xl mb-3">Categories</h3>
            <div class="transition overflow-y-scroll max-h-[70vh]">
                @foreach($this->visibleCategories as $i => $name)
                    <div class="py-2 flex gap-3 items-center">
                        <input
                            type="checkbox"
                            wire:model.live="categories"
                            value="{{ $name }}"
                            id="mobile_category_{{ $i }}"
                            class="peer size-5 cursor-pointer transition-all appearance-none rounded  border border-slate-300 checked:bg-primary-300 checked:border-primary-200  checked:hover:bg-primary-300 focus:bg-primary-100 checked:focus:bg-primary-100 "
                        >
                        <label for="mobile_category_{{ $i }}">{{ $name }}</label>
                    </div>
                @endforeach
            </div>

            <button
                class="mt-4 flex justify-end w-full text-font/60"
                wire:click="$toggle('expanded')"
            >
                {{ $expanded ? 'Show less' : 'Show more' }}
            </button>
        </div>
    </div>

    <div
        x-show="showFilter"
        class="fixed inset-0 bg-black/40 z-40"
    >

    </div>

    <section class="py-8 lg:py-20 px-5 lg:px-32 lg:transform -translate-y-10 bg-white rounded-t-xl lg:rounded-t-[46px]">

        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 lg:mb-12 gap-2 lg:gap-4">
            <div class="flex justify-between items-center w-full ">
                <h3 class="lg:text-lg">
                    {{count($books)}} Books Found
                </h3>
                <div class="relative inline-block text-left lg:hidden">
                    <div  id="sortForm">
                        <select wire:model.live="sort" class="text-sm lg:text-base appearance-none capitalize first:text-lg pr-10  focus:outline-none focus:ring-0 border-none  cursor-pointer font-light ">
                            <option class="text-sm lg:text-base" value="">Default</option>
                            @foreach($sortItems as $sort)
                                <option class="text-sm lg:text-base" value="{{ $sort }}">{{ ucfirst($sort) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row w-full items-end lg:items-center gap-2 lg:gap-6">
                <div class="flex items-center gap-3 px-4 py-2 bg-bgWidget rounded-xl lg:rounded-full w-full">
                    <input
                        type="text"
                        class="border-none focus:ring-0 bg-transparent w-full lg:w-72 placeholder:text-font/40"
                        placeholder="Search Books"
                        wire:model.live="search"
                    >
                    <button type="button" class="p-2 rounded-full bg-white">
                        <x-heroicon-o-magnifying-glass class="size-6"/>
                    </button>
                </div>


                <div class="relative text-left hidden lg:inline-block">
                    <div  id="sortForm">
                        <select wire:model.live="sort" class="text-sm lg:text-base appearance-none capitalize first:text-lg pr-10  focus:outline-none focus:ring-0 border-none  cursor-pointer font-light ">
                            <option class="text-sm lg:text-base" value="">Default</option>
                            @foreach($sortItems as $sort)
                                <option class="text-sm lg:text-base" value="{{ $sort }}">{{ ucfirst($sort) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-5 ">

            <div class="bg-bgWidget p-6 min-w-[25%] h-fit rounded-xl hidden ">
                <div>
                    <h3 class="text-xl mb-3">Categories</h3>
                    <div class="transition">
                        @foreach($this->visibleCategories as $i => $name)
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

                    <button
                        class="mt-4 flex justify-end w-full text-font/60"
                        wire:click="$toggle('expanded')"
                    >
                        {{ $expanded ? 'Show less' : 'Show more' }}
                    </button>
                </div>
            </div>


            <div>
                 <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-y-6">
                     @foreach($books as $book)
                         <x-card.book-card :$book/>
                     @endforeach
                 </div>

                 <div class="flex justify-end">
                     {{ $books->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
                 </div>
            </div>

        </div>
    </section>
</div>
