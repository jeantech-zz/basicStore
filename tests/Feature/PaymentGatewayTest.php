<?php

namespace Tests\Feature;

use App\Constants\Constants;
use App\PaymentGateways\Placetopay;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentGatewayTest extends TestCase
{
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

    public function test_get_payment_geteway()
    {
        $arrayPay = [
            'reference' => 1,
            'total' => 1000,
            'returnUrl' =>  Constants::URL_RETURN_PLACETOPAY . '/1',
            'description' => Constants::DESCRIPTION_PLACETOPAY . " 1",
            'currency' => Constants::CURRENCY
        ];
        $paymentGeteway = new Placetopay();
        $responsePay = $paymentGeteway->createSession($arrayPay);

        $responseGetPay = $paymentGeteway->getSession($responsePay['requestId'],  $arrayPay );

        $this->assertSame((int)$responseGetPay['requestId'], $responsePay['requestId']);
        $this->assertSame((string)$responseGetPay['status']['status'], "PENDING");
    }

}
