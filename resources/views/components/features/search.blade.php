<form action="" method="get" class="flex items-center gap-3 px-4 py-2 bg-bgWidget rounded-full">
    <input
        type="text"
        name="search"
        id="search"
        class="border-none focus:ring-0 bg-transparent w-72 placeholder:text-font/40"
        placeholder="Search {{$name}}"
        value="{{ request('search') }}"
    >
    <button type="submit" class="p-2 rounded-full bg-white">
        <x-heroicon-o-magnifying-glass class="size-6"/>
    </button>
</form>
