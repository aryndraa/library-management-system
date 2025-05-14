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

<div >
    @if(Auth::check())
        <a href="#" class="flex gap-4 items-center ">
            @if($user->profile->photoProfile)
                <img
                    src="{{$user->profile->photoProfile->file_url}}"
                    alt=""
                    class="size-8 rounded-full"
                >
            @endif
            <div>
                <h1 class="font-light text-base text-white leading-[1]">{{$user->profile->first_name}} {{$user->profile->last_name}}</h1>
            </div>
        </a>
    @else
        <div class="flex gap-4">
            <a href="{{route('member.auth.login')}}" class="px-6 py-1.5 border border-transparent text-white rounded-full">Login</a>
            <a href="{{route('member.auth.register')}}" class="px-6 py-1.5 border border-white text-white rounded-full">Register</a>
        </div>
    @endif

</div>
