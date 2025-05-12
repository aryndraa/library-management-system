<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function register(): View
    {
        return view('user.auth.register');
    }

    public function postRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string|same:password',
        ]);

        $data = $request->only('email', 'password');
        $data['password'] = bcrypt($data['password']);

        $user = Member::query()->create($data);

        session(['member_id_pending_profile' => $user->id]);

        return redirect()->route('makeProfile');
    }

    public function makeProfile()
    {
        if (!session()->has('member_id_pending_profile')) {
            return redirect()->route('register');
        }

        return view('user.auth.make-profile');
    }

    public function postMakeProfile(Request $request, ): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => 'required|string',
            'address'    => 'nullable|ring',
            'city'       => 'nullable|ring',
            'province'   => 'nullable|ring',
            'birthday'   => 'nullable|te',
            'gender'     => 'nullable|ring',
        ]);

        $memberId = session('member_id_pending_profile');
        $member = Member::query()->findOrFail($memberId)->load('profile');

        $member->profile()->make($request->only([
            'first_name', 'last_name', 'phone', 'address',
            'city', 'province', 'birthday', 'gender'
        ]));

        Auth::login($member);

        session()->forget('member_id_pending_profile');

        return redirect()->route('home');
    }

    public function login(): View
    {
        return view('user.auth.login');
    }
}
