<?php

namespace App\Repositories\Orders;

use App\Models\Order;

class ColeccionsOrdersRepositories implements OrdersRepositories
{
    public function listOrder ()
    {
        return Order::paginate();
    }

    public function orderId (Order $order):Order
    {
       return Order::select('orders.*', 'users.name As userName')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.id',$order->id)
        ->first();
    }

    public function requestOrder(int $id):Order
    {
        return   Order::select('orders.*', 'requests.processUrl As processUrl')
        ->join('requests', 'requests.order_id', '=', 'orders.id')
        ->where('orders.id',$id)
        ->first();
    }

    public function order(int $idOrder):Order
    {
       return Order::select('orders.*', 'users.name As userName')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.id',$idOrder)
        ->first();
    }

}
