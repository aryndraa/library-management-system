<x-filament-panels::page>
    <section class="flex items-start gap-8">

        <div class="flex-1">
            <form wire:submit.prevent="searchBorrowedBook" class="space-y-4 p-4 bg-white rounded-xl shadow">
                {{ $this->form }}
                <x-filament::button type="submit" color="primary">
                    Get Receipt
                </x-filament::button>
            </form>


        </div>

            <div class=" p-6 bg-white shadow rounded-lg flex-1">
                @if ($borrowedBook)
                    <h1 class="font-bold text-2xl text-[#2E3969] mb-6">Receipt Book : {{$borrowedBook->code}}</h1>
                    <div class="flex items-stretch gap-6">
                        <img
                            src="{{$borrowedBook->book->getFirstMediaUrl('book')}}"
                            alt=""
                            class="w-[140px] h-[180px] object-cover"
                        />
                        <div class="w-full h-full ">
                            <h2 class="text-xl font-semibold pb-2 mb-2 border-gray-300 border-b">Book Detail</h2>

                            <div class="mb-6">
                                <h3 class="text-lg font-medium mb-1">{{$borrowedBook->book->title}}</h3>
                                <p class="text-sm mb-1">{{$borrowedBook->book->category->name}}</p>
                                <p class="text-sm">{{$borrowedBook->book->isbn}}</p>
                            </div>
                            <div>
                                <a href="" class="text-sm rounded-xl px-3 py-2 bg-primary-500 text-white font-semibold">More Detail</a>
                            </div>
                        </div>
                    </div>
                 @endif
            </div>
    </section>
</x-filament-panels::page>
