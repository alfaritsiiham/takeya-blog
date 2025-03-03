<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Models\Post;

Route::get('/', function () {
    $posts = null;
    if(auth()->check()){
        $posts = Post::with('user')->where('author', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
    }

    return view('home', ['posts' => $posts]);
})->name('home');

Route::get('/posts', function () {
    $posts = Post::with('user')->where('status', Post::STATUS_PUBLISHED)->orderBy('publish_date', 'desc')->paginate(10);

    return view('posts.index', ['posts' => $posts]);
})->name('posts.index');

Route::get('/posts/show/{slug}', function ($slug) {
    $post = Post::with('user')->where('slug', $slug)->first();

    return view('posts.show', ['post' => $post]);
})->name('posts.show');

Route::middleware('auth')->group(function () {
    Route::get('/posts/create', function () {
        $act = "insert";
        return view('posts.create', ['act' => $act]);
    })->name('posts.create');

    Route::get('/posts/edit/{slug}', function ($slug) {
        $act = "edit";
        $post = Post::with('user')->where('author', auth()->user()->id)->where('slug', $slug)->first();
        if($post == null){
            abort(404);
        }

        return view('posts.edit', ['act' => $act, 'post' => $post]);
    })->name('posts.edit');

    Route::delete('/posts/delete/{slug}', function ($slug) {
        $post = Post::with('user')->where('author', auth()->user()->id)->where('slug', $slug)->first();
        if($post == null){
            abort(404);
        }

        $post->delete();

        return redirect()->route('home');
    })->name('posts.delete');

    Route::post('/posts/insertOrUpdate', [PostController::class, 'insertOrUpdate'])->name('posts.insertOrUpdate');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
