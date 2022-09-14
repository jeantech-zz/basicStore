<?php

namespace App\Http\Controllers;

use App\Actions\Order\PayOrderActions;
use App\Actions\Order\UpdatePayOrderActions;
use App\Constants\Constants;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use App\PaymentGateways\Placetopay;
use App\Repositories\Orders\ColeccionsOrdersRepositories;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    private $returnUrl;
    private $descriptionPlacetoPay;
    private ColeccionsOrdersRepositories $coleccionOrders;
    private Placetopay $paymentGeteway;

    public function __construct()
    {
        $this->coleccionOrders = new ColeccionsOrdersRepositories;
        $this->paymentGeteway = new Placetopay;
        $this->returnUrl = Constants::URL_RETURN_PLACETOPAY;
        $this->descriptionPlacetoPay = Constants::DESCRIPTION_PLACETOPAY;
    }

    public function index(): View
    {
        $orders = $this->coleccionOrders->listOrder();

        return view('order.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * $orders->perPage());
    }

    public function indexStore(): View
    {
        $orders = $this->coleccionOrders->listOrderStore();

        return view('order.indexStore', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * $orders->perPage());
    }

    public function edit(Order $order): View
    {
        $order = $this->coleccionOrders->order($order);
        return view('order.edit', compact('order'));
    }

    public function orderPay(UpdateRequest $request): RedirectResponse
    {
        $arrayPay = $this->makePay($request->validated());
        $orderRequest = $this->coleccionOrders->requestOrder($request->id);
        $dataOrder = $request->validated();

        if ($orderRequest == null || $orderRequest->requestId == null
        || ($orderRequest->requestId <> null
        && $orderRequest->status == Constants::STATUS_ORDER_REJECTED)) {
            return  PayOrderActions::execute($arrayPay, $dataOrder, $this->paymentGeteway);
        }

        return redirect()->away($orderRequest->processUrl);
    }

    private function makePay(array $data): array
    {
        return  [
            'reference' => $data['id'],
            'total' => $data['total'],
            'returnUrl' => $this->returnUrl . '/' . $data['id'],
            'description' => $this->descriptionPlacetoPay . ' ' . $data['id'],
            'currency' => $data['currency']
        ];
    }


    public function showOrder(Request $request):View
    {
        $order = $this->coleccionOrders->orderId($request->orderId);
        $data = [
            'id' =>  $order->id,
            'total' =>  $order->total,
            'currency' =>  $order->currency,
        ];
        $arrayPay = $this->makePay($data);

        UpdatePayOrderActions::execute($request->orderId, $arrayPay,  $this->paymentGeteway);
        $order = $this->coleccionOrders->orderId($request->orderId);
        return view('order.edit', compact('order'));
    }
}
