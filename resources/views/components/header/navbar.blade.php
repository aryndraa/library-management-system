<header class="absolute z-10 top-0 left-0 right-0 grid grid-cols-2 lg:grid-cols-3 items-center mx-6 lg:mx-20 2xl:mx-80 my-5 lg:my-6 2xl:my-8">
    <div>
        <x-logo/>
    </div>
    <div class="justify-center items-center gap-10 hidden lg:flex">
        <a href="{{ route('member.home') }}" class="text-white text-lg">Home</a>
        <a href="#" class="text-white text-lg">About us</a>
        <a href="{{route('member.book.index')}}" class="text-white text-lg">Books</a>
        <a href="{{route('member.room.index')}}" class="text-white text-lg">Rooms</a>
    </div>
    <div class="justify-end gap-8 items-center hidden lg:flex">
        <x-header.status-session/>
    </div>
    <div class="lg:hidden flex items-center justify-end">
        <x-header.menu/>
    </div>
</header>
