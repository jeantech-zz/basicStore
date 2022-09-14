<?php

namespace App\Actions\Order;

use App\Constants\Constants;
use App\Models\Order;

class StoreOrderActions
{
    public static function execute($userId): Order
    {
        $statusInprocess =  Constants::STATUS_ORDER_CREATED;
        $currency = Constants::CURRENCY;

        $order = Order::Where('user_id', auth()->id())
            ->Where('status', $statusInprocess)->first();

        if (!$order) {
            $order = Order::create([
                'user_id' => $userId,
                'total' => 1,
                'status' => $statusInprocess,
                'currency' => $currency,
            ]);
        }
        return  $order;
    }
}
