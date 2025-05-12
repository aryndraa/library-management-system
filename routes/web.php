<?php

use App\Http\Controllers\Member\Auth\AuthController;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

Route::prefix('member')
    ->name('member.')
    ->group(function () {

        Route::controller(AuthController::class)
            ->name('auth.')
            ->middleware('guest')
            ->group(function () {
                Route::get('/register', 'register')->name('register');
                Route::post('/register', 'postRegister')->name('postRegister');
                Route::get('/login', 'login')->name('login');
                Route::get('/make-profile', 'makeProfile')->name('make-profile');
            });
    });

