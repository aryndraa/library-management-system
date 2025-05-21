<div class="col-span-1 sticky top-12 flex flex-col text-font/60 border-r h-fit">
    <a href="{{ route('member.profile.userProfile') }}"
       class="pb-6 w-fit border-b {{ request()->routeIs('member.profile.userProfile') ? 'text-font border-font/40' : 'border-transparent' }}">
        User Profile
    </a>
    <a href="{{ route('member.profile.borrowedBooks') }}"
       class="py-6 w-fit border-b {{ request()->routeIs('member.profile.borrowedBooks') ? 'text-font border-font/40' : 'border-transparent' }}">
        Borrowed Books
    </a>
    <a href="{{ route('member.profile.bookLikes') }}"
       class="py-6 w-fit border-b {{ request()->routeIs('member.profile.bookLikes') ? 'text-font border-font/40' : 'border-transparent' }}">
        Book Likes
    </a>
    <a href="{{ route('member.profile.bookedRooms') }}" class="py-6 w-fit border-b border-transparent">Booked Room</a>
    <a href="#" class="py-6 w-fit border-b border-transparent">Account Setting</a>
</div>
