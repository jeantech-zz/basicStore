<?php

namespace App\Actions\Order;

use App\Constants\Constants;
use App\Models\Order;
use Illuminate\Support\Facades\Config;

class StoreOrderActions
{
    public static function execute(): Order
    {
        $statusInprocess =  Constants::STATUS_ORDER_INPROCESS;
        $currency = Constants::CURRENCY;

        $order = Order::Where('user_id',auth()->id())
        ->Where('status', $statusInprocess )->first();

        if(!$order ){
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => 1,
                'status' => $statusInprocess,
                'currency' => $currency,
            ]);
        }
        return  $order;

    }
}

