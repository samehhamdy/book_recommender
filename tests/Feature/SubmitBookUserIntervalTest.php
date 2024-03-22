<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class SubmitBookUserIntervalTest extends TestCase
{
    public function test_interval_creation_invalid_data()
    {
        $payload = [
            'user_id' => 1,
            'book_id' => 1,
            // Missing 'start_page' and 'end_page'
        ];
        $response = $this->postJson('/api/new-read-interval', $payload);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['start_page', 'end_page']);
    }

    public function test_interval_creation_user_not_found()
    {
        $payload = [
            'user_id' => 999, // User with ID 999 does not exist
            'book_id' => 1,
            'start_page' => 1,
            'end_page' => 10,
        ];
        $response = $this->postJson('/api/new-read-interval', $payload);
        $response->assertStatus(422);
    }

    public function test_interval_creation_missing_book()
    {
        $user = User::first();
        $payload = [
            'user_id' => $user->id,
            // Missing 'book_id', 'start_page', and 'end_page'
        ];
        $response = $this->postJson('/api/new-read-interval', $payload);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['book_id', 'start_page', 'end_page']);
    }

    public function test_interval_creation_successful_notification()
    {
        $user = User::first();
        $payload = [
            'user_id' => $user->id,
            'book_id' => 1,
            'start_page' => 1,
            'end_page' => 10,
        ];
        $response = $this->postJson('/api/new-read-interval', $payload);
        $response->assertStatus(200)
            ->assertJson(['message' => 'Interval created successfully.']);
    }
}
