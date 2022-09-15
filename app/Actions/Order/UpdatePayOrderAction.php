<?php

namespace App\Actions\Order;

use App\Constants\Status\StatusConstants;
use App\PaymentGateways\PaymentGatewayContract;
use App\Repositories\Orders\ColeccionsOrdersRepositories;

class UpdatePayOrderAction
{
    public static function execute(int $orderId, array $arrayPay, PaymentGatewayContract $paymentGeteway): void
    {
        $coleccionOrders = new ColeccionsOrdersRepositories;
        $orderRequest = $coleccionOrders->requestOrder($orderId);

        $response = $paymentGeteway->getSession($orderRequest->requestId, $arrayPay);

        $dataOrder = [];
        if ($response['status']['status'] == "APPROVED") {
            $dataOrder['status'] = StatusConstants::STATUS_ORDER_PAYED;
        }else if ($response['status']['status'] == "PENDING") {
            $dataOrder['status'] = StatusConstants::STATUS_ORDER_CREATED;
        }else{
            $dataOrder['status'] = StatusConstants::STATUS_ORDER_REJECTED;
        }

        $order = $coleccionOrders->orderId($orderId);
        UpdateOrderAction::execute($order, $dataOrder);
    }
}
