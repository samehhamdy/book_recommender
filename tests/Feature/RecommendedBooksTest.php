<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecommendedBooksTest extends TestCase
{
    public function test_list_successful(): void
    {
        $response = $this->get('/api/recommended-books');
        $response->assertStatus(200);
    }
}
