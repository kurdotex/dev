<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ApiOrderTest extends TestCase
{
    use RefreshDatabase;

    protected function getValidOrderPayload()
    {
        return [
            'customer_first_name' => 'Test',
            'customer_last_name' => 'User',
            'customer_email' => 'test@phpunit.com',
            'payment_method' => 'credit_card',
            'items' => [
                [
                    'product_name' => 'Monitor',
                    'quantity' => 2,
                    'unit_price' => 100.50
                ],
                [
                    'product_name' => 'Teclado',
                    'quantity' => 1,
                    'unit_price' => 50.00
                ]
            ]
        ];
    }

    /** @test */
    public function test_authenticated_user_can_create_an_order()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $payload = $this->getValidOrderPayload();
        $response = $this->postJson('/api/list/orders', $payload);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'status', 'message', 'data'
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_email' => 'test@phpunit.com',
            'user_id' => $user->id,
            'total_amount' => 251.00
        ]);
    }

    /** @test */
    public function test_unauthenticated_user_cannot_create_an_order()
    {

        $payload = $this->getValidOrderPayload();
        $response = $this->postJson('/api/list/orders', $payload);
        $response->assertStatus(401);

        $this->assertDatabaseMissing('orders', [
            'customer_email' => 'test@phpunit.com'
        ]);
    }

    /** @test */
    public function test_order_fails_with_missing_required_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $invalidPayload = [
            'customer_last_name' => 'User',
            'customer_email' => 'invalid@phpunit.com',
            'payment_method' => 'credit_card',
            // 'items'
        ];

        $response = $this->postJson('/api/list/orders', $invalidPayload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['items']);
    }
}
