@php
    $librarySession = session('library_id_session');
@endphp

<div>
    <div class="min-h-screen bg-black/50 fixed inset-0 overflow-y-hidden z-50 flex justify-center">
        <div
            class="mt-32 bg-white backdrop-blur-xl rounded-xl w-[40%] h-fit p-6 py-8"
        >
            <form class="mb-4 flex items-center justify-between w-full rounded-full bg-bgWidget px-5 py-1.5 ">
                <input
                    type="text"
                    class="w-[90%] border-none focus:ring-0 bg-transparent placeholder:text-font/60"
                    placeholder="Search Library..."
                >
                <button>
                    <x-heroicon-o-magnifying-glass class="w-6 h-6" />
                </button>
            </form>
            <div class="w-full flex flex-col ">
                @foreach([1, 2, 3] as $item)
                    <button
                        class="py-4 border-b first:border-t-transparent last:border-b-transparent border-font/10 px-4 group  flex justify-between items-center transition ease-in-out duration-500"
                    >
                        <div class="flex flex-col gap-1">
                            <h3 class="group-hover:text-primary-300 transition">Perpusku Denpasar Timur</h3>
                            <span class="text-sm text-font/60 group-hover:text-primary-300 transition flex">Jalan Kapten Sujana</span>
                        </div>
                        <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-500 ">
                            <x-heroicon-o-arrow-right-circle class="w-8 h-8 text-primary-300/40" />
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>
