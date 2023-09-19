<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ReplyController;
use App\Http\Controllers\API\UserDetailsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

//create post routes

Route::controller(PostController::class)->group(function () {
    Route::post('create-post', [PostController::class, 'createPost']);
    Route::post('delete-post', [PostController::class, 'deletePost']);
    Route::post('update-post', [PostController::class, 'updatePost']);
});

//create reply routes

Route::controller(ReplyController::class)->group(function () {
    Route::post('create-reply', [ReplyController::class, 'createReply']);
    Route::post('delete-reply', [ReplyController::class, 'deleteReply']);
});

//create user details routes

Route::controller(UserDetailsController::class)->group(function () {
    Route::post('add-user-details', [UserDetailsController::class, 'addUserDetails']);
    Route::post('update-user-details', [UserDetailsController::class, 'updateUserDetails']);
});
