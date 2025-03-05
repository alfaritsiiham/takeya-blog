<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class PublishScheduledPosts implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(){
        $now = Carbon::now();

        $posts = Post::where('status', Post::STATUS_SCHEDULED)
            ->where('publish_date', '<=', $now)
            ->get();

        foreach ($posts as $post) {
            $post->status = Post::STATUS_PUBLISHED;
            $post->save();
        }
    }
}
