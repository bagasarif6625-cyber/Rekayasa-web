<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserApiFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_crud_api(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $create = $this->postJson('/api/users', [
            'name' => 'User AJAX',
            'email' => 'ajax@example.com',
            'password' => 'password123',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'role' => 'user',
        ]);

        $create->assertCreated()
            ->assertJsonPath('data.email', 'ajax@example.com');

        $userId = $create->json('data.id');

        $this->putJson("/api/users/{$userId}", [
            'name' => 'User AJAX Updated',
            'password' => 'newpassword123',
        ])
            ->assertOk()
            ->assertJsonPath('data.name', 'User AJAX Updated');

        $this->deleteJson("/api/users/{$userId}")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }

    public function test_user_api_requires_authentication(): void
    {
        $this->getJson('/api/users')->assertUnauthorized();
    }
}
