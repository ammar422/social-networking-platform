<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    route::resource('profile', ProfileController::class);
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'photo_upload'])->name('profile.photo_upload');


    Route::post('send-request/{id}', [FriendshipController::class, 'sendRequest'])->name('send.request');
    Route::post('accept-request/{id}', [FriendshipController::class, 'acceptRequest'])->name('accept.request');
    Route::post('reject-request/{id}', [FriendshipController::class, 'rejectRequest'])->name('reject.request');
    Route::get('friends', [FriendshipController::class, 'listFriends'])->name('friends.list');
    Route::get('friends/requests', [FriendshipController::class, 'listOfRequestsFriends'])->name('friends.requests.list');


    route::resource('post', PostController::class);

    Route::post('post/{post}/like', [PostController::class, 'like'])->name('post.like');
    Route::post('post/{post}/comment', [PostController::class, 'storeComment'])->name('post.comment');
});

require __DIR__ . '/auth.php';
