<header class="absolute z-50 top-0 left-0 right-0 grid grid-cols-2 lg:grid-cols-3 items-center mx-6 lg:mx-20 my-4 lg:my-6">
    <div>
        <x-logo/>
    </div>
    <div class="justify-center items-center gap-10 hidden lg:flex">
        <a href="#" class="text-white text-lg">Home</a>
        <a href="#" class="text-white text-lg">About us</a>
        <a href="#" class="text-white text-lg">Books</a>
        <a href="#" class="text-white text-lg">Rooms</a>
    </div>
    <div class="justify-end gap-4 items-center hidden lg:flex">
        <x-header.search/>
        <div class="flex gap-4">
            <a href="#" class="px-6 py-1.5 border border-transparent text-white rounded-full">Login</a>
            <a href="#" class="px-6 py-1.5 border border-white text-white rounded-full">Register</a>
        </div>
    </div>
    <div class="lg:hidden flex items-center justify-end">
        <x-header.menu/>
    </div>
</header>
