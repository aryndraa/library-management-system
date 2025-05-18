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
                <div class="p-6 bg-bgWidget rounded-xl flex flex-col justify-between " style="width: 30%">
                    <div>
                        <div class="mb-8">
                            <h2 class="text-[26px] mb-1">Booking Room</h2>
                            <p class="text-font/60">Reserve your room today.</p>
                        </div>
                        <div>
                            <p class="text-lg mb-3">Rp {{ number_format($room->price, 0, ',', '.') }} <span class="text-sm"> / Hrs</span></p>
                            <div class="grid grid-cols-2">
                                <div class="flex col-span-full items-center justify-between px-5 py-3 border rounded-b-none rounded-xl border-font/20">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-sm">Date</span>
                                        <p class="text-font/60 ">11/09/2024</p>
                                    </div>
                                    <x-heroicon-o-calendar-days class="size-8 text-font/40"/>
                                </div>
                                <div>
                                    <div class="flex flex-col gap-1 px-5 py-3 border rounded-t-none rounded-br-none rounded-xl border-font/20">
                                        <span class="text-sm">Clock In</span>
                                        <p class="text-font/60 ">12:00 WITA</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex flex-col gap-1 px-5 py-3 border rounded-t-none rounded-bl-none rounded-xl border-font/20">
                                        <span class="text-sm">Clock Out</span>
                                        <p class="text-font/60 ">14:00 WITA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-4">
                            <p>Total Before Taxes :</p>
                            <span>Rp. 45.000 / <span class="text-sm">Hrs</span></span>
                        </div>
                        <button class="w-full p-3 text-white font-normal rounded-lg bg-primary-300">Reserve</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="w-[70%]">
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
