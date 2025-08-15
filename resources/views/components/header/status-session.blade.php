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

    $library = \App\Models\Library::query()->where('id', session('library_id_session'))->first();
@endphp

<div class="flex items-center">
    @if(Auth::check())
        <a href="{{route('member.profile.userProfile')}}" class="flex gap-4 items-center pr-5">
            @if($user->profile->photoProfile)
                <img
                    src="{{$user->profile->photoProfile->file_url}}"
                    alt=""
                    class="size-8 rounded-full object-cover"
                >
            @endif
            <div>
                <h1 class="font-light text-base text-white leading-[1]">{{$user->profile->first_name}} {{$user->profile->last_name}}</h1>
            </div>
        </a>
    @else
        <div class="flex gap-2 pr-4">
            <a href="{{route('member.auth.login')}}" class="px-4 py-1.5 border border-transparent text-white rounded-full">Login</a>
            <a href="{{route('member.auth.register')}}" class="px-4 py-1.5 border border-white text-white rounded-full">Register</a>
        </div>
    @endif

        <form action="{{ route('member.librarySession.clear') }}" method="POST">
            @csrf
            <button class="flex items-center gap-2 pl-4 border-l text-white">
                <x-heroicon-o-map-pin class="size-6"/>
                {{ \Illuminate\Support\Str::limit($library?->name, 10) ?? '-//-' }}
            </button>
        </form>
</div>
