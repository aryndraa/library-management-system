@props(['book'])

<a href="{{route('member.book.show',$book->id)}}" class="group h-full ">
    <div class="bg-bgWidget p-4 lg:py-5 rounded-xl mb-2 relative">
        <img
            src="{{$book->getFirstMediaUrl('book')}}"
            alt=""
            class="rounded-xl w-full h-[180px] lg:h-[240px] 2xl:h-[280px] shadow-md shadow-black/40 transform group-hover:-translate-y-4 group-hover:scale-105 transition ease-in-out duration-500"
        >
{{--        @if($book->created_at > )--}}
{{--            <span class="absolute font-normal bottom-5 -right-4 transform text-xs px-2 py-1 bg-yellow-400 text-red-600 -rotate-45">New Arrival</span>--}}
{{--        @endif--}}
    </div>
    <div class="px-1">
        <h3 class="w-[90%] mb-1 lg:mb-1.5 text-sm lg:text-[16px]">
            {{$book->title}}
        </h3>
        <p class="text-xs lg:text-sm text-font/60">
            {{$book->category->name ?? '-//-'}}
        </p>
    </div>
</a>
