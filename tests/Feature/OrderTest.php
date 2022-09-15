<?php

namespace Tests\Feature;

use App\Actions\Order\PayOrderAction;
use App\Actions\Order\StoreOrderAction;
use App\Actions\Order\UpdateOrderAction;
use App\Actions\OrderProduct\StoreUpdateOrderProductActions;
use App\Constants\Constants;
use App\Models\Product;
use App\Models\User;
use App\PaymentGateways\Placetopay;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_index_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $response =$this->actingAs($user)->get(route('orders.index'));

        $response->assertStatus(200);
    }

    public function test_edit_order_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $order = StoreOrderAction::execute($user->id);
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('orders.edit', $order));
        $response->assertStatus(200);
    }

    public function test_order_pay_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $order = StoreOrderAction::execute($user->id);
        $response = $this->actingAs($user)->post(route('orders.orderPay', $order));

        $this->assertEquals("http://localhost", $response->getTargetUrl());

    }

    public function test_show_order_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $order = StoreOrderAction::execute($user->id);

        $arrayPay = [
            'reference' => $order->id,
            'total' => $order->total,
            'returnUrl' => Constants::URL_RETURN_PLACETOPAY. '/' . $order->id,
            'description' =>  Constants::DESCRIPTION_PLACETOPAY . $order->id,
            'currency' => $order->currency
        ];

        $dataOrder = [
            'id' =>  $order->id,
            'total' =>  $order->total,
            'currency' =>  $order->currency,
        ];

        $paymentGeteway = new Placetopay();
        PayOrderAction::execute($arrayPay, $dataOrder, $paymentGeteway);

        $response = $this->actingAs($user)->get('orders/showOrder/'.$order->id);
        $response->assertStatus(200);

    }

    public function test_create_action_order()
    {
        $user = User::factory()->create();
        $order = StoreOrderAction::execute($user->id);

        $this->assertSame((int)$order->total, 1);
        $this->assertSame((string)$order->status, "CREATED");
        $this->assertSame((string)$order->currency, "COP");
    }

    public function test_update_action_order()
    {
        $user = User::factory()->create();
        $order = StoreOrderAction::execute($user->id);
        $product = Product::factory()->create();
        $orderProduct = StoreUpdateOrderProductActions::execute($order, $product);

        $statusCreate =  Constants::STATUS_ORDER_CREATED;
        $data = [
            'customer_name' => "Jennifer",
            'customer_email' => "jeante04@gmail.com",
            'customer_mobile' => "31242424",
            'currency' => "EUP",
            'status' => $statusCreate,
        ];

        $order = UpdateOrderAction::execute($order, $data);
        $this->assertTrue($order);
    }

    public function test_pay_order_action_order()
    {
        $user = User::factory()->create();
        $order = StoreOrderAction::execute($user->id);

        $arrayPay = [
            'reference' => $order->id,
            'total' => $order->total,
            'returnUrl' => Constants::URL_RETURN_PLACETOPAY. '/' . $order->id,
            'description' =>  Constants::DESCRIPTION_PLACETOPAY . $order->id,
            'currency' => $order->currency
        ];

        $dataOrder = [
            'id' =>  $order->id,
            'total' =>  $order->total,
            'currency' =>  $order->currency,
        ];

        $paymentGeteway = new Placetopay();
        $response = PayOrderAction::execute($arrayPay, $dataOrder, $paymentGeteway);

        $urlRedirect = substr($response->getTargetUrl(),0,43);
        $this->assertEquals( Constants::URL_REDIRECT_PLACETOPAY, $urlRedirect);
    }

}
