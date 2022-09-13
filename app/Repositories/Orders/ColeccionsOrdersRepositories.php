<?php

namespace App\Repositories\Orders;

use App\Models\Order;

class ColeccionsOrdersRepositories implements OrdersRepositories
{
    public function listOrder ()
    {
        return Order::paginate();
    }

    public function orderId (Order $order)
    {
       /* return Order::select('orders.*', 'users.name As userName')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.id',$order->id)
        ->first();*/
        return Order::select('orders.*')
        ->where('orders.id',$order->id)
        ->first();
    }

    public function requestOrder (int $id)
    {

        return   Order::select('orders.*', 'requests.processUrl As processUrl')
        ->join('requests', 'requests.order_id', '=', 'orders.id')
        ->where('orders.id',$id)
        ->first();
    }


}
