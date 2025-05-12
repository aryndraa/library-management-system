<?php

use App\Http\Controllers\Member\Auth\AuthController;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;



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
                Route::post('/make-profile', 'postMakeProfile')->name('postMakeProfile');
            });

        Route::middleware('auth:member')
            ->group(function () {
                Route::get('/', function () {
                    return view('user.home');
                })->name('home');


        });
    });

