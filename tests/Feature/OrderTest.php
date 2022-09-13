<?php

namespace Tests\Feature;

use App\Actions\Order\StoreOrderActions;
use App\Actions\Order\UpdateOrderActions;
use App\Actions\OrderProduct\StoreUpdateOrderProductActions;
use App\Constants\Constants;
use App\Models\Product;
use App\Models\User;
use App\PaymentGateways\Placetopay;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_screen_can_be_rendered(): void
    {
        $response = $this->get('orders');

        $response->assertStatus(200);
    }

    public function test_create_action_order()
    {
        $user = User::factory()->create();
        $order = StoreOrderActions::execute($user->id);

        $this->assertSame((int)$order->total, 1);
        $this->assertSame((string)$order->status, "INPROCESS");
        $this->assertSame((string)$order->currency, "COP");
    }

    public function test_update_action_order()
    {
        $user = User::factory()->create();
        $order = StoreOrderActions::execute($user->id);
        $product = Product::factory()->create();
        $orderProduct = StoreUpdateOrderProductActions::execute($order, $product);

        $statusInprocess =  Constants::STATUS_ORDER_INPROCESS;
        $data = [
            'customer_name' => "Jennifer",
            'customer_email' => "jeante04@gmail.com",
            'customer_mobile' => "31242424",
            'currency' => "EUP",
            'status' => $statusInprocess,
        ];

        $order = UpdateOrderActions::execute($order, $data);
        $this->assertTrue($order);
    }

    public function test_edit_order_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $order = StoreOrderActions::execute($user->id);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('orders.edit', $order));
        //$response = $this->get(route('orders.edit', $order));

        $response->assertStatus(200);
    }

    public function test_payment_geteway()
    {
        $arrayPay = [
            'reference' => 1,
            'total' => 1000,
            'returnUrl' =>  Constants::URL_RETURN_PLACETOPAY . '/1',
            'description' => Constants::DESCRIPTION_PLACETOPAY . " 1",
            'currency' => Constants::CURRENCY
        ];

        $paymentGeteway = new Placetopay();

        $response = $paymentGeteway->createSession($arrayPay);

        $this->assertSame((string)$response['status']['status'], "OK");
    }
}
