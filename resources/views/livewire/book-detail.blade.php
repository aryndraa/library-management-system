<section class="flex gap-16" wire:poll.5>
    <div class="w-[46%]">
        <div class="flex gap-4 text-lg text-font/60 mb-10">
            <button wire:click="toggleComment(false)" class="pb-2.5 pr-4 text-primary-300 border-b border-primary-300">About</button>
            <button wire:click="toggleComment(true)" class="pb-2.5 pr-4 ">{{$book->bookComments->count()}} Comments</button>
        </div>

        @if(!$openComment)
            <div>
                <div class="mb-10">
                    <div class="mb-3">
                        <h1 class="text-3xl mb-3">{{$book->title}}</h1>
                        <h2 class="text-lg text-font/60">{{$book->isbn}}</h2>
                    </div>
                    <div class="flex text-base  ">
                        <p class="pr-8">{{$book->category->name}}</p>
                        <p class="px-8 border-x">{{$book->likes->count()}} Likes</p>
                        <p class="pl-8">{{$book->borrowings->count() }} Borrowed</p>
                    </div>
                </div>
                <div>
                    <div class="mb-10">
                        <h3 class="text-font/60 mb-2">About</h3>
                        <div x-data="{ expanded: false }" class="text-base">
                            <p class="leading-[1.6]">
                                <span x-show="!expanded" x-text="'{{ Str::limit($book->synopsis, 200) }}'"></span>
                                <span x-show="expanded" x-text="'{{ $book->synopsis }}'"></span>
                                <button @click="expanded = !expanded" class="text-font font-normal underline ml-2" x-text="expanded ? 'Read less' : 'Read more'"></button>
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-font/60 mb-2">Publication Date</h3>
                                <p>{{$book->publication_date}}</p>
                            </div>
                            <div>
                                <h3 class="text-font/60 mb-2">Author</h3>
                                <p>{{$book->author}}</p>
                            </div>
                            <div>
                                <h3 class="text-font/60 mb-2">Publisher</h3>
                                <p>{{$book->publisher}}</p>
                            </div>
                            <div>
                                <h3 class="text-font/60 mb-2">Stock</h3>
                                <p>{{$book->stock}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div>
                <div class="w-full flex flex-col mb-4">
                    @foreach($bookComments as $comment)
                            <div class="w-full px-4 py-4 border-t first:pt-0 first:border-t-0">
                                <div class="flex justify-between mb-1.5">
                                    <div class="flex gap-4 items-center">
                                        <div class="size-8">
                                            @if($comment->member->profile->photoProfile->file_url)
                                                <img
                                                    src="{{$comment->member->profile->photoProfile->file_url}}"
                                                    alt=""
                                                    class="rounded-full"
                                                >
                                            @else
                                                <div class="size-full bg-primary-300 text-white ">
                                                    <x-heroicon-s-user/>
                                                </div>
                                            @endif
                                        </div>
                                        <h3 class="text-lg">
                                            {{$comment->member->profile->first_name}} {{$comment->member->profile->last_name}}
                                        </h3>
                                    </div>
                                    <span class="text-font/60">
                                         {{ $comment->created_at->diffForHumans(now(), true) }} ago
                                    </span>
                                </div>
                                <p class="text-sm text-font/60">
                                    {{$comment->message}}
                                </p>
                            </div>
                    @endforeach
                </div>

                <div class="bg-bgWidget p-4 rounded-lg flex flex-col">
                    <textarea
                        class="bg-transparent border-none focus:ring-0 w-full min-h-32 max-h-32 scroll-y mb-4 placeholder:text-font/60"
                        placeholder="Write a Comment...."
                    ></textarea>
                    <button class="flex items-center justify-end gap-1 text-font/60 text-lg ">
                        Send
                        <x-heroicon-o-chevron-right class="size-5"/>
                    </button>
                </div>
            </div>
        @endif


    </div>
    <div class="grid grid-cols-4 gap-4 w-[50%]">
        <div class="col-span-3 ">
            <div class="bg-bgWidget p-20 py-12  rounded-xl mb-4">
                <img
                    src="{{$book->getFirstMediaUrl('book')}}"
                    alt=""
                    class="rounded-xl w-full h-[360px]  shadow-md object-cover shadow-black/40 "
                >
            </div>
            @livewire('book-actions', ['book' => $book])
        </div>

        <div class="max-h-[64vh]">
            <h3 class="text-center text-lg pb-4">More  Book</h3>
            <div class="h-full overflow-y-scroll scroll-y">
                @foreach($randomBooks as $book)
                    <div class="bg-bgWidget p-4 py-5 rounded-xl mb-2">
                        <img
                            src="{{$book->getFirstMediaUrl('book')}}"
                            alt=""
                            class="rounded-xl w-full h-[140px] shadow-md shadow-black/40 transform group-hover:-translate-y-4 group-hover:scale-105 transition ease-in-out duration-500"
                        >
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
