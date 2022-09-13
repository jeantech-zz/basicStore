<?php

namespace Tests\Feature;

use App\Actions\Order\StoreOrderActions;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_product_screen_can_be_rendered(): void
    {
        $response = $this->get('products/index');

        $response->assertStatus(200);
    }

    public function test_add_product_order_screen_can_be_rendered()
    {
        $product = Product::factory()->create();
        $response = $this->post('products/addProductOrder/' . $product->id);

        $response->assertRedirect(route('orders.index'));
    }
}
