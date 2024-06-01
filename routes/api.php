<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\registerController;
use App\Http\Controllers\Api\Posts\ApiPostController;
use App\Http\Controllers\Api\Profiles\ApiProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

route::post('login', [LoginController::class, 'login']);
route::post('register', [registerController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    route::prefix('user')->group(function () {
        route::apiResource('profile', ApiProfileController::class);
        route::apiResource('post', ApiPostController::class);
    });
});
