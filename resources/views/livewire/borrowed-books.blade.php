<div class="col-span-3 ">
    <div>
        <div class="flex justify-between items-end mb-6">
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
                <th class="px-6 py-3 min-w-56 bg-primary-300 text-white  font-normal">Code</th>
                <th class="px-6 py-3 min-w-52 bg-primary-300 text-white  font-normal">Book Title</th>
                <th class="px-6 py-3 min-w-52 bg-primary-300 text-white  font-normal">Status</th>
                <th class="px-6 py-3 min-w-24  bg-primary-300 text-white  font-normal"></th>
            </tr>
            </thead>
            <tbody class="text-font">
            @forelse ($borrowedBooks as $index => $borrowed)
                <tr class="border-t border-font/20 transition ease-in-out {{
                            $borrowed->status === 'returned' ? 'bg-neutral-100 text-font/60' : ''
                     }}">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ $borrowed->code }}</td>
                    <td class="px-6 py-4">
                        <a href="{{route('member.book.show', $borrowed->book->id)}}" class="hover:text-primary-300 hover:underline" >
                            {{ \Illuminate\Support\Str::limit($borrowed->book->title, 25)  ?? '-' }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-4 py-2 rounded-lg text-xs {{
                            match ($borrowed->status) {
                                'pending' => ' bg-blue-50 text-blue-500',
                                'borrowed' => ' bg-amber-50 text-amber-500',
                                'return requested' => ' bg-amber-50 text-amber-500',
                                'penalty' => ' bg-red-50 text-red-500',
                                'returned' => ' bg-bgWidget text-font/60'
                            }
                        }}">
                            {{ ucfirst($borrowed->status) }}
                        </span>
                    </td>
                    <td>
                        <button type="button"  @click="openModalId = {{ $borrowed->id }}" class="flex items-center gap-3 text-font/60 font-normal">
                            <span>
                                <x-heroicon-s-eye class="size-4"/>
                            </span>
                            Detail
                        </button>
                    </td>
                </tr>

                {{-- Modal --}}
                <div x-show="openModalId === {{ $borrowed->id }}" class="fixed inset-0 z-50 bg-black/50 flex justify-center items-center" x-cloak>
                    <div class="w-[48%] min-h-[45vh] bg-white rounded-xl p-6 grid grid-cols-3 gap-8">
                        <div class="col-span-1 p-4 rounded-xl shadow-sm bg-bgWidget h-full object-cover w-full">
                            <img src="{{ $borrowed->book->getFirstMediaUrl('book') }}" alt="" class="h-full w-full rounded-xl">
                        </div>
                        <div class="col-span-2 pt-3 pb-1 flex-col flex justify-between">
                            <div>
                                <div class="mb-3 pb-3 border-b border-font/20">
                                    <h2 class="text-lg mb-1.5">{{ $borrowed->book->title }}</h2>
                                    <p class="text-sm text-font/60">{{ $borrowed->book->category->name }}</p>
                                </div>
                                <div>
                                    <h3 class="mb-2">Borrowed Detail</h3>
                                    <div class="flex flex-col gap-2">
                                        <div class="grid grid-cols-4 text-font/60">
                                            <h4 class="text-sm">Code</h4>
                                            <span class="text-sm text-center">:</span>
                                            <p class="col-span-2 text-sm text-end">{{ $borrowed->code }}</p>
                                        </div>
                                        <div class="grid grid-cols-4 text-font/60">
                                            <h4 class="text-sm">Borrowed Date</h4>
                                            <span class="text-sm text-center">:</span>
                                            <p class="col-span-2 text-sm text-end">{{ \Carbon\Carbon::parse($borrowed->borrowed_date)->format('d M Y') }}</p>
                                        </div>
                                        <div class="grid grid-cols-4 text-font/60">
                                            <h4 class="text-sm">Due Date</h4>
                                            <span class="text-sm text-center">:</span>
                                            <p class="col-span-2 text-sm text-end">{{ \Carbon\Carbon::parse($borrowed->due_date)->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between items-end">
                                <div class="flex flex-col">
                                    <span class="text-sm text-font/60">Status</span>
                                    <span class="capitalize rounded-lg
                                            {{ match ($borrowed->status) {
                                                'pending' => 'text-blue-500',
                                                'borrowed' => 'text-amber-500',
                                                'return requested' => 'text-amber-500',
                                                'penalty' => 'text-red-500',
                                                'returned' => 'text-font/40'
                                            } }}">
                                            {{ $borrowed->status }}
                                        </span>
                                </div>
                                <div class="flex gap-4 items-center">
                                    <button @click="openModalId = null" class="px-4 py-2 bg-bgWidget hover:bg-bgWidget/80 transition ease-in-out text-sm rounded-lg font-normal">Close</button>
                                    @if($borrowed->status == 'borrowed' || $borrowed->status == 'penalty' )
                                        @livewire('borrowed-book-action', ['borrowedId' => $borrowed->id])
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <tr>
                    <td colspan="8" class="text-center px-6 py-4">No borrowed books found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4 flex justify-end">
            {{ $borrowedBooks->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
        </div>
    </div>

</div>
