<?php

namespace App\Http\Controllers\Member\Profile;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function makeProfile()
    {
        if (!session()->has('member_id_pending_profile')) {
            flash()->error('Your session was expired');

            return redirect()->route('member.auth.login');
        }

        return view('user.profile.make-profile');
    }

    public function postMakeProfile(Request $request): RedirectResponse
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


            if($member->profile->photoProfile) {
                Storage::disk('public')->delete($member->profile->avatar->file_path);
                $member->profile->avatar->delete();
            }

            File::uploadFile($avatar, $member->profile, 'photoProfile', 'member/avatars');
        }

        Auth::guard('member')->login($member);

        session()->forget('member_id_pending_profile');

        return redirect()->route('member.home');
    }

    public function userProfile()
    {
        $member = Member::query()
            ->where('id', Auth::id())
            ->with(['profile', 'profile.photoProfile'])
            ->first();

        return view('user.profile.user-profile', compact('member'));
    }
}
