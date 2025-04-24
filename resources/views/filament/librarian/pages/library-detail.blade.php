<x-filament::page>
    <section class="library-detail">
        <div class=" grid grid-cols-5 gap-4 mb-6">
            @foreach($this->library->getMedia('library') as $media)
                <div class="relative first:col-span-3">
                    <img src="{{$media->getUrl()}}" alt="" class=" h-[50vh] w-full object-cover rounded-xl ">
                    <div class="absolute inset-0  bg-gradient-to-b from-transparent to-black/50 rounded-xl"></div>
                </div>
            @endforeach
        </div>
        <div class="grid grid-cols-5">
            <div class="col-span-3">
                <div class="mb-6 bg-white rounded-xl p-4 shadow-sm">
                    <h1 class="text-2xl font-semibold  mb-2">{{$this->library->name}}</h1>
                    <p class="flex gap-2 items-center fomed">
                        <span><x-heroicon-m-map-pin class="w-5 h-5 text-primary-500" /></span>
                        {{$this->library->address}}
                    </p>
                </div>
                <div class="p-4 bg-white rounded-xl shadow-sm">
                    <h2 class="font-medium text-gray-500  mb-6 ">All Librarian</h2>
                    <div>
                        {{$this->table}}
                    </div>
                </div>
            </div>
            <div class="stats">

            </div>
        </div>
    </section>
</x-filament::page>

{{--<p>{{$this->form}}</p>--}}
