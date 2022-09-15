<?php

namespace App\Actions\Order;

use App\Constants\PaymentGateways\PaymentGatewayConstants;
use App\Constants\Status\StatusConstants;
use App\Models\Order;

class StoreOrderAction
{
    public static function execute($userId): Order
    {
        $statusInprocess =  StatusConstants::STATUS_ORDER_CREATED;
        $currency = PaymentGatewayConstants::CURRENCY;

        $order = Order::firstOrCreate([
            'user_id' => $userId,
            'total' => 1,
            'status' => $statusInprocess,
            'currency' => $currency,
        ]);
        return  $order;
    }
}
