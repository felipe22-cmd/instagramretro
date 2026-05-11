<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->group(function () {
    // El nombre del parámetro {user} debe coincidir con lo que recibe tu controlador
    Route::get('/profile/{user}', [ProfileController::class, 'show']);


    Route::get('/me',     [AuthController::class, 'me']);
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'ok']);
    });

    // Posts
    Route::get('/posts',           [PostController::class, 'index']);
    Route::post('/posts',          [PostController::class, 'store']);
    Route::get('/posts/{post}',    [PostController::class, 'show']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // Comments
    Route::get('/posts/{post}/comments',  [CommentController::class, 'index']);
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);

    // Likes
    Route::post('/posts/{post}/like',   [LikeController::class, 'like']);
    Route::delete('/posts/{post}/like', [LikeController::class, 'unlike']);

    // Friendships
    Route::post('/users/{user}/friend',             [FriendshipController::class, 'send']);
    Route::get('/friends',                          [FriendshipController::class, 'myFriends']);
    Route::get('/friendships/pending',              [FriendshipController::class, 'pending']);
    Route::post('/friendships/{friendship}/accept', [FriendshipController::class, 'accept']);

    // Perfil
    Route::get('/profile/{user}',  [ProfileController::class, 'show']);
    Route::post('/profile/update', [ProfileController::class, 'update']);

    // Chat
    Route::get('/messages',         [MessageController::class, 'chatList']);
    Route::get('/messages/{user}',  [MessageController::class, 'conversation']);
    Route::post('/messages/{user}', [MessageController::class, 'send']);
});