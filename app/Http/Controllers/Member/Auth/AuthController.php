<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Auth\RegisterRequest;
use App\Models\File;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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

        return redirect()->route('member.profile.makeProfile');
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

        return redirect()->route('member.profile.makeProfile');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('member')->logout();
        session()->forget('library_id_session');

        flash()->warning('You are logged out!');

        return redirect()->route('member.auth.login');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $token = Str::random(64);
        $email = $request->input('email');

        if($email !== Auth::user()->email) {
            flash()->error('Your email is not valid!');

            return redirect()->route('member.profile.accountSetting');
        }

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => Hash::make($token),
            ]
        );

        \Mail::send('mail.reset', ['token' => $token], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Reset Password');
        });

        flash()->success('Reset password sent to your email!');

        return redirect()->route('member.profile.accountSetting');
    }

    public function showResetForm($token)
    {
        return view('user.auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $record = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            flash()->error('Token is invalid or expired!');

            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        if (Carbon::parse($record->created_at)->addMinutes(5)->isPast()) {
            flash()->error('You are token has expired!');

            return back()->withErrors(['email' => 'Token expired.']);
        }

        $user = Member::where('email', $request->email)->first();
        $user->password = $request->password;
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        flash()->success('password reset successfully!');

        return redirect()->route('member.home')->with('status', 'Password has been reset.');
    }
}
