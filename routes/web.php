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

Route::middleware('auth')->group(function () {
    Route::get('/me', [UserController::class, 'me']);
    Route::patch('/me', [UserController::class, 'update']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::delete('/me', [UserController::class, 'destroy']);
    Route::delete('/users/{id}', [UserController::class, 'destroyUser']);

    Route::apiResource('roles', RoleController::class);
});

// Threads
Route::middleware('auth')->group(function () {
    Route::get('/threads', [ThreadController::class, 'index']);
    Route::post('/threads', [ThreadController::class, 'store']);
    Route::get('/threads/{thread}', [ThreadController::class, 'show']);
    Route::put('/threads/{thread}', [ThreadController::class, 'update']);
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy']);
});

// Posts
Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});

// Categories
Route::middleware('auth')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']); // только админ/овнер
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']); // только админ/овнер
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']); // только админ/овнер
});

// Attachments
Route::middleware('auth')->group(function () {
    Route::get('/attachments', [AttachmentController::class, 'index']);
    Route::post('/attachments', [AttachmentController::class, 'store']); // любой авторизованный
    Route::get('/attachments/{attachment}', [AttachmentController::class, 'show']);
    Route::put('/attachments/{attachment}', [AttachmentController::class, 'update']); // владелец или админ/овнер
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy']); // владелец или админ/овнер
});

// Permissions
Route::middleware('auth')->group(function () {
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::post('/permissions', [PermissionController::class, 'store']); // только админ
    Route::get('/permissions/{permission}', [PermissionController::class, 'show']);
    Route::put('/permissions/{permission}', [PermissionController::class, 'update']); // только админ
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy']); // только админ
});
