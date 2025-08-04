<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\Token;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', Login::class)->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', Dashboard::class)->middleware('auth')->name('dashboard');
Route::get('/token/{token}', Token::class)->middleware('auth')->name('token');
