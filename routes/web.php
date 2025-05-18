<?php

use App\Http\Controllers\Member\Auth\AuthController;
use App\Http\Controllers\Member\Book\BookController;
use App\Http\Controllers\Member\Profile\ProfileController;
use App\Http\Controllers\Member\Room\RoomController;
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
                Route::post('/login', 'postLogin')->name('postLogin');

                Route::get('/make-profile', 'makeProfile')->name('makeProfile');
                Route::post('/make-profile', 'postMakeProfile')->name('postMakeProfile');
            });

        Route::controller(ProfileController::class)
            ->name('profile.')
            ->middleware('guest')
            ->group(function () {
                Route::get('/make-profile', 'makeProfile')->name('makeProfile');
                Route::post('/make-profile', 'postMakeProfile')->name('postMakeProfile');
            });


        Route::middleware('auth:member')
            ->group(function () {
                Route::get('/', function () {
                    return view('user.home');
                })->name('home');

                Route::controller(BookController::class)
                    ->prefix('book')
                    ->name('book.')
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/{book}', 'show')->name('show');
                    });

                Route::controller(RoomController::class)
                    ->prefix('room')
                    ->name('room.')
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/{room}', 'show')->name('show');
                    });

                Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        });
    });

