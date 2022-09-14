<?php

namespace App\PaymentGateways;

interface PaymentGatewayContract
{
    public function createSession(array $dataPay);

    public function getSession(string $requestId, array $dataPay);
}
