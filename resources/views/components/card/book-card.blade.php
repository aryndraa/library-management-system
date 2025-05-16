@props(['book'])

<a href="{{$book->id}}" class="group ">
    <div class="bg-bgWidget p-4 py-5 rounded-xl mb-2">
        <img
            src="{{$book->getFirstMediaUrl('book')}}"
            alt=""
            class="rounded-xl w-full h-[240px] shadow-md shadow-black/40 transform group-hover:-translate-y-4 group-hover:scale-105 transition ease-in-out duration-500"
        >
    </div>
    <div class="px-1">
        <h3 class="w-[90%] mb-2 text-[16px]">
            {{$book->title}}
        </h3>
        <p class="text-sm text-font/60">
            {{$book->category->name}}
        </p>
    </div>
</a>
