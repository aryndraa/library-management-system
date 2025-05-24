@php
    $rooms = \App\Models\Room::query()
                ->where('library_id', session('library_id_session'))
                ->get()

 @endphp

@extends('layouts.app')

@section('content')
    <section
        class="min-h-[98vh] lg:min-h-[105vh] 2xl:min-h-[80vh] w-full flex items-start lg:items-end relative py-28    "
    >
        <div class="min-h-[98vh] lg:min-h-[105vh]  2xl:min-h-[84vh]  absolute inset-0 z-[-1]">
            <img
                src="https://images.unsplash.com/photo-1533090161767-e6ffed986c88?q=80&w=2938&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt=""
                class="h-[105vh]  z-[-2] w-full absolute object-cover object-right lg:object-center 2xl:object-bottom "
            >
            <div class="min-h-[98vh] lg:max-h-[105vh] 2xl:min-h-[84vh] absolute z-[-1] bg-gradient-to-b from-black/40 via-black/10 to-black/40 inset-0"></div>
        </div>

        <div class="mx-5 lg:mx-20 2xl:mx-80 text-white">
            <h1 class="text-5xl lg:text-[80px] 2xl:text-8xl leading-[1.2] lg:leading-[1.2] 2xl:leading-[1.4] font-medium mb-4 lg:mb-12 2xl:mb-10">Your gateway to <br class="hidden lg:block"> world of knowledge</h1>
            <div class="flex items-start gap-2 lg:gap-4 ">
                <hr class="w-8 lg:w-24 hidden lg:block">
                <div>
                    <p class="text-base lg:text-xl lg:leading-[0] lg:mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do <span class=" lg:hidden">eiusmod tempor incididunt ut labore et dolore magna aliqua</span> </p>
                    <p class="hidden lg:block text-sm lg:text-xl ">eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                </div>
            </div>
        </div>
    </section>

    <section class="px-5 lg:px-32 2xl:px-80 py-16 lg:py-24 lg:rounded-t-[32px] transform lg:-translate-y-8 2xl:-translate-y-0 bg-white">
        <div class="flex flex-wrap justify-center  lg:grid lg:grid-cols-5 gap-12 lg:gap-16 place-items-center">
            <img src="{{ asset('images/logoipsum/Logo.svg') }}"   alt="" class="w-32 lg:w-40">
            <img src="{{ asset('images/logoipsum/Logo-1.svg') }}" alt="" class="w-32 lg:w-40">
            <img src="{{ asset('images/logoipsum/Logo-2.svg') }}" alt="" class="w-32 lg:w-40">
            <img src="{{ asset('images/logoipsum/Logo-3.svg') }}" alt="" class="w-32 lg:w-40">
            <img src="{{ asset('images/logoipsum/Logo-4.svg') }}" alt="" class="w-32 lg:w-40 hidden lg:block">
        </div>
    </section>

    <section class="px-5 lg:px-32 2xl:px-80 pb-16 lg:pb-28">
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 lg:gap-8">
            <x-card.count-card total="{{ \App\Models\Category::all()->count() }}" name="Category"/>
            <x-card.count-card total="120" name="Book"/>
            <x-card.count-card total="122" name="Room"/>
        </div>
    </section>

    <section class="px-5 lg:px-32 2xl:px-80 pb-16 lg:pb-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-14 mb-8 lg:mb-16">
            <div>
                <h2 class="text-xl lg:text-4xl lg:leading-[1.6]">With thousands of books and digital access, we are committed to providing the <span class="text-primary-300"> best service for you.</span></h2>
            </div>
            <div class="h-full flex flex-col gap-5 justify-between">
                <p class="text-xs lg:text-base hidden lg:block ">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
                <div class="flex gap-2 lg:gap-4">
                    <span class="text-xs lg:text-sm px-3 py-1 border border-font/60 rounded-full">Digital</span>
                    <span class="text-xs lg:text-sm px-3 py-1 border border-font/60 rounded-full">Innovative</span>
                    <span class="text-xs lg:text-sm px-3 py-1 border border-font/60 rounded-full">Modern</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-4 min-h-[260px] lg:min-h-[320px]">
            <div class="col-span-1 h-full hidden lg:flex flex-col justify-between p-6 bg-bgWidget rounded-xl">
                <h3 class="text-3xl leading-[1.4]">Find more categories</h3>
                <a href="{{ route('member.book.index') }}" class="flex gap-3 text-lg items-center">
                    View More
                    <x-heroicon-s-arrow-right class="size-5"/>
                </a>
            </div>
            <div class="col-span-full lg:col-span-3 flex overflow-x-scroll gap-4 lg:gap-8 scroll-x rounded-xl">
                @foreach(\App\Models\Category::all() as  $category)
                    <div
                        style="background-image: url('{{ $category->getFirstMediaUrl('category') }}')"
                        class="min-w-[280px] bg-cover rounded-xl bg-blend-overlay bg-black/20 p-6 py-4 flex flex-col justify-end"
                    >
                        <h3 class="text-lg text-white font-normal">{{ $category->name }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-5 lg:px-32 2xl:px-80 pb-16 lg:pb-28">
        @livewire('book-overview')
    </section>

    <section class="px-5 lg:px-32 2xl:px-80 pb-16 lg:pb-32">
        <div class="flex flex-col lg:flex-row justify-between items-start mb-8 lg:mb-16">
            <div class="flex items-center gap-2 lg:gap-4 mb-2">
                <hr class="w-8 lg:w-12 ">
                <p class="text-base lg:text-xl leading-1 text-font/60 ">Innovation Space</p>
            </div>
            <h2 class="text-xl lg:text-3xl leading-[1.6]">
                Not just a place to read, but a space to <br class="hidden"> grow <span class="text-primary-300">ideas and inspiration.</span>
            </h2>
        </div>

        <div class="grid grid-cols-4 gap-4 lg:gap-8 ">
            <div class="flex gap-4 lg:gap-8 overflow-x-scroll scroll-x col-span-4 lg:col-span-3 rounded-l-xl">
                @foreach($rooms as $room)
                    <div>
                        <img src="{{$room->getFirstMediaUrl('room')}}" alt="" class="h-[240px] lg:h-[360px] object-cover min-w-[320px] lg:min-w-[600px] rounded-xl mb-2 lg:mb-4">
                        <h3 class="text-base lg:text-xl">{{ $room->name }}</h3>
                    </div>
                @endforeach
            </div>
            <div class="col-span-1  h-full hidden lg:flex flex-col justify-between p-6 bg-bgWidget rounded-xl">
                <a href="{{ route('member.room.index') }}" class="flex gap-3 text-lg items-center">
                    View More
                    <x-heroicon-s-arrow-right class="size-5"/>
                </a>
                <div>
                    <h3 class="text-2xl leading-[1.4]">{{$rooms->count()}}+ Rooms </h3>
                    <p class="to-font/60">Ready To Booking</p>
                </div>
            </div>
        </div>
    </section>

   <x-footer/>

@endsection
