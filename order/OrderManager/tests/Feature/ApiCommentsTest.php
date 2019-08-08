<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class ApiCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_order_does_not_have_comments()
    {
        $description = 'Sample description text';
        $this->postJson('/orders', compact('description'));

        $this->getJson('/orders/1')
            ->assertJsonCount(0, 'comments');

        $this->assertEquals(0, DB::table('comments')->count());
    }

    public function test_create_comment()
    {
        $description = 'Sample description text';
        $this->postJson('/orders', compact('description'));

        $content = 'Sample comment text';
        $this->postJson('/orders/1/comments', compact('content'))
            ->assertStatus(201);

        $this->getJson('/orders/1')
            ->assertJsonCount(1, 'comments')
            ->assertJsonStructure([
                'comments' => [
                    ['content']
                ]
            ])
            ->assertJsonFragment(compact('content'));

        $this->assertEquals(1, DB::table('comments')->count());
        $this->assertDatabaseHas('comments', compact('content'));
    }

    public function test_can_not_create_comment_with_empty_content()
    {
        $description = 'Sample description text';
        $this->postJson('/orders', compact('description'));

        $content = '';
        $this->postJson('/orders/1/comments', compact('content'))
            ->assertStatus(422);

        $this->assertEquals(0, DB::table('comments')->count());
    }
}
