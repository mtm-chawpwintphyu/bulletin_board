<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\TestMailController;
use Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::middleware('auth')->group(function () {

    Route::get('/users', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/confirm', [UserController::class, 'confirm'])->name('users.confirm');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::get('users/{id}/change-password', [UserController::class, 'showPasswordForm'])->name('users.password');
    Route::post('/users/{id}/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');

    Route::resource('posts', PostController::class)->except(['index', 'create', 'edit']);
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/importcsv', [PostController::class, 'importcsv'])->name('importcsv');
    Route::post('/upload', [PostController::class, 'upload'])->name('upload');
    Route::get('download', [PostController::class, 'download'])->name('download');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/create', [PostController::class, 'create'])->name('create');
    Route::post('/confirm', [PostController::class, 'confirm'])->name('confirm');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('/posts/{id}/confirm-edit', [PostController::class, 'confirmEdit'])->name('posts.confirm-edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

});

























