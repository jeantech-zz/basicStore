<?php

namespace Tests\Feature;

use App\Actions\Order\StoreOrderActions;
use App\Constants\Constants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class OrderTest extends TestCase
{
    public function test_order_screen_can_be_rendered():void
    {
        $response = $this->get('orders');

        $response->assertStatus(200);
    }

    public function test_create_action_order()
    {
        $order = StoreOrderActions::execute();

        $this->assertSame((int)$order->total, 1);
        $this->assertSame((string)$order->status, "INPROCESS");
        $this->assertSame((string)$order->currency,"COP");
    }
}
