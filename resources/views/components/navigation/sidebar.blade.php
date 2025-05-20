<div class="col-span-1 flex flex-col text-font/60 border-r">
    <a href="{{ route('member.profile.userProfile') }}"
       class="pb-6 w-fit border-b {{ request()->routeIs('member.profile.userProfile') ? 'text-font border-font/40' : 'border-transparent' }}">
        User Profile
    </a>
    <a href="{{ route('member.profile.borrowedBooks') }}"
       class="py-6 w-fit border-b {{ request()->routeIs('member.profile.borrowedBooks') ? 'text-font border-font/40' : 'border-transparent' }}">
        Borrowed Books
    </a>
    <a href="#" class="py-6 w-fit border-b border-transparent">Book Likes</a>
    <a href="#" class="py-6 w-fit border-b border-transparent">Booked Room</a>
    <a href="#" class="py-6 w-fit border-b border-transparent">Account Setting</a>
</div>
