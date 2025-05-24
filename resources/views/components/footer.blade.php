<footer class=" lg:pr-5  ">
    <div class="grid grid-cols-1 lg:grid-cols-2 h-[340px] w-full">
        <div class="lg:col-span-1 flex flex-col gap-4 lg:gap-0 justify-between px-5 lg:px-32 2xl:px-80 py-8 lg:py-12 bg-bgWidget w-full h-full">
            <div>
                <h1 class="text-2xl lg:text-4xl mb-1 lg:mb-2">Perpusku</h1>
                <p class=" text-sm lg:text-base text-font/60">Exclusive Library</p>
            </div>
            <div>
                <p class="text-sm lg:text-base mb-3">Inspiration often begins quietly — between the pages of a book, in a single sentence, a new idea is born.</p>
                <div class="flex items-center text-sm lg:text-base gap-2">
                    <hr class="w-6">
                    <p>Arya</p>
                </div>
            </div>
        </div>
        <div class="col-span-1 grid grid-cols-2 px-5 lg:px-12 py-8 lg:py-12">
            <div>
                <h3 class="mb-6 text-xl lg:text-2xl">Useful Link</h3>
                <div class="flex flex-col gap-4 text-sm lg:text-base ">
                    <a href="{{ route('member.home') }}" class="hover:underline">Home</a>
                    <a href="#" class="hover:underline">About Us</a>
                    <a href="{{ route('member.book.index') }}" class="hover:underline">Books</a>
                    <a href="{{ route('member.room.index') }}" class="hover:underline">Rooms</a>
                </div>
            </div>
            <div>
                <h3 class="mb-6 text-xl lg:text-2xl">Profile Pages</h3>
                <div class="flex flex-col gap-4 text-sm lg:text-base ">
                    <a href="{{ route('member.profile.userProfile') }}" class="hover:underline">Profile</a>
                    <a href="{{ route('member.profile.borrowedBooks') }}" class="hover:underline">Borrowed Books</a>
                    <a href="{{ route('member.profile.bookedRooms') }}" class="hover:underline">Booked Room</a>
                    <a href="{{ route('member.profile.accountSetting') }}" class="hover:underline">Settings</a>
                </div>
            </div>
        </div>
    </div>
</footer>
