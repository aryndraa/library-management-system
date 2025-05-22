@php

@endphp

@extends('layouts.app')

@section('content')
    <section
        class="min-h-[70vh] w-full py-24 flex items-end  relative"
    >
        <div class="min-h-screen lg:max-h-[70vh] overflow-x-hidden  absolute inset-0 z-[-1]">
            <img
                src="https://images.unsplash.com/photo-1646592491616-bcc3913ef52a?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt=""
                class="lg:max-h-[70vh] z-[-2] min-w-[150%] absolute object-cover "
            >
            <div
                class="lg:max-h-[70vh] absolute z-[-1] bg-gradient-to-b from-black/40 via-black/20 to-black/30 inset-0"></div>
        </div>

        <div class="mx-20 text-white">
            <div class="flex items-center gap-2 lg:gap-4 mb-2">
                <hr class="w-8 lg:w-12 ">
                <h2 class="text-sm lg:text-lg leading-1 ">Space to Focus</h2>
            </div>
            <h1 class="text-7xl leading-[1.2] font-medium">Quiet Rooms for <br> Focused Minds</h1>
        </div>
    </section>
    @livewire('rooms')

    <footer class=" pr-32 pt-12 ">
        <div class="grid grid-cols-2 h-[340px]">
            <div class="col-span-1 flex flex-col justify-between px-32 py-12 bg-bgWidget h-full">
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
