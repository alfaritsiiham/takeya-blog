<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;

class PostController extends Controller{
    public function insertOrUpdate(Request $request){
        $act = $request->act;

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:60',
            'content' => 'required',
            'post_schedule' => 'required',
            'published_at' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if($act == "insert"){
            $post = new Post;
        }else{
            $post = Post::where('id', $request->id)->first();
        }

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

        $post->status = $status;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->author = auth()->user()->id;
        $post->publish_date = $published_at;
        $post->save();

        return redirect()->route('home');
    }
}
