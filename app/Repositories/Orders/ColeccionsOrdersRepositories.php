<?php

namespace App\Repositories\Orders;

use App\Models\Order;

class ColeccionsOrdersRepositories implements OrdersRepositories
{
    public function listOrder ()
    {
        return Order::paginate();
    }

    public function order(Order $order):Order
    {
       return Order::select('orders.*', 'users.name As userName')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.id',$order->id)
        ->first();
    }

    public function requestOrder(int $orderId)//:Order
    {
        return   Order::select('orders.*', 'requests.processUrl As processUrl', 'requests.requestId as requestId')
        ->join('requests', 'requests.order_id', '=', 'orders.id')
        ->where('orders.id',$orderId)
        ->first();
    }

    public function orderId(int $idOrder):Order
    {
       return Order::select('orders.*', 'users.name As userName')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.id',$idOrder)
        ->first();
    }

}
