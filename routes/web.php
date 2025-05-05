<?php

use App\Http\Controllers\Member\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

Route::prefix('member')
    ->group(function () {
       Route::get('/login', [AuthController::class, 'login'])->name('member.login');
    });
