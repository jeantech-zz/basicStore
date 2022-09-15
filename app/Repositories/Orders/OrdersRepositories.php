<?php

namespace App\Repositories\Orders;

use App\Models\Order;

interface OrdersRepositories
{
    public function listOrder();

    public function order(Order $order);

    public function requestOrder (int $orderId);

    public function orderId(int $idOrder);

}
