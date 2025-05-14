@php
    use App\Models\Member;
    use Illuminate\Support\Facades\Auth;

    if(Auth::check()) {

        $userId = Auth::user()->id;

        $user = Member::query()
                    ->where('id', $userId)
                    ->with(['profile', 'profile.photoProfile'])
                    ->first();
    }

@endphp

<div x-data="{ open: false }">
    <!-- Toggle Button -->
    <div>
        <button @click="open = !open" class="flex items-center">
            <x-heroicon-o-bars-3 class="w-8 h-8 text-white"/>
        </button>
    </div>

    <!-- Overlay -->
    <div
        x-show="open"
        class="fixed inset-0 bg-black bg-opacity-80 z-40"
        @click="open = false"
        x-transition.opacity
    ></div>

    <!-- Sidebar -->
    <div
        class="fixed top-0 left-0 p-5 py-5 h-full w-full bg-gray-800 text-white z-50 transform transition-transform duration-300"
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        x-transition
    >
        <div class="mb-6 pb-6 text-lg font-semibold border-b border-font">
            <div class="flex justify-end mb-3">
                <button @click="open = !open">
                    <x-heroicon-o-x-mark class="h-8 w-8"/>
                </button>
            </div>
            <div>
                @if(Auth::check())
                    <div class="flex gap-4 items-center">
                        @if($user->profile->photoProfile)
                            <img
                                src="{{$user->profile->photoProfile->file_url}}"
                                alt=""
                                class="size-14 rounded-full"
                            >
                        @endif
                        <div>
                            <h1 class="font-light text-base leading-[1]">{{$user->profile->first_name}} {{$user->profile->last_name}}</h1>
                            <a href="#" class="text-sm font-light text-white/80 leading-[1]">View Profile</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <nav class="flex flex-col gap-8">
            <div>
                <h3 class="text-sm text-white/50 mb-4 font-light">Menu</h3>
                <div class="flex flex-col gap-5 pl-2">
                    <a href="#" class="text-white/50 font-light text-base flex gap-3 items-center">
                        <div>
                            <x-heroicon-o-home class="size-6"/>
                        </div>
                        Home
                    </a>
                    <a href="#" class="text-white/50 font-light text-base flex gap-3 items-center">
                        <div>
                            <x-heroicon-o-newspaper class="size-6"/>
                        </div>
                        About us
                    </a>
                    <a href="#" class="text-white/50 font-light text-base flex gap-3 items-center">
                        <div>
                            <x-heroicon-o-rectangle-stack class="size-6"/>
                        </div>
                        Rooms
                    </a>
                    <a href="#" class="text-white/50 font-light text-base flex gap-3 items-center">
                        <div>
                            <x-heroicon-o-book-open class="size-6"/>
                        </div>
                        Books
                    </a>
                </div>
            </div>
            <div>
                <h3 class="text-sm text-white/50 mb-4 font-light">Options</h3>
                <div class="flex flex-col gap-5 pl-2">
                    <a href="#" class="text-white/50 font-light text-base flex gap-3 items-center">
                        <div>
                            <x-heroicon-o-bookmark-square class="size-6"/>
                        </div>
                        Borrowed Books
                    </a>
                    <a href="#" class="text-white/50 font-light text-base flex gap-3 items-center">
                        <div>
                            <x-heroicon-s-list-bullet class="size-6"/>
                        </div>
                        Booking Rooms
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
