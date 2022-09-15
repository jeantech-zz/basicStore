<?php

namespace Tests\Feature;

use App\Actions\Order\StoreOrderAction;
use App\Actions\Request\StoreRequestActions;
use App\Constants\Constants;
use App\Constants\PaymentGateways\PaymentGatewayConstants;
use App\Models\User;
use App\PaymentGateways\Placetopay;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use RefreshDatabase;
    public function test_store_request_actions()
    {
        $user = User::factory()->create();
        $order = StoreOrderAction::execute($user->id);
        $arrayPay = [
            'reference' => 1,
            'total' => 1000,
            'returnUrl' =>  PaymentGatewayConstants::URL_RETURN_PLACETOPAY . '/1',
            'description' => PaymentGatewayConstants::DESCRIPTION_PLACETOPAY . " 1",
            'currency' => PaymentGatewayConstants::CURRENCY
        ];

        $paymentGeteway = new Placetopay();

        $responsePay = $paymentGeteway->createSession($arrayPay);

        $data = [
            'order_id' => $order->id,
            'reference' => "1",
            'returnUrl' => PaymentGatewayConstants::URL_RETURN_PLACETOPAY,
            'description' => PaymentGatewayConstants::DESCRIPTION_PLACETOPAY,
            'response' => json_encode($responsePay),
            'processUrl' => $responsePay['processUrl'],
            'requestId' => $responsePay['requestId']
        ];

        $requestAction = StoreRequestActions::execute($data);

        $this->assertSame((int)$requestAction->order_id, $order->id);
        $this->assertSame((int)$requestAction->requestId, $responsePay['requestId']);
    }
}
