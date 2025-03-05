<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'home'])->name('home');

// Posts
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/show/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::middleware('auth')->prefix('posts')->group(function () {
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/edit/{post:slug}', [PostController::class, 'edit'])->name('posts.edit');
    Route::delete('/{post:slug}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/insertOrUpdate', [PostController::class, 'insertOrUpdate'])->name('posts.insertOrUpdate');
});

// Profile
Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
