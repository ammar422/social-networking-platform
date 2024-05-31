<?php

use App\Http\Controllers\Api\Auth\ApiAuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

route::post('login',[ApiAuthenticationController::class,'login']);
route::post('register',[ApiAuthenticationController::class,'register']);

Route::middleware('auth:api')->group(function () {
    // Route::get('user/profile', [ApiAuthenticationController::class, 'profile']);
    Route::post('logout', [ApiAuthenticationController::class, 'logout']);
    
});