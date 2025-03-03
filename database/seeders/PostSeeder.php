<?php

namespace Database\Seeders;

use DB;
use Str;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        DB::table('posts')->insert([
            [
                'id' => 1,
                'slug' => Str::slug('First Post'),
                'status' => Post::STATUS_PUBLISHED,
                'title' => 'First Post',
                'content' => 'This is the content of the first post.',
                'author' => 1,
                'publish_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'slug' => Str::slug('Second Post'),
                'status' => Post::STATUS_DRAFT,
                'title' => 'Second Post',
                'content' => 'This is the content of the second post.',
                'author' => 1,
                'publish_date' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'slug' => Str::slug('Third Post'),
                'status' => Post::STATUS_SCHEDULED,
                'title' => 'Third Post',
                'content' => 'This is the content of the third post.',
                'author' => 1,
                'publish_date' => Carbon::now()->addDays(4),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
