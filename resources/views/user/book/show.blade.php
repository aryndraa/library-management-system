@extends('layouts.show', ['routeDirect' => 'member.book.index'])

@section('content')
    <section class="grid grid-cols-2 gap-5">
        <div>
            <div class="flex gap-4 text-lg text-font/60 mb-10">
                <a href="#" class="pb-2.5 pr-4 text-font border-b">About</a>
                <a href="#" class="pb-2.5 pr-4 ">{{$book->count_comments ?? 0}} Comments</a>
            </div>

            <div>
                <div class="mb-10">
                    <div class="mb-3">
                        <h1 class="text-3xl mb-3">{{$book->title}}</h1>
                        <h2 class="text-lg text-font/60">{{$book->isbn}}</h2>
                    </div>
                    <div class="flex text-base  ">
                        <p class="pr-8">{{$book->category->name}}</p>
                        <p class="px-8 border-x">{{$book->count_likes ?? 0}} Likes</p>
                        <p class="pl-8">{{$book->borrowings_likes ?? 0}} Borrowed</p>
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
        </div>
    </section>
@endsection
