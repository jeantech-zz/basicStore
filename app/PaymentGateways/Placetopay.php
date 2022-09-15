<?php

namespace App\PaymentGateways;

use App\Constants\Constants;
use App\Constants\PaymentGateways\PaymentGatewayConstants;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Placetopay implements PaymentGatewayContract
{
    /**
     * @string
     */

    private $ipAddress;
    private $userAgent;
    private $url;
    private $loginPlacetoPay;

    public function __construct()
    {
        $this->ipAddress = PaymentGatewayConstants::IP_ADDRESS_PLACETOPAY;
        $this->userAgent = PaymentGatewayConstants::USER_AGENT_PLACETOPAY;
        $this->url = PaymentGatewayConstants::URL_PLACETOPAY;
        $this->loginPlacetoPay = PaymentGatewayConstants::LOGIN_PLACETOPAY;
    }

    public function createSession(array $dataPay)
    {
        $request = $this->makeRequest($dataPay);

        $response = Http::post($this->url, $request);

        return json_decode($response->body(), true);
    }


    private function makeRequest(array $data): array
    {
        $auth = $this->makeAuth();
        $payment = $this->makePayment($data);
        $extraAttributes = $this->extraAttributes($data);

        return [
            "auth" => $auth,
            "payment" =>  $payment,
        ] +  $extraAttributes;
    }

    private function makeAuth(): array
    {
        $nonce = Str::random();
        $seed = Carbon::now(new DateTimeZone('America/Bogota'))->toIso8601String();

        $trankey = base64_encode(sha1($nonce . $seed . '024h1IlD', true));

        return [
            'login' => $this->loginPlacetoPay,
            'tranKey' => $trankey,
            'nonce' => base64_encode($nonce),
            'seed' => $seed,
        ];
    }

    private function makePayment(array $data): array
    {
        return [
            'reference' =>  $data['reference'],
            'description' =>  $data['description'],
            'amount' =>   [
                'currency' => $data['currency'],
                'total' =>  $data['total']
            ],
            'allowPartial' => false
        ];
    }

    private function extraAttributes(array $data): array
    {
        return [
            'expiration' => Carbon::now(new DateTimeZone('America/Bogota'))->addHour()->toIso8601String(),
            'returnUrl' => $data['returnUrl'],
            'ipAddress' =>  $this->ipAddress,
            'userAgent' => $this->userAgent
        ];
    }

    public function getSession(string $requestId, array $dataPay)
    {
        $request = $this->makeRequest($dataPay);
        $response = Http::post($this->url.'/'.$requestId, $request);

        return json_decode($response->body(), true);
    }
}
