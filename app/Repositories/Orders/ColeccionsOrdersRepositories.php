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
        return Order::select('orders.*', 'users.name As userName')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('orders.id',$order->id)
        ->first();
    }

}
