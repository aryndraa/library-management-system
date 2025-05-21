@php
    $rooms = \App\Models\Room::query()
                ->where('library_id', session('library_id_session'))
                ->get()

 @endphp

@extends('layouts.app')

@section('content')
    <section
        class="min-h-[105vh] w-full flex items-end relative py-28    "
    >
        <div class="min-h-[105vh] lg:min-h-[105vh]  absolute inset-0 z-[-1]">
            <img
                src="https://images.unsplash.com/photo-1533090161767-e6ffed986c88?q=80&w=2938&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt=""
                class="h-[105vh] z-[-2] w-full absolute object-cover"
            >
            <div class="min-h-[105vh] lg:max-h-[105vh] absolute z-[-1] bg-gradient-to-b from-black/20 via-black/10 to-black/20 inset-0"></div>
        </div>

        <div class="mx-20 text-white">
            <h1 class="text-[80px] leading-[1.2] font-medium mb-12">Your gateway to <br> world of knowledge</h1>
            <div class="flex items-start gap-2 lg:gap-4 ">
                <hr class="w-8 lg:w-24 ">
                <div>
                    <p class="text-xl leading-[0] mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </p>
                    <p class="text-xl ">eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                </div>
            </div>
        </div>
    </section>
    <section class="px-32 py-24 rounded-t-[32px] transform -translate-y-8 bg-white">
        <div class="grid grid-cols-5 gap-16 place-items-center">
            <img src="{{ asset('images/logoipsum/Logo.svg') }}" alt="">
            <img src="{{ asset('images/logoipsum/Logo-1.svg') }}" alt="">
            <img src="{{ asset('images/logoipsum/Logo-2.svg') }}" alt="">
            <img src="{{ asset('images/logoipsum/Logo-3.svg') }}" alt="">
            <img src="{{ asset('images/logoipsum/Logo-4.svg') }}" alt="">
        </div>
    </section>

    <section class="px-32  pb-28">
        <div class="grid grid-cols-3 gap-8">
            <x-card.count-card total="{{ \App\Models\Category::all()->count() }}" name="Category"/>
            <x-card.count-card total="120" name="Book"/>
            <x-card.count-card total="122" name="Room"/>
        </div>
    </section>

    <section class="px-32  pb-28">
        <div class="grid grid-cols-2 gap-14 mb-16">
            <div>
                <h2 class="text-4xl leading-[1.6]">With thousands of books and digital access, we are committed to providing the <span class="text-primary-300"> best service for you.</span></h2>
            </div>
            <div class="h-full flex flex-col justify-between">
                <p class="">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
                <div class="flex gap-4">
                    <span class="text-sm px-3 py-1 border border-font/60 rounded-full">Digital</span>
                    <span class="text-sm px-3 py-1 border border-font/60 rounded-full">Innovative</span>
                    <span class="text-sm px-3 py-1 border border-font/60 rounded-full">Modern</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-4 min-h-[320px]">
            <div class="col-span-1 h-full flex flex-col justify-between p-6 bg-bgWidget rounded-xl">
                <h3 class="text-3xl leading-[1.4]">Find more categories</h3>
                <a href="{{ route('member.book.index') }}" class="flex gap-3 text-lg items-center">
                    View More
                    <x-heroicon-s-arrow-right class="size-5"/>
                </a>
            </div>
            <div class="col-span-3 flex overflow-x-scroll gap-8 px-4 scroll-x">
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

    <section class="px-32 pb-28">
        @livewire('book-overview')
    </section>

    <section class="px-32 pb-28">
        <div class="flex justify-between items-start mb-16">
            <div class="flex items-center gap-2 lg:gap-4 mb-2">
                <hr class="w-8 lg:w-12 ">
                <p class="text-xl leading-1 ">Innovation Space</p>
            </div>
            <h2 class="text-3xl leading-[1.6]">
                Not just a place to read, but a space to <br> grow <span class="text-primary-300">ideas and inspiration.</span>
            </h2>
        </div>
        <div class="grid grid-cols-4 gap-8">
            <div class="flex gap-8 overflow-x-scroll scroll-x col-span-3">
                @foreach($rooms as $room)
                    <div>
                        <img src="{{$room->getFirstMediaUrl('room')}}" alt="" class="h-[360px] object-cover min-w-[600px] rounded-xl mb-4">
                        <h3 class="text-xl">{{ $room->name }}</h3>
                    </div>
                @endforeach
            </div>
            <div class="col-span-1 h-full flex flex-col justify-between p-6 bg-bgWidget rounded-xl">
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

    <footer class=" pr-20 ">
        <div class="grid grid-cols-2 h-[340px]">
            <div class="col-span-1 flex flex-col justify-between px-20 py-12 bg-bgWidget h-full">
                <div>
                    <h1 class="text-4xl mb-2">Perpusku</h1>
                    <p class="text-font/60">Exclusive Library</p>
                </div>
                <div>
                    <p class="mb-3">Inspiration often begins quietly — between the pages of a book, in a single sentence, a new idea is born.</p>
                    <div class="flex items-center gap-2">
                        <hr class="w-6">
                        <p>Arya</p>
                    </div>
                </div>
            </div>
            <div class="col-span-1 grid grid-cols-2 px-12 py-12">
                <div>
                    <h3 class="mb-6 text-2xl">Useful Link</h3>
                    <div class="flex flex-col gap-4">
                        <a href="{{ route('member.home') }}" class="hover:underline">Home</a>
                        <a href="#" class="hover:underline">About Us</a>
                        <a href="{{ route('member.book.index') }}" class="hover:underline">Books</a>
                        <a href="{{ route('member.room.index') }}" class="hover:underline">Rooms</a>
                    </div>
                </div>
                <div>
                    <h3 class="mb-6 text-2xl">Profile Pages</h3>
                    <div class="flex flex-col gap-4">
                        <a href="{{ route('member.profile.userProfile') }}" class="hover:underline">Profile</a>
                        <a href="{{ route('member.profile.borrowedBooks') }}" class="hover:underline">Borrowed Books</a>
                        <a href="{{ route('member.profile.bookedRooms') }}" class="hover:underline">Booked Room</a>
                        <a href="{{ route('member.profile.accountSetting') }}" class="hover:underline">Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

@endsection
