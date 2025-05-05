<?php

use App\Http\Controllers\Member\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

Route::prefix('member')
    ->group(function () {
        Route::controller(AuthController::class)
            ->name('member.auth')
            ->middleware('guest')
            ->group(function () {
                Route::get('/register', 'register')->name('register');
            });
    });
