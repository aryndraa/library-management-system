@php
    use App\Models\Category;$sortItems = [
        'newest',
        'oldest',
        'hots',
        'popular'
    ];

    $categories = Category::query()->get()->toArray();
@endphp

@extends('layouts.app')

@section('content')
    <section
        class="min-h-[70vh] w-full py-24 flex items-end  relative"
    >
        <div class="min-h-screen lg:max-h-[70vh] overflow-x-hidden  absolute inset-0 z-[-1]">
            <img
                src="https://images.unsplash.com/photo-1658526064786-63d6e3603215?q=80&w=3115&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt=""
                class="lg:max-h-[70vh] z-[-2] min-w-[150%] absolute object-cover "
            >
            <div
                class="lg:max-h-[70vh] absolute z-[-1] bg-gradient-to-b from-black/40 via-black/20 to-black/30 inset-0"></div>
        </div>

        <div class="mx-20 text-white">
            <div class="flex items-center gap-2 lg:gap-4 mb-2">
                <hr class="w-8 lg:w-12 ">
                <h2 class="text-sm lg:text-lg leading-1 ">Expand your mind</h2>
            </div>
            <h1 class="text-7xl leading-[1.2] font-medium">With thousands <br> of books</h1>
        </div>
    </section>

    @livewire('books')
@endsection
