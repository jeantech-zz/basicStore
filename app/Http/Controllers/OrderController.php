<?php

namespace App\Http\Controllers;

use App\Actions\Order\UpdateOrderActions;
use App\Actions\Request\StoreRequestActions;
use App\Constants\Constants;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use App\PaymentGateways\PaymentGatewayContract;
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
    private ColeccionsOrdersRepositories $coleccionOrders;

    public function __construct()
    {
        $this->coleccionOrders = new ColeccionsOrdersRepositories;
        $this->returnUrl = Constants::URL_RETURN_PLACETOPAY;
        $this->descriptionPlacetoPay = Constants::DESCRIPTION_PLACETOPAY;
        $this->url = config('app.url');
        $this->statusOrderPayRejected =  Constants::STATUS_ORDER_REJECTED;
        $this->statusOrderInprocessPay = Constants::STATUS_ORDER_INPROCESSPAY;
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

    public function orderPay(Order $order, UpdateRequest $request, PaymentGatewayContract $paymentGeteway): RedirectResponse
    {
        $orderRequest =$this->coleccionOrders->requestOrder($order->id);

        if($orderRequest==null || $orderRequest->requestId==null   ){
            return $this->proccessPay($order, $request, $paymentGeteway);
        }
    }

    public function proccessPay(Order $order, UpdateRequest $request, PaymentGatewayContract $paymentGeteway): RedirectResponse
    {
        $arrayPay = $this->makePay($request->validated());
        $response = $paymentGeteway->createSession($arrayPay);

        $dataRequest = [
            "order" => $request->validated(),
            "responsePay" =>$response
        ];
        $this->createRequestOrderPay($dataRequest);

        if ($response['status']['status'] == 'OK'){

            $status = $this->statusOrderInprocessPay;
            $dataOrder = $request->validated();
            $dataOrder['status'] = $status;
            $result = $this->updateOrder($order, $dataOrder);

            return redirect()->away($response['processUrl']);

        }else{
            $status = $this->statusOrderPayRejected;

            $dataOrder = $request->validated();
            $dataOrder['status'] = $status;
            $result = $this->updateOrder($order, $dataOrder);

            $message = $response['status']['message'];
            return redirect()->route('orders.edit', $order)->with('success', 'Order Reject successfully.');
        }
    }

    private function makePay (array $data): array
    {
        return  [
            'reference' => $data['id'],
            'total' => $data['total'],
            'returnUrl' => $this->returnUrl.'/'.$data['id'],
            'description' => $this->descriptionPlacetoPay .' '.$data['id'],
            'currency' => $data['currency']
        ];
    }

    private function updateOrder (Order $order, array $data): bool
    {
        $orderUpdate = UpdateOrderActions::execute($order, $data);
        return $orderUpdate;
    }

    private function createRequestOrderPay (array $data)
    {
        $processUrl = null;
        $requestId = null;
       if(isset($data['responsePay']['processUrl'])) {
           $processUrl = $data['responsePay']['processUrl'];
           $requestId = $data['responsePay']['requestId'];
       }

        $dataRequest = [
            'order_id' =>  $data['order']['id'],
            'reference' =>  $data['order']['id'],
            'description' => $this->returnUrl.'/'.$data['order']['id'],
            'returnUrl' => $this->descriptionPlacetoPay .' '.$data['order']['id'],
            'response' =>  json_encode($data['responsePay']) ,
            'processUrl' => $processUrl,
            'requestId' => $requestId,
        ];
        $createRequest = StoreRequestActions::execute($dataRequest);

        return $createRequest;
    }

}
