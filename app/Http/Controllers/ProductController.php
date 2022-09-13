<?php

namespace App\Http\Controllers;

use App\Actions\Order\StoreOrderActions;
use App\Actions\Order\UpdateOrderActions;
use App\Actions\OrderProduct\StoreUpdateOrderProductActions;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate();

        return view('product.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * $products->perPage());
    }

    public function addProductOrder (Product $product): RedirectResponse
    {
        $order = StoreOrderActions::execute();

        $orderProduct = StoreUpdateOrderProductActions::execute($order, $product);

        $orderUpdate = UpdateOrderActions::execute($order);

        return redirect()->route('orders.index')->with('success', 'Add Product successfully.');
    }


}
