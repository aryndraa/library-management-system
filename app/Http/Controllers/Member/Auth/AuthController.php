<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Auth\RegisterRequest;
use App\Models\File;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function register(): View
    {
        return view('user.auth.register');
    }

    public function postRegister(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'same:password'],
        ]);


        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->error($message);
            }

            return redirect()->route('member.auth.register')->withErrors($validator);
        }

        $data = $request->only('email', 'password');
        $data['password'] = bcrypt($data['password']);

        $user = Member::query()->create($data);

        flash()->success('Registered successfully!');
        session(['member_id_pending_profile' => $user->id]);

        return redirect()->route('member.auth.makeProfile');


    }

    public function makeProfile()
    {
        if (!session()->has('member_id_pending_profile')) {
            flash()->error('Your session was expired');

            return redirect()->route('member.auth.login');
        }

        return view('user.auth.make-profile');
    }

    public function postMakeProfile(Request $request,): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => 'required|string',
            'address'    => 'nullable|ring',
            'city'       => 'nullable|ring',
            'province'   => 'nullable|ring',
            'birthday'   => 'nullable|te',
            'gender'     => 'nullable|ring',
            'avatar'     => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->error($message);
            }

            return redirect()->route('member.auth.makeProfile')->withErrors($validator);
        }

        $memberId = session('member_id_pending_profile');
        $member   = Member::query()->findOrFail($memberId);

        $member->profile()->create($request->only([
            'first_name', 'last_name', 'phone', 'address',
            'city', 'province', 'birthday', 'gender'
        ]));

        $member->load('profile');

        if($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');


            if($member->profile->avatar) {
                Storage::disk('public')->delete($member->profile->avatar->file_path);
                $member->profile->avatar->delete();
            }

            File::uploadFile($avatar, $member->profile, 'avatar', 'avatars');
        }

        Auth::guard('member')->login($member);

        session()->forget('member_id_pending_profile');

        return redirect()->route('member.home');
    }

    public function login(): View
    {
        return view('user.auth.login');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);


        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                flash()->error($message);
            }

            return redirect()->route('member.auth.login')->withErrors($validator);
        }

        $member = Member::query()
            ->where('email', $validator->getData()['email'])
            ->first();

        if (!$member || !Hash::check($validator->getData()['password'], $member->password)) {
            flash()->error('Email or password is wrong!');

            return redirect()->route('member.auth.login')->withErrors($validator);
        }

        if($member->profile()->exists()) {
            Auth::guard('member')->login($member);

            flash()->success('Login successfully!');

            return redirect()->route('member.home');
        }

        session(['member_id_pending_profile' => $member->id]);

        flash()->warning('Please create your profile first!');

        return redirect()->route('member.auth.makeProfile');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('member')->logout();

        flash()->warning('You are logged out!');

        return redirect()->route('member.auth.login');
    }
}
