@php
    use App\Models\Member;
    use Illuminate\Support\Facades\Auth;

    $userId = Auth::user()->id;

    $user = Member::query()
                ->where('id', $userId)
                ->with(['profile'])
                ->first()


@endphp

<div x-data="{ open: true }">
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
        class="fixed top-0 left-0 p-6 py-5 h-full w-full bg-gray-800 text-white z-50 transform transition-transform duration-300"
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        x-transition
    >
        <div class="mb-4 text-lg font-semibold border-b border-gray-700">
            <div class="flex justify-end">
                <button>
                    <x-heroicon-o-x-mark class="h-8 w-8"/>
                </button>
            </div>
            <div>
                @if(auth())
                    <div>
                        {{--                        @if()--}}
                        {{--                            <img src="" alt="">--}}
                        {{--                        @endif--}}
                    </div>
                @endif
            </div>
        </div>
        <nav class="flex flex-col gap-4">
            <a href="#" class="text-white text-lg">Home</a>
            <a href="#" class="text-white text-lg">About us</a>
            <a href="#" class="text-white text-lg">Books</a>
            <a href="#" class="text-white text-lg">Rooms</a>
        </nav>
    </div>
</div>
