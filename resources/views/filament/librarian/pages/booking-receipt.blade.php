<x-filament-panels::page>
    <section class="flex items-start gap-8">

        <div class="flex-1">
            <form wire:submit.prevent="searchRoomBooking" class="space-y-4 p-4 bg-white rounded-xl shadow">
                {{ $this->form }}
                <x-filament::button type="submit" color="primary">
                    Get Receipt
                </x-filament::button>
            </form>


        </div>

        <div class=" p-6 bg-white shadow rounded-lg flex-1">
            @if ($roomBooking)
                <h1 class="font-bold text-2xl text-[#2E3969] mb-6">Receipt Book : {{$roomBooking->code}}</h1>
                <div class="flex items-stretch gap-6 mb-6">
                    <img
                        src="{{$roomBooking->room->getFirstMediaUrl('room')}}"
                        alt=""
                        class="w-[140px] h-[140px] object-cover"
                    />
                    <div class="w-full h-full ">
                        <div class="mb-4">
                            <h3 class="text-xl font-medium mb-1">{{$roomBooking->room->name}}</h3>
                            <p class="mb-1">{{$roomBooking->room->category->name}}</p>
                            <p class="text-sm mb-1">Rp {{ number_format($roomBooking->room->price, 0, ',', '.') }}/ Hours</p>
                        </div>
                        <div>
                            <a href="" class="text-xs rounded-xl px-3 py-2 bg-primary-500 text-white font-semibold">Room Detail</a>
                        </div>
                    </div>
                </div>

                <div class="w-full mb-4">
                    <h2 class="font-medium text-gray-400 text-sm mb-4">Booking Detail</h2>
                    <div class="flex flex-col gap-4  py-4 px-2 border-y">
                        <div class="grid grid-cols-4 font-medium text-gray-500   ">
                            <h3>Code</h3>
                            <span class="text-center">:</span>
                            <p class="col-span-2 flex justify-end">{{$roomBooking->code}}</p>
                        </div>
                        <div class="grid grid-cols-4 font-medium text-gray-500   ">
                            <h3>Borrowed Date</h3>
                            <span class="text-center">:</span>
                            <p class="col-span-2 flex justify-end">{{\Carbon\Carbon::parse($roomBooking->borrowed_date)->translatedFormat('d M Y')}}</p>
                        </div>
                        <div class="grid grid-cols-4 font-medium text-gray-500   ">
                            <h3>Start Time</h3>
                            <span class="text-center">:</span>
                            <p class="col-span-2 flex justify-end">{{\Carbon\Carbon::parse($roomBooking->started_time)->translatedFormat('H:i:s')}} WITA</p>
                        </div>
                        <div class="grid grid-cols-4 font-medium text-gray-500   ">
                            <h3>Finish Time</h3>
                            <span class="text-center">:</span>
                            <p class="col-span-2 flex justify-end">{{\Carbon\Carbon::parse($roomBooking->finished_time)->translatedFormat('H:i:s')}} WITA</p>
                        </div>
                    </div>
                </div>

                <div class="w-full mb-10">
                    <h2 class="font-medium text-gray-400 text-sm mb-4">Payment Detail</h2>
                    <div class="flex flex-col gap-4  py-4 px-2 border-y">
                        <div class="grid grid-cols-4 font-medium text-gray-500   ">
                            <h3>Total Price</h3>
                            <span class="text-center">:</span>
                            <p class="col-span-2 flex justify-end">Rp. {{ number_format($roomBooking->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="grid grid-cols-4 font-medium text-gray-500   ">
                            <h3>Payment </h3>
                            <span class="text-center">:</span>
                            <p class="col-span-2 flex justify-end">DANA</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-2 ">
                    <div class="flex items-center gap-3   ">
                        @if(!$roomBooking->member->getFirstMediaUrl('member'))
                            <x-heroicon-s-user class="w-10 h-10 p-2 text-white bg-primary-700 rounded-full"  />
                        @else
                            <img src="{{$roomBooking->member->getFirstMediaUrl('member')}}" alt="">
                        @endif
                        <div >
                            <h3 class="font-medium">{{$roomBooking->member->profile->first_name . ' ' . $roomBooking->member->profile->last_name}}</h3>
                            <p class="text-sm">{{$roomBooking->member->email}}</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="printPdf">
                        <x-filament::button type="submit"  class="text-sm text-white px-3 py-2 bg-primary-500 rounded-xl font-semibold">
                                <span class="flex items-center gap-2 ">
                                    <x-heroicon-s-document-text class="w-5 h-5"/>
                                    Print Receipt
                                </span>
                        </x-filament::button>
                    </form>
                </div>
            @endif
        </div>
    </section>
</x-filament-panels::page>
