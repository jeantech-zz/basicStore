<?php

namespace App\Repositories\Orders;

use App\Models\Order;

interface OrdersRepositories
{
    public function listOrder();

    public function orderId(Order $order);

    public function  requestOrder (int $id);

}
