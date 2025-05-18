@props(['room'])

<div class="grid grid-cols-3 gap-4 w-full">
    <img src="{{$room->getFirstMediaUrl('room')}}" class="col-span-2 min-w-full max-h-80 rounded-xl" alt="">
    <div class="bg-bgWidget rounded-xl p-5 flex flex-col justify-between ">
        <div>
            <div class="pb-3 mb-3 border-b border-font/20">
                <h2 class="text-2xl mb-1.5">{{$room->name}}</h2>
                <p class="text-sm text-font/60">{{$room->category->name}}</p>
            </div>
            <div>
                <h3 class="text-lg mb-1.5">Facilities</h3>
                <ul class="flex flex-col gap-1.5">
                    @foreach($room->facilities->take(3) as $facility)
                        <li class="list-disc ml-4 text-sm text-font/60">
                            {{ $facility->facility }}
                        </li>
                    @endforeach
                        <li class="list-disc ml-4 text-sm text-font/60">
                            More....
                        </li>
                </ul>
            </div>
        </div>
        <div class="flex justify-between items-end">
            <div>
                <p class="text-sm text-font/60">Price</p>
                <span>Rp {{ number_format($room->price, 0, ',', '.') }}</span>
            </div>
            <a href="#" class="flex items-center gap-2">
                View Room
                <x-heroicon-o-arrow-right class="size-5"/>
            </a>
        </div>
    </div>
</div>
