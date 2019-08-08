<?php

namespace Tests\Feature;

use App\Models\Status;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Tests\Utils\DbTruncator;

class ApiOrdersTest extends TestCase
{
//    use RefreshDatabase;
    use DbTruncator;

    public function test_initial_collection_empty()
    {
        $this->truncateOrders();
        $this->getJson('/api/orders')
            ->assertStatus(200)
            ->assertJsonCount(0);
    }

    public function test_create_order()
    {
        $description = 'Sample description text';

        $this->postJson('/api/orders', compact('description'))
            ->assertStatus(201)
            ->assertJsonFragment(compact('description'));

        $this->assertEquals(1, DB::table('orders')->count());
        $this->assertDatabaseHas('orders', compact('description'));
    }

    public function test_can_not_create_order_with_empty_description()
    {
        $this->postJson('/api/orders', [])
            ->assertStatus(422);

        $this->assertEquals(1, DB::table('orders')->count());
    }

    public function test_order_status_always_initial()
    {
        $description = 'Sample description text';
        $status_id = Status::IN_WORK;
        $name='в работе';
        $this->postJson('/api/orders', compact('description', 'status_id'))
            ->assertStatus(201)
            ->assertJsonFragment(compact('description'))
            ->assertJsonFragment(['name' => 'новая'])
            ->assertJsonMissing(compact('name'));

        //$this->assertDatabaseHas('orders', ['status' => Status::CREATED]);
        //$this->assertDatabaseMissing('orders', compact('status'));
    }

    public function test_get_order()
    {
        $description = 'Sample description text';
        $this->postJson('/api/orders', compact('description'));

        $this->getJson('/api/orders/3')
            ->assertStatus(200)
            ->assertJsonFragment(compact('description'))
            ->assertJsonFragment(['name' => 'новая']);

        $this->getJson('/api/orders/3')
            ->assertStatus(200)
            ->assertJsonCount(6)
            ->assertJsonFragment(compact('description'));
    }



    public function test_update_order_status()
    {
        $description = 'Sample description text';
        $this->postJson('/api/orders', compact('description'));

        $initialStatus = Status::CREATED;
        $updatedStatus = Status::IN_WORK;
        $this->patchJson('/api/orders/4', ['status_id' => $updatedStatus])
            ->assertStatus(200)
            ->assertJsonFragment(['status_id' => $updatedStatus])
            ->assertJsonMissing(['status_id' => $initialStatus]);

        $this->getJson('/api/orders/4')
            ->assertJsonFragment(['status_id' => $updatedStatus])
            ->assertJsonMissing(['status_id' => $initialStatus]);

     //   $this->assertDatabaseHas('orders', ['status' => $updatedStatus]);
      //  $this->assertDatabaseMissing('orders', ['status' => $initialStatus]);
    }

    public function test_can_not_update_order_invalid_status()
    {
        $description = 'Sample description text';
        $this->postJson('/api/orders', compact('description'));

        $initialStatus = Status::CREATED;
        $updatedStatus = 6;
        $this->patchJson('/api/orders/5', ['status_id' => $updatedStatus])
            ->assertStatus(422);

        $this->getJson('/api/orders/5')
            ->assertJsonFragment(['status_id' => $initialStatus])
            ->assertJsonMissing(['status_id' => $updatedStatus]);

       // $this->assertDatabaseHas('orders', ['status' => $initialStatus]);
      //  $this->assertDatabaseMissing('orders', ['status' => $updatedStatus]);
    }

    public function test_delete_order()
    {
        $description = 'Sample description text to Delete';
        $this->postJson('/api/orders', compact('description'));

        $this->getJson('/api/orders')
            ->assertJsonCount(6);

        $this->assertEquals(6, DB::table('orders')->count());
        $this->assertDatabaseHas('orders', compact('description'));

        $this->deleteJson('/api/orders/6')
            ->assertStatus(200);

        $this->getJson('/api/orders')
            ->assertJsonCount(5);

        $this->getJson('/api/orders/6')
            ->assertStatus(404);

        $this->assertEquals(5, DB::table('orders')->count());
        $this->assertDatabaseMissing('orders', compact('description'));
    }
}
