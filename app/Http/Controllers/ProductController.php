<?php

namespace App\Http\Controllers;

use App\Actions\Order\StoreOrderActions;
use App\Actions\Order\UpdateOrderActions;
use App\Actions\OrderProduct\StoreUpdateOrderProductActions;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    public function index(): Response
    {
        $products = Product::paginate();

        return view('product.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * $products->perPage());
    }

    public function addProductOrder(Product $product): RedirectResponse
    {
        $userId = auth()->id();
        $order = StoreOrderActions::execute($userId);

        StoreUpdateOrderProductActions::execute($order, $product);
        UpdateOrderActions::execute($order);

        return redirect()->route('orders.index')->with('success', 'Add Product successfully.');
    }
}
