<?php

namespace App\Actions\OrderProduct;

use App\Constants\Constants;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\Product;

class StoreUpdateOrderProductActions
{
    public static function execute(Order $order, Product $product)
    {
        $orderProduct = OrderProduct::Where('product_id', $product->id)
            ->Where('order_id', $order->id)->first();

        if (!$orderProduct) {
            $orderProduct = OrderProduct::create([
                'product_id' => $product->id,
                'quantity' => 1,
                'amount' => $product->price,
                'order_id' => $order->id,
            ]);
        } else {
            $addQuantity = $orderProduct->quantity + 1;
            $addAmount = $orderProduct->amount + $product->price;
            $orderProduct->update([
                'quantity' => $addQuantity,
                'amount' =>  $addAmount
            ]);
        }
        return  $orderProduct;
    }
}
