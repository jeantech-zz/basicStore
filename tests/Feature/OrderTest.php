<?php

namespace Tests\Feature;

use App\Actions\Order\StoreOrderActions;
use App\Actions\Order\UpdateOrderActions;
use App\Actions\OrderProduct\StoreUpdateOrderProductActions;
use App\Constants\Constants;
use App\Models\Product;
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

    public function test_update_action_order()
    {
        $order = StoreOrderActions::execute();
        $product = Product::factory()->create();
        $orderProduct = StoreUpdateOrderProductActions::execute( $order, $product);

        $statusInprocess =  Constants::STATUS_ORDER_INPROCESS;
        $data = [
            'customer_name' => "Jennifer",
            'customer_email' => "jeante04@gmail.com",
            'customer_mobile' => "31242424",
            'currency' => "EUP",
            'status' => $statusInprocess,
        ];

        $order = UpdateOrderActions::execute( $order, $data );
        $this->assertTrue($order);

    }


}
