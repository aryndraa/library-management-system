@php
    if(session('library_id_session')) {
        $show = false;
    }
 @endphp

<div>

    @if($show)
        <div
            x-transition.opacity.duration.500ms
            class="fixed inset-0 max-h-screen z-50 w-full bg-black/50 flex justify-center items-end lg:items-center overflow-y-hidden"
        >
            <div
                class=" bg-white backdrop-blur-xl rounded-xl w-full lg:w-[40%] h-fit p-6 py-8"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
            >
                <form class="mb-4 flex items-center justify-between w-full rounded-full bg-bgWidget px-5 py-1.5">
                    <input
                        type="text"
                        wire:model.live="search"
                        class="w-[90%] border-none focus:ring-0 bg-transparent placeholder:text-font/60"
                        placeholder="Search Library..."
                    >
                </form>

                <div class="w-full flex flex-col">
                    @forelse ($libraries as $lib)
                        <button
                            wire:click="setLibrarySession({{$lib->id}})"
                            class="py-4 border-b first:border-t-transparent last:border-b-transparent border-font/10 px-4 group flex justify-between items-center transition ease-in-out duration-500"
                        >
                            <div class="flex flex-col gap-1 text-left">
                                <h3 class="group-hover:text-primary-300 transition">{{ $lib->name }}</h3>
                                <span class="text-sm text-font/60 group-hover:text-primary-300 transition">{{ $lib->address }}</span>
                            </div>
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <x-heroicon-o-arrow-right-circle class="w-8 h-8 text-primary-300/40" />
                            </span>
                        </button>
                    @empty
                        <div class="text-sm text-font/60 text-center py-4">Tidak ada hasil.</div>
                    @endforelse
                </div>
            </div>

        </div>
   @endif
</div>


