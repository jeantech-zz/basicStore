<?php

namespace App\Actions\Order;

use App\Actions\Request\StoreRequestActions;
use App\Constants\Constants;
use App\Constants\PaymentGateways\PaymentGatewayConstants;
use App\Constants\Status\StatusConstants;
use App\Models\Order;
use App\PaymentGateways\PaymentGatewayContract;
use App\Repositories\Orders\ColeccionsOrdersRepositories;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;

class PayOrderAction
{
    public static function execute(array $dataPay, array $dataOrder, PaymentGatewayContract $paymentGeteway): RedirectResponse
    {
        $response = $paymentGeteway->createSession($dataPay);

        $returnUrl = PaymentGatewayConstants::URL_RETURN_PLACETOPAY;
        $descriptionPlacetoPay = PaymentGatewayConstants::DESCRIPTION_PLACETOPAY;
        $dataRequest = [
            'order_id' => $dataOrder['id'],
            'reference' => $dataOrder['id'],
            'returnUrl' => $returnUrl,
            'description' =>  $descriptionPlacetoPay . ' ' . $dataOrder['id'],
            'response' => json_encode($response),
            'processUrl' => $response['processUrl'],
            'requestId' => $response['requestId']
        ];

        StoreRequestActions::execute($dataRequest);

        if ($response['status']['status'] == 'OK') {
            $dataOrder['status'] = StatusConstants::STATUS_ORDER_INPROCESS_PAY;
            $coleccionOrders = new ColeccionsOrdersRepositories;
            $order = $coleccionOrders->orderId($dataOrder['id']);
            UpdateOrderAction::execute($order, $dataOrder);
            return redirect()->away($response['processUrl']);
        }

        $dataOrder['status'] = StatusConstants::STATUS_ORDER_REJECTED;
        UpdateOrderAction::execute($dataOrder['id'], $dataOrder);
        return redirect()->route('orders.edit', $dataOrder)->with('success', 'Order Reject successfully.');
    }
}
