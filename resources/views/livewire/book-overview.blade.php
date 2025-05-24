<div>
    <div class="flex flex-col gap-6 lg:gap-8 lg:flex-row justify-between lg:items-end mb-8 lg:mb-16">
        <div>
            <span class="text-font/60 text-base lg:text-xl">Enjoy book lending</span>
            <h2 class="text-xl lg:text-3xl mt-1 lg:mt-3">Thousands of titles available</h2>
        </div>
        <div class="flex overflow-x-scroll gap-4 lg:gap-6 text-lg">
            <button wire:click="setFilter('new')" class="text-base min-w-32 lg:min-w-fit pb-3 border-b {{ $filter === 'new' ? 'border-b-font/60' : 'border-b-transparent' }}">New Arrival</button>
            <button wire:click="setFilter('popular')" class="text-base min-w-32 lg:min-w-fit pb-3 border-b {{ $filter === 'popular' ? 'border-b-font/60' : 'border-b-transparent' }}">Populars</button>
            <button wire:click="setFilter('recommended')" class="text-base min-w-32 lg:min-w-fit pb-3 border-b {{ $filter === 'recommended' ? 'border-b-font/60' : 'border-b-transparent' }}">Recommended</button>
            <a href="{{ route('member.book.index') }}" class="flex justify-center text-base min-w-32 lg:min-w-fit pb-3 gap-3 items-center">
                View More
                <x-heroicon-s-arrow-right class="size-4"/>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8 min-h-[280px] mt-6">
        @foreach($this->books as $book)
            <a href="{{route('member.book.show',$book->id)}}" class="group h-full ">
                <div class="bg-bgWidget p-5 lg:p-8  rounded-xl mb-2">
                    <img
                        src="{{$book->getFirstMediaUrl('book')}}"
                        alt=""
                        class="rounded-xl w-full h-[200px] lg:h-[299px] shadow-md shadow-black/40 transform group-hover:-translate-y-4 group-hover:scale-105 transition ease-in-out duration-500"
                    >
                </div>
                <div class="px-1">
                    <h3 class="w-[90%] mb-1 text-sm lg:text-lg">
                        {{$book->title}}
                    </h3>
                    <p class="text-xs lg:text-sm text-font/60">
                        {{$book->category->name ?? '-//-'}}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
