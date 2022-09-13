<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\Orders\ColeccionsOrdersRepositories;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    private ColeccionsOrdersRepositories $coleccionOrders;

    public function __construct()
    {
        $this->coleccionOrders = new ColeccionsOrdersRepositories;
    }

    public function index():View
    {
        $orders = $this->coleccionOrders->listOrder();

        return view('order.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * $orders->perPage());
    }

    public function edit(Order $order):View
    {

        $order = $this->coleccionOrders->orderId($order);
        return view('order.edit', compact('order'));
    }

}
