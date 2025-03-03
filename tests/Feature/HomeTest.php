<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase{
    public function home_page_is_accessible(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
