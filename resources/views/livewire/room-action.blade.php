<form wire:submit.prevent="bookRoom" wire:poll class="p-6 bg-bgWidget rounded-xl sticky top-0 flex flex-col justify-between " style="width: 30%">
    <div>
        <div class="mb-8">
            <h2 class="text-[26px] mb-1">Booking Room</h2>
            <p class="text-font/60">Reserve your room today.</p>
        </div>
        <div>
            <p class="text-lg mb-3">Rp {{ number_format($room->price, 0, ',', '.') }} <span class="text-sm"> / Hrs</span></p>
            <div class="grid grid-cols-2">
                <div class="flex col-span-full items-center justify-between px-5 py-3 border rounded-b-none rounded-xl border-font/20">
                    <div class="flex flex-col gap-1 w-full">
                        <label class="text-sm">Date</label>
                        <input type="date" required wire:model="date" class="text-font/60 w-full bg-transparent border-none focus:ring-0">
                    </div>
                </div>
                <div>
                    <div class="flex flex-col gap-1 px-5 py-3 border rounded-t-none rounded-br-none rounded-xl border-font/20">
                        <label class="text-sm">Clock In</label>
                        <input type="time" required  wire:model="startedTime" class="text-font/60 p-0 bg-transparent border-none focus:ring-0 ">
                    </div>
                </div>
                <div>
                    <div class="flex flex-col gap-1 px-5 py-3 border rounded-t-none rounded-bl-none rounded-xl border-font/20">
                        <label class="text-sm">Clock Out</label>
                        <input type="time" required  wire:model="finishedTime" class="text-font/60 p-0 bg-transparent border-none focus:ring-0 ">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="flex justify-between mb-4">
            <p>Total :</p>
            @if($total)
                Rp {{ number_format($total, 0, ',', '.') }}
            @else
                <span class="text-font/50">-///-</span>
            @endif
        </div>
        <button
            wire:click="bookRoom"
            wire:loading.attr="disabled"
            wire:target="bookRoom"
            class="w-full p-3 text-white font-normal rounded-lg bg-primary-300 flex items-center justify-center gap-2"
        >
            <span wire:loading.remove wire:target="bookRoom">Reserve</span>

            <div wire:loading wire:target="bookRoom" class="flex items-center justify-center gap-2">
                <span>
                    Loading...
                </span>
            </div>
        </button>
    </div>

</form>
