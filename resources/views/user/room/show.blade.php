
@php
    $mediaItems = $room->getMedia('room');
@endphp

@extends('layouts.show', ['routeDirect' => 'member.room.index'])

@section('content')
    <section>
        <div class="w-full mb-12">
            <div class="mb-6">
                <h1 class="text-3xl font-normal mb-2">{{$room->name}}</h1>
                <p class="text-font/60">{{$room->category->name}}</p>
            </div>
            <div class="flex gap-5 ">
                <div style="width: 70%; max-height: 62vh">
                    <img src="{{$room->getFirstMediaUrl('room')}}" alt="" class="w-full h-full rounded-xl">
                </div>
                @livewire('room-action', ['room' => $room])
            </div>
        </div>
        <div class="w-[70%] flex flex-col gap-12">
            <div>
                <h3 class="text-3xl mb-4">Overview & Description</h3>
                <p class="text-font/60">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <img src="{{ $mediaItems[1]->getUrl() }}" alt="Media ke-2" class="w-full h-64 rounded-lg">
                <img src="{{ $mediaItems[2]->getUrl() }}" alt="Media ke-3" class="w-full h-64 rounded-lg">
            </div>

            <div>
                <h3 class="text-2xl mb-6">Facilities</h3>
                <div class="grid grid-cols-2 gap-4 gap-y-8">
                    @foreach($room->facilities as $facility)
                        <div>
                            <h4 class="text-lg mb-2">{{$facility->facility}}</h4>
                            <p class="text-sm text-font/60">{{$facility->description}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
