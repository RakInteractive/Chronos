<?php

use App\Http\Controllers\LogEntryController;
use App\Http\Middleware\TokenAuthentication;
use Illuminate\Support\Facades\Route;

Route::controller(LogEntryController::class)->middleware(TokenAuthentication::class)->group(function () {
    Route::post('/log', 'store');
});
