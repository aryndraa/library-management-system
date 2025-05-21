<div
    class="col-span-3 "
    x-data="{ openModalId: null } "
    x-init="
             window.addEventListener('close-modal', event => {
                if (event.detail?.id) {
                    openModalId = null;
                }
             })
        "
>
    <div>
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-2xl">Borrowed History</h2>
            <div class="flex flex-col items-end gap-2">
                <div>
                    <select wire:model.live="selectedLibrary" id="librarySelect" class="px-3 py-2 text-sm border-none focus:ring-0 w-64">
                        @foreach ($libraries as $library)
                            <option value="{{ $library->id }}">{{ $library->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3 px-4 py-1.5 bg-bgWidget rounded-full w-fit">
                    <input
                        type="text"
                        class="border-none focus:ring-0 bg-transparent w-72 placeholder:text-font/40"
                        placeholder="Search By Code"
                        wire:model.live="search"
                    >
                    <button type="button" class="p-2 rounded-full bg-white">
                        <x-heroicon-o-magnifying-glass class="size-6"/>
                    </button>
                </div>
            </div>
        </div>
        <table class="min-w-full bg-white border  border-font/20 rounded-lg">
            <thead class="text-left text-sm text-gray-700 uppercase ">
            <tr>
                <th class="px-6 py-3 bg-primary-300 text-white  font-normal ">#</th>
                <th class="px-6 py-3 bg-primary-300 text-white  font-normal ">Room</th>
                <th class="px-6 py-3 bg-primary-300 text-white  font-normal">Date</th>
                <th class="px-6 py-3 bg-primary-300 text-white  font-normal">Time</th>
                <th class="px-6 py-3 bg-primary-300 text-white  font-normal">Status</th>
                <th class="px-6 py-3 bg-primary-300 text-white  font-normal"></th>
            </tr>
            </thead>
            <tbody class="text-font">
            @forelse ($rooms as $index => $room)
                <tr class="border-t border-font/20 transition ease-in-out {{
                                in_array($room->status, ['canceled', 'check out']) ? 'bg-neutral-100 text-font/60' : ''
                            }}">
                    <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm  relative">
                        <a href="{{route('member.room.show', $room->room->id)}}" class="hover:text-primary-300 hover:underline group" >
                            {{ $room->room->name }}
                        </a>
                    </td>

                    <td class="px-6 py-4 text-sm">
                        {{  \Carbon\Carbon::parse($room->booking_date)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        {{  \Carbon\Carbon::parse($room->started_time)->format('H:i:s') }}
                        -
                        {{  \Carbon\Carbon::parse($room->finished_time)->format('H:i:s') }}
                    </td>

                    <td class="px-6 py-4">
                                <span class="px-4 py-2 rounded-lg text-xs font-normal {{
                                    match ($room->status) {
                                        'pending' => ' bg-blue-50 text-blue-500',
                                        'schedule' => ' bg-yellow-50 text-yellow-500',
                                        'check In' => ' bg-green-50 text-green-500',
                                        'canceled' => ' bg-red-50 text-red-500',
                                        'check out' => ' bg-bgWidget text-font/60'
                                    }
                                }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                    </td>

                    <td>
                        <button type="button" @click="openModalId = {{ $room->id }}" class="flex items-center text-sm gap-3 text-font/60 font-normal">
                            <span>
                                <x-heroicon-s-eye class="size-4"/>
                            </span>
                            Detail
                        </button>
                    </td>


                </tr>

                <!-- Modal -->
                <div x-show="openModalId === {{ $room->id }}" class="fixed inset-0 z-50 bg-black/50 flex justify-center items-center" x-cloak>
                    <div class="w-[42%] min-h-[40vh] bg-white rounded-xl p-6">
                        <div class="flex justify-between items-start border-b pb-4 border-font/20 mb-4">
                            <div>
                                <h2 class="text-xl font-semibold">{{ $room->room->name }}</h2>
                                <p class="text-sm text-font/60">{{ $room->room->category->name ?? '-' }}</p>
                            </div>
                            <button @click="openModalId = null" class="text-font/60 hover:text-red-500">
                                <x-heroicon-s-x-mark class="size-5"/>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-y-4 text-sm text-font/70 pb-6  border-b  border-font/20 mb-6">
                            <div class="col-span-1 font-medium">Booking Code</div>
                            <div class="col-span-1 text-right">{{ $room->code ?? '-' }}</div>

                            <div class="col-span-1 font-medium">Booking Date</div>
                            <div class="col-span-1 text-right">{{ \Carbon\Carbon::parse($room->booking_date)->format('d M Y') }}</div>

                            <div class="col-span-1 font-medium">Time</div>
                            <div class="col-span-1 text-right">
                                {{ \Carbon\Carbon::parse($room->started_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($room->finished_time)->format('H:i') }}
                            </div>

                            <div class="col-span-1 font-medium">Status</div>
                            <div class="col-span-1 text-right capitalize {{
                                            match ($room->status) {
                                                'pending' => 'text-yellow-500',
                                                'schedule' => 'text-blue-500',
                                                'check In' => 'text-green-500',
                                                'canceled' => 'text-red-500',
                                                'check out' => 'text-font/60'
                                            }
                                        }}">
                                {{ $room->status }}
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-y-4 text-sm text-font/70">
                            <div class="col-span-1 font-medium">Total Price</div>
                            <div class="col-span-1 text-right">
                                {{ $room->total_price ? 'Rp ' . number_format($room->total_price, 0, ',', '.') : '-' }}
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-4">
                            <button @click="openModalId = null" class="px-4 py-2 text-sm rounded-lg bg-bgWidget hover:bg-bgWidget/80 transition ease-in-out">
                                Close
                            </button>
                            @if($room->status !== 'canceled' && $room->status !== 'check out'  )
                               @livewire('booked-room-action', ['bookedId' => $room->id])
                            @endif
                        </div>
                    </div>
                </div>

            @empty
                <tr>
                    <td colspan="8" class="text-center px-6 py-4">No Rooms found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4 flex justify-end">
            {{ $rooms->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
        </div>
    </div>
</div>
