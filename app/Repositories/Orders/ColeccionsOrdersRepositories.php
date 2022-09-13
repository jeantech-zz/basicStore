<?php

namespace App\Repositories\Orders;

use App\Models\Order;

class ColeccionsOrdersRepositories implements OrdersRepositories
{
    public function listOrder ()
    {
        return Order::paginate();
    }

}
