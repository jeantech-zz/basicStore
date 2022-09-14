<?php

namespace App\Actions\Order;

use App\Constants\Constants;
use App\PaymentGateways\PaymentGatewayContract;
use App\Repositories\Orders\ColeccionsOrdersRepositories;

class UpdatePayOrderActions
{
    public static function execute(int $orderId, array $arrayPay, PaymentGatewayContract $paymentGeteway): void
    {
        $coleccionOrders = new ColeccionsOrdersRepositories;
        $orderRequest = $coleccionOrders->requestOrder($orderId);

        $response = $paymentGeteway->getSession($orderRequest->requestId, $arrayPay);

        $dataOrder = [];
        if ($response['status']['status'] == "APPROVED") {
            $dataOrder['status'] = Constants::STATUS_ORDER_PAYED;
        }else if ($response['status']['status'] == "PENDING") {
            $dataOrder['status'] = Constants::STATUS_ORDER_CREATED;
        }else{
            $dataOrder['status'] = Constants::STATUS_ORDER_REJECTED;
        }

        $order = $coleccionOrders->orderId($orderId);
        UpdateOrderActions::execute($order, $dataOrder);
    }
}
