<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase{
    use RefreshDatabase;

    public function posts_page_is_accessible()
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
    }

    public function user_can_create_a_post(){
        $postData = [
            'title' => 'Test Post',
            'slug' => 'test-post',
            'status' => 'published',
            'content' => 'This is a test post',
            'author' => 1,
            'publish_date' => now(),
        ];

        $response = $this->post('/posts/insertOrUpdate', $postData);
        $response->assertRedirect('/home');
        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }

    public function user_can_edit_a_post(){
        $post = \App\Models\Post::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'content' => 'Updated content',
        ];

        $response = $this->put("/posts/{$post->slug}", $updateData);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('posts', ['title' => 'Updated Title']);
    }

    public function user_can_delete_a_post(){
        $post = \App\Models\Post::factory()->create();

        $response = $this->delete("/posts/{$post->slug}");

        $response->assertRedirect('/home');
        $this->assertDatabaseMissing('posts', ['slug' => $post->slug]);
    }
}
