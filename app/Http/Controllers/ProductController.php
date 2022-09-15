<?php

namespace App\Http\Controllers;

use App\Actions\Order\StoreOrderAction;
use App\Actions\Order\UpdateOrderAction;
use App\Actions\OrderProduct\StoreUpdateOrderProductActions;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::paginate();

        return view('product.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * $products->perPage());
    }

    public function addProductOrder(Product $product): RedirectResponse
    {
        $userId = auth()->id();
        $order = StoreOrderAction::execute($userId);

        StoreUpdateOrderProductActions::execute($order, $product);
        UpdateOrderAction::execute($order);

        return redirect()->route('orders.index')->with('success',  __("products.messages_add_product"));
    }
}
