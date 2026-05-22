<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCreationTest extends TestCase
{
    use RefreshDatabase;

    private function validBookData(): array
    {
        return [
            'title' => 'Le Petit Prince',
            'author' => 'Antoine de Saint-Exupéry',
            'summary' => 'Un conte poétique et philosophique sous apparence de livre pour enfants.',
            'isbn' => '9782070612758',
        ];
    }

    public function test_book_is_created_in_database_with_valid_data(): void
    {
        $user = User::factory()->create();

        $data = $this->validBookData();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/books', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('books', [
            'title' => $data['title'],
            'author' => $data['author'],
            'summary' => $data['summary'],
            'isbn' => $data['isbn'],
        ]);
    }

    public function test_book_is_not_created_with_invalid_data(): void
    {
        $user = User::factory()->create();

        $data = $this->validBookData();
        $data['title'] = 'AB';

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/books', $data);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('books', [
            'isbn' => $data['isbn'],
        ]);
    }

    public function test_book_is_not_created_when_user_is_not_authenticated(): void
    {
        $data = $this->validBookData();

        $response = $this->postJson('/api/v1/books', $data);

        $response->assertStatus(401);

        $this->assertDatabaseMissing('books', [
            'isbn' => $data['isbn'],
        ]);
    }
}
