<?php

namespace App\PaymentGateways;

interface PaymentGatewayContract
{
    public function createSession(array $dataPay);


}
