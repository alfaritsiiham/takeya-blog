<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

use App\Models\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller{
    public function home(){
        $posts = auth()->check()
            ? Post::with('user')->where('author', auth()->id())->latest()->paginate(10)
            : null;

        return view('home', compact('posts'));
    }

    public function index(){
        $posts = Post::with('user')->where('status', Post::STATUS_PUBLISHED)->orderBy('publish_date', 'desc')->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post){
        return view('posts.show', compact('post'));
    }

    public function create(){
        return view('posts.create', ['act' => 'insert']);
    }

    public function edit(Post $post) {
        if (Gate::denies('update', $post)) {
            abort(403);
        }

        return view('posts.edit', ['act' => 'edit', 'post' => $post]);
    }

    public function destroy(Post $post) {
        if (Gate::denies('update', $post)) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('home');
    }

    public function insertOrUpdate(PostRequest $request){
        $post = $request->act === 'insert' ? new Post : Post::findOrFail($request->id);

        if($request->post_schedule == 0){
            $status = Post::STATUS_DRAFT;
            $published_at = null;
        }else if($request->post_schedule == 1){
            $status = Post::STATUS_SCHEDULED;
            $published_at = $request->published_at;
        }else if($request->post_schedule == 2){
            $status = Post::STATUS_PUBLISHED;
            $published_at = now();
        }

        $post->fill([
            'status' => $status,
            'title' => $request->title,
            'content' => $request->content,
            'author' => auth()->id(),
            'publish_date' => $published_at,
        ])->save();

        return redirect()->route('home');
    }
}
