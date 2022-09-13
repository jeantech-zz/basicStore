<?php

namespace Tests\Feature;

use App\Actions\Order\StoreOrderActions;
use App\Actions\OrderProduct\StoreUpdateOrderProductActions;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_action_order_product()
    {
        $order = StoreOrderActions::execute();
        $product = Product::factory()->create();
        $orderProduct = StoreUpdateOrderProductActions::execute( $order, $product);

        $this->assertSame((int)$orderProduct->product_id, 1);
        $this->assertSame((int)$orderProduct->quantity, 1);

    }
}
