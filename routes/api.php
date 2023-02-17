<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostReactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth Services
Route::post('/login', [AuthController::class, 'store'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'destroy'])->name('logout');

// User Services
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/users', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/users/{user}/posts', [ProfileController::class, 'all'])->name('profile.posts.all');
    // Update profile image
    Route::post('/users/update_image', [ProfileController::class, 'updateImage'])->name('profile.update_image');
    // Update background image
    Route::post('/users/update_background_image', [ProfileController::class, 'updateBackgroundImage'])->name('profile.update_background_image');
});

// Post Services
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('post.index');
    Route::get('/posts_all', [PostController::class, 'all'])->name('post.index.all');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('post.show');
    Route::post('/posts', [PostController::class, 'store'])->name('post.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');
});

// Comment Services
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts/{post}', [PostCommentController::class, 'store'])->name('post.comment.create');
    Route::delete('/comments/{postComment}', [PostCommentController::class, 'destroy'])->name('post.comment.delete');
});

// Reaction Services
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts/{post}/reaction', [PostReactionController::class, 'store'])->name('post.reaction.create');
    Route::delete('/posts/{post}/reaction', [PostReactionController::class, 'destroy'])->name('post.reaction.delete');
});


// Follow Services
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/follow/{user}', [FollowController::class, 'store'])->name('user.follow');
    Route::post('/unfollow/{user}', [FollowController::class, 'destroy'])->name('user.unfollow');
    Route::post('/is_following/{user}', [FollowController::class, 'show'])->name('user.is_following');
});