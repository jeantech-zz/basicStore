<?php

namespace Tests\Feature;

use App\Actions\Order\StoreOrderActions;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_product_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $response =$this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(200);
    }

    public function test_add_product_order_screen_can_be_rendered()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();
        $response =$this->actingAs($user)->post('products/addProductOrder/' . $product->id);

        $response->assertRedirect(route('orders.index'));
    }
}
