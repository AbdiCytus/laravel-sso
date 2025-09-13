<?php

use Illuminate\Support\Facades\Route;
use OpenSynergic\LaravelSSO\Controllers\UserApiReceiveController;
use OpenSynergic\LaravelSSO\Controllers\UserReceiveController;

Route::middleware(['web'])->group(function () {
    Route::get('receive-user', [UserReceiveController::class, 'userReceive']);
});

// routes/api.php
Route::middleware('internal.auth')->group(function () {
    Route::get('user/{id}', [UserApiReceiveController::class, 'users']);
});