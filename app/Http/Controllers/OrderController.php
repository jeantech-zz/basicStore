<?php

namespace App\Http\Controllers;

use App\Actions\Order\PayOrderActions;
use App\Constants\Constants;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use App\PaymentGateways\PaymentGatewayContract;
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

    public function edit(Order $order): View
    {
        $order = $this->coleccionOrders->orderId($order);
        return view('order.edit', compact('order'));
    }

    public function orderPay(UpdateRequest $request): RedirectResponse
    {
        $arrayPay = $this->makePay($request->validated());
        $orderRequest = $this->coleccionOrders->requestOrder($request->id);
        $dataOrder = $request->validated();

        if ($orderRequest == null || $orderRequest->requestId == null) {
            return  PayOrderActions::execute($arrayPay, $dataOrder, $this->paymentGeteway);
        }
        return PayOrderActions::execute($arrayPay, $dataOrder, $this->paymentGeteway);
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
}
