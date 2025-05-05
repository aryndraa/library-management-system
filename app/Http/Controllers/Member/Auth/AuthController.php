<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
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

        $data = $request->all();
        $user = $this->create($data);

        Auth::login($user);

        return redirect('makeProfile');
    }

    public function makeProfile(): View
    {
        return view('user.auth.make-profile');
    }
}
