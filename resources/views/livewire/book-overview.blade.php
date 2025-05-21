<div>
    <div class="flex justify-between items-end mb-16">
        <div>
            <span class="text-font/60 text-xl">Enjoy book lending</span>
            <h2 class="text-3xl mt-3">Thousands of titles available</h2>
        </div>
        <div class="flex gap-4 text-lg">
            <button wire:click="setFilter('new')" class="pb-3 border-b {{ $filter === 'new' ? 'border-b-font/60' : 'border-b-transparent' }}">New Arrival</button>
            <button wire:click="setFilter('popular')" class="pb-3 border-b {{ $filter === 'popular' ? 'border-b-font/60' : 'border-b-transparent' }}">Populars</button>
            <button wire:click="setFilter('recommended')" class="pb-3 border-b {{ $filter === 'recommended' ? 'border-b-font/60' : 'border-b-transparent' }}">Recommended</button>
            <a href="{{ route('member.book.index') }}" class="flex pb-3 gap-3 items-center">
                View More
                <x-heroicon-s-arrow-right class="size-4"/>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-8 min-h-[280px] mt-6">
        @foreach($this->books as $book)
            <a href="{{route('member.book.show',$book->id)}}" class="group h-full ">
                <div class="bg-bgWidget p-8  rounded-xl mb-2">
                    <img
                        src="{{$book->getFirstMediaUrl('book')}}"
                        alt=""
                        class="rounded-xl w-full h-[299px] shadow-md shadow-black/40 transform group-hover:-translate-y-4 group-hover:scale-105 transition ease-in-out duration-500"
                    >
                </div>
                <div class="px-1">
                    <h3 class="w-[90%] mb-1 text-lg">
                        {{$book->title}}
                    </h3>
                    <p class="text-sm text-font/60">
                        {{$book->category->name ?? '-//-'}}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
