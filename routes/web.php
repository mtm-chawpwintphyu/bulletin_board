<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;


Route::get('/', function () {
    return view('layouts.app');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('users', UserController::class);
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::resource('posts', PostController::class)->middleware('auth');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts/confirm', [PostController::class, 'confirm'])->name('posts.confirm');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::get('/posts/{id}/confirm-edit', [PostController::class, 'confirmEdit'])->name('posts.confirm-edit');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');












