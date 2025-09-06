<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use OpenSynergic\LaravelSSO\Controllers\AppReceiveController;

Route::prefix('api')->middleware('api')->group(function () {
    Route::post('/receive-app', [AppReceiveController::class, 'appReceive']);
});

Route::middleware('client_api_key')->get('/is-client', function (Request $request) {
    return response()->json([
        'is_client' => 'yes'
    ]);
});