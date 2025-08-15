@php use Illuminate\Support\Facades\Auth; @endphp
<section class="flex flex-col-reverse lg:flex-row gap-6 lg:gap-16" wire:poll.5>
    <div class="w-full lg:w-[46%]">
        <div class="flex gap-2 lg:gap-4 text-base lg:text-lg text-font/60 mb-4 lg:mb-10">
            <button wire:click="toggleComment(false)"
                    class="pb-1 lg:pb-2.5 pr-4 {{!$openComment ? 'text-primary-300 border-b border-primary-300' : ''}} "
            >
                About
            </button>
            <button wire:click="toggleComment(true)"
                    class="pb-1 lg:pb-2.5 pr-4 {{$openComment ? 'text-primary-300 border-b border-primary-300' : ''}}"
            >
                {{$book->bookComments->count()}} Comments
            </button>
        </div>

        @if(!$openComment)
            <div>
                <div class="mb-6 lg:mb-10">
                    <div class="mb-6 lg:mb-3">
                        <h1 class="text-xl lg:text-3xl mb-1 lg:mb-3">{{$book->title}}</h1>
                        <h2 class="text-sm lg:text-lg text-font/60">{{$book->isbn}}</h2>
                    </div>
                    <div class="flex justify-between text-sm lg:text-base">
                        <p class="pr-8">{{$book->category->name ?? '-///-'}}</p>
                        <p class="px-8 border-x">{{$book->likes->count()}} Likes</p>
                        <p class="pl-8">{{$book->borrowings->count() }} Borrowed</p>
                    </div>
                </div>
                <div>
                    <div class="mb-6 lg:mb-10">
                        <h3 class="text-sm lg:text-base text-font/60 mb-1 lg:mb-2">About</h3>
                        <div x-data="{ expanded: false }" class="text-justify text-sm lg:text-base">
                            <p class="leading-[1.6]">
                                <span x-show="!expanded" x-text="'{{ Str::limit($book->synopsis, 200) }}'"></span>
                                <span x-show="expanded" x-text="'{{ $book->synopsis }}'"></span>
                                <button @click="expanded = !expanded" class="text-font font-normal underline ml-1 lg:ml-2"
                                        x-text="expanded ? 'Read less' : 'Read more'"></button>
                            </p>
                        </div>
                    </div>
                    <div class="mb-32 lg:mb-0">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-font/60 mb-1 lg:mb-2 text-sm lg:text-base">Publication Date</h3>
                                <p class="text-sm lg:text-base">{{$book->publication_date}}</p>
                            </div>
                            <div>
                                <h3 class="text-font/60 mb-1 lg:mb-2 text-sm lg:text-base">Author</h3>
                                <p class="text-sm lg:text-base">{{$book->author}}</p>
                            </div>
                            <div>
                                <h3 class="text-font/60 mb-1 lg:mb-2 text-sm lg:text-base">Publisher</h3>
                                <p class="text-sm lg:text-base">{{$book->publisher}}</p>
                            </div>
                            <div>
                                <h3 class="text-font/60 mb-1 lg:mb-2 text-sm lg:text-base">Stock</h3>
                                <p class="text-sm lg:text-base">{{$book->stock}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="min-h-[57vh] max-h-[57vh] flex flex-col justify-between ">
                <div class="w-full flex flex-col overflow-y-scroll scroll-y  ">
                    @foreach($bookComments as $comment)
                        <div class="w-full  py-6 border-t border-font/20 first:pt-0 first:border-t-0">
                            <div class="flex justify-between mb-3">
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
                                <div class="flex gap-4 items-center">
                                    <span class="text-font/60">
                                        {{ $comment->created_at->diffForHumans(now(), true) }} ago
                                    </span>
                                    @if($comment->member_id === Auth::id())
                                        <div class="relative" wire:poll.0>
                                            <span wire:click="toggleCommentMenu({{ $comment->id }})" class="cursor-pointer">
                                                <x-heroicon-s-ellipsis-vertical class="size-6 text-font/60"/>
                                            </span>
                                            @if($activeCommentMenu === $comment->id)
                                                <div class="flex flex-col gap-4 items-start absolute -bottom-14 -left-52 p-3 w-52 bg-white shadow">

                                                    @if(\Carbon\Carbon::parse($book->status)->addMinutes(5)->isPast())
                                                        <button class="text-font/60" wire:click="startEditing({{ $comment->id }})">
                                                            Edit
                                                        </button>
                                                    @endif
                                                    <button class="text-red-300" wire:click="deleteComment({{ $comment->id }})">
                                                        Delete
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if($editingCommentId === $comment->id)
                                <form wire:submit.prevent="updateComment" class="flex flex-col gap-2 mt-2">
                                     <textarea wire:model.defer="editingMessage"
                                               class="w-full border px-4 rounded-lg py-1 text-sm resize-none focus:ring-0 border-none bg-bgWidget"
                                               rows="3"></textarea>
                                    <div class="flex gap-2">
                                        <button type="submit" class="text-primary-300">Simpan</button>
                                        <button type="button" wire:click="$set('editingCommentId', null)" class="text-gray-500">Batal</button>
                                    </div>
                                </form>
                            @else
                                <p class="text-sm text-font/60 ">
                                    {{ $comment->message }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <form wire:submit="sendComment" class="bg-bgWidget p-2 lg:p-4 rounded-lg flex flex-col mb-10">
                    <textarea
                        class="bg-transparent border-none focus:ring-0 w-full min-h-24 lg:min-h-12 lg:max-h-12 scroll-y mb-4 placeholder:text-font/60"
                        placeholder="Write a Comment...."
                        required
                        wire:model="message"
                    ></textarea>
                    <button class="flex items-center justify-end gap-1 text-font/60 text-base lg:text-lg ">
                        Send
                        <x-heroicon-o-chevron-right class="size-5"/>
                    </button>
                </form>
            </div>
        @endif


    </div>
    <div class="grid grid-cols-4 gap-4 w-full lg:w-[50%]">
        <div class="col-span-full lg:col-span-3 ">
            <div class="bg-bgWidget p-20 py-10 lg:p-20 lg:py-12  rounded-xl mb-4">
                <img
                    src="{{$book->getFirstMediaUrl('book')}}"
                    alt=""
                    class="rounded-xl w-full h-[280px] lg:h-[360px]  shadow-md object-cover shadow-black/40 "
                >
            </div>
            @livewire('book-actions', ['book' => $book])
        </div>

        <div class="hidden lg:block max-h-[64vh]">
            <h3 class="text-center text-lg pb-4">More Book</h3>
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
