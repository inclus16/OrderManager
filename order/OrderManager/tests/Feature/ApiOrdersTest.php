<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Order;
use Illuminate\Support\Facades\DB;

class ApiOrdersTest extends TestCase
{
    use RefreshDatabase;

    public function test_initial_collection_empty()
    {
        $this->getJson('/orders')
            ->assertStatus(200)
            ->assertJsonCount(0);
    }

    public function test_create_order()
    {
        $description = 'Sample description text';

        $this->postJson('/orders', compact('description'))
            ->assertStatus(201)
            ->assertJsonFragment(compact('description'));

        $this->assertEquals(1, DB::table('orders')->count());
        $this->assertDatabaseHas('orders', compact('description'));
    }

    public function test_can_not_create_order_with_empty_description()
    {
        $this->postJson('/orders', [])
            ->assertStatus(422);

        $this->assertEquals(0, DB::table('orders')->count());
    }

    public function test_order_status_always_initial()
    {
        $description = 'Sample description text';
        $status = Order::$allowedStatuses[1];

        $this->postJson('/orders', compact('description', 'status'))
            ->assertStatus(201)
            ->assertJsonFragment(compact('description'))
            ->assertJsonFragment(['status' => Order::$allowedStatuses[0]])
            ->assertJsonMissing(compact('status'));

        $this->assertDatabaseHas('orders', ['status' => Order::$allowedStatuses[0]]);
        $this->assertDatabaseMissing('orders', compact('status'));
    }

    public function test_get_order()
    {
        $description = 'Sample description text';
        $this->postJson('/orders', compact('description'));

        $this->getJson('/orders/1')
            ->assertStatus(200)
            ->assertJsonFragment(compact('description'))
            ->assertJsonFragment(['status' => Order::$allowedStatuses[0]]);

        $this->getJson('/orders')
            ->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment(compact('description'));
    }

    public function test_update_order_description()
    {
        $description = 'Sample description text';
        $this->postJson('/orders', compact('description'));

        $updatedDescription = 'Updated description text';
        $this->patchJson('/orders/1', ['description' => $updatedDescription])
            ->assertStatus(200)
            ->assertJsonFragment(['description' => $updatedDescription])
            ->assertJsonMissing(compact('description'));

        $this->getJson('/orders/1')
            ->assertJsonFragment(['description' => $updatedDescription]);

        $this->assertDatabaseHas('orders', ['description' => $updatedDescription]);
    }

    public function test_update_order_status()
    {
        $description = 'Sample description text';
        $this->postJson('/orders', compact('description'));

        $initialStatus = Order::$allowedStatuses[0];
        $updatedStatus = Order::$allowedStatuses[1];
        $this->patchJson('/orders/1', ['status' => $updatedStatus])
            ->assertStatus(200)
            ->assertJsonFragment(['status' => $updatedStatus])
            ->assertJsonMissing(['status' => $initialStatus]);

        $this->getJson('/orders/1')
            ->assertJsonFragment(['status' => $updatedStatus])
            ->assertJsonMissing(['status' => $initialStatus]);

        $this->assertDatabaseHas('orders', ['status' => $updatedStatus]);
        $this->assertDatabaseMissing('orders', ['status' => $initialStatus]);
    }

    public function test_can_not_update_order_invalid_status()
    {
        $description = 'Sample description text';
        $this->postJson('/orders', compact('description'));

        $initialStatus = Order::$allowedStatuses[0];
        $updatedStatus = 'несуществующий_статус';
        $this->patchJson('/orders/1', ['status' => $updatedStatus])
            ->assertStatus(422);

        $this->getJson('/orders/1')
            ->assertJsonFragment(['status' => $initialStatus])
            ->assertJsonMissing(['status' => $updatedStatus]);

        $this->assertDatabaseHas('orders', ['status' => $initialStatus]);
        $this->assertDatabaseMissing('orders', ['status' => $updatedStatus]);
    }

    public function test_delete_order()
    {
        $description = 'Sample description text';
        $this->postJson('/orders', compact('description'));

        $this->getJson('/orders')
            ->assertJsonCount(1);

        $this->assertEquals(1, DB::table('orders')->count());
        $this->assertDatabaseHas('orders', compact('description'));

        $this->deleteJson('/orders/1')
            ->assertStatus(200);

        $this->getJson('/orders')
            ->assertJsonCount(0);

        $this->getJson('/orders/1')
            ->assertStatus(404);

        $this->assertEquals(0, DB::table('orders')->count());
        $this->assertDatabaseMissing('orders', compact('description'));
    }
}
