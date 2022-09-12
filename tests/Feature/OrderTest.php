<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_order_screen_can_be_rendered():void
    {
        $response = $this->get('orders');

        $response->assertStatus(200);
    }
}
