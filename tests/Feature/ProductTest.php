<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_product_screen_can_be_rendered():void
    {
        $response = $this->get('products/index');

        $response->assertStatus(200);
    }
}
