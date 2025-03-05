<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $user = User::first();

        if (!$user) {
            $this->command->error('No users found! Run DatabaseSeeder first.');
            return;
        }

        Post::insert([
            [
                'slug' => Str::slug('First Post'),
                'status' => Post::STATUS_PUBLISHED,
                'title' => 'First Post',
                'content' => 'This is the content of the first post.',
                'author' => $user->id, // Pastikan ID user valid
                'publish_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'slug' => Str::slug('Second Post'),
                'status' => Post::STATUS_DRAFT,
                'title' => 'Second Post',
                'content' => 'This is the content of the second post.',
                'author' => $user->id,
                'publish_date' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'slug' => Str::slug('Third Post'),
                'status' => Post::STATUS_SCHEDULED,
                'title' => 'Third Post',
                'content' => 'This is the content of the third post.',
                'author' => $user->id,
                'publish_date' => Carbon::now()->addDays(4),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
