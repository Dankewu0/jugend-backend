<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/threads/popular', [ThreadController::class, 'popular']);

Route::middleware('auth')->group(function () {
    Route::get('/me', [UserController::class, 'me']);
    Route::patch('/me', [UserController::class, 'update']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::delete('/me', [UserController::class, 'destroy']);
    Route::delete('/users/{id}', [UserController::class, 'destroyUser']);

    Route::apiResource('roles', RoleController::class);
    Route::apiResource('threads', ThreadController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('attachments', AttachmentController::class);
    Route::apiResource('permissions', PermissionController::class);
});
