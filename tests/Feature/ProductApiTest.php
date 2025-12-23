<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_login()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['access_token']);
    }

    public function test_authenticated_user_can_create_product()
    {
        // 1. Create a user
        $user = User::factory()->create();

        // 2. Login (Explicitly use 'api' to get the JWT String)
        $token = auth('api')->login($user);

        // 3. Try to create a product using that token
        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->postJson('/api/products', [
                             'name' => 'Test Product',
                             'quantity' => 10,
                             'unit_price' => 99.99,
                             'description' => 'A test description'
                         ]);

        // 4. Assert: Expect a "201 Created" status
        $response->assertStatus(201);
        
        // 5. Assert: Check if it's actually in the database
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }
}