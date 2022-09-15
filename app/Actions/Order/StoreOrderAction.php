<?php

namespace App\Actions\Order;

use App\Constants\Constants;
use App\Models\Order;

class StoreOrderAction
{
    public static function execute($userId): Order
    {
        $statusInprocess =  Constants::STATUS_ORDER_CREATED;
        $currency = Constants::CURRENCY;

        $order = Order::firstOrCreate([
            'user_id' => $userId,
            'total' => 1,
            'status' => $statusInprocess,
            'currency' => $currency,
        ]);
        return  $order;
    }
}
