<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;


Route::get('/', function () {
    return view('layouts.app');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', [UserController::class, 'profile'])->name('profile');

Route::resource('users', UserController::class);

Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); 

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::resource('posts', PostController::class)->middleware('auth');

Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts/confirm', [PostController::class, 'confirm'])->name('posts.confirm');

Route::post('/posts/store-final', [PostController::class, 'storeFinal'])->name('posts.storeFinal');

Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');

Route::get('posts/{id}/confirm-edit', [PostController::class, 'confirmEdit'])->name('posts.confirmEdit');

Route::post('posts/{id}/store-update', [PostController::class, 'storeUpdate'])->name('posts.storeUpdate');


Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');


Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');


Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');











