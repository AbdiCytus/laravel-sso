<?php

use Illuminate\Support\Facades\Route;
use OpenSynergic\LaravelSSO\Controllers\UserApiReceiveController;
use OpenSynergic\LaravelSSO\Controllers\UserReceiveController;

Route::middleware(['web'])->group(function () {
    Route::get('receive-user', [UserReceiveController::class, 'userReceive']);
});
Route::get('user/{id?}', [UserApiReceiveController::class, 'users']);