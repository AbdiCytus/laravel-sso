<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use OpenSynergic\LaravelSSO\Controllers\AppReceiveController;

Route::post('/receive-app', [AppReceiveController::class, 'appReceive']);
