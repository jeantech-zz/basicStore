<?php

namespace App\Actions\Order;

use App\Actions\Request\StoreRequestActions;
use App\Constants\Constants;
use App\Models\Order;
use App\PaymentGateways\PaymentGatewayContract;
use App\Repositories\Orders\ColeccionsOrdersRepositories;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;

class PayOrderActions
{
    public static function execute(array $dataPay, array $dataOrder, PaymentGatewayContract $paymentGeteway):RedirectResponse
    {
        $response = $paymentGeteway->createSession($dataPay);

        $returnUrl = Constants::URL_RETURN_PLACETOPAY;
        $descriptionPlacetoPay = Constants::DESCRIPTION_PLACETOPAY;
        $dataRequest = [
            'order_id' => $dataOrder['id'],
            'reference' => $dataOrder['id'],
            'returnUrl' => $returnUrl,
            'description' =>  $descriptionPlacetoPay.' '.$dataOrder['id'],
            'response' => json_encode($response),
            'processUrl' => $response['processUrl'],
            'requestId' => $response['requestId']
        ];

        StoreRequestActions::execute($dataRequest);

        if ($response['status']['status'] == 'OK'){
            $dataOrder['status'] = Constants::STATUS_ORDER_INPROCESS_PAY;
            $coleccionOrders = new ColeccionsOrdersRepositories;
            $order = $coleccionOrders->order($dataOrder['id']);
            UpdateOrderActions::execute( $order, $dataOrder);
            return redirect()->away($response['processUrl']);
        }

        $dataOrder['status'] = Constants::STATUS_ORDER_REJECTED;
        UpdateOrderActions::execute($dataOrder['id'], $dataOrder);
        return redirect()->route('orders.edit', $dataOrder)->with('success', 'Order Reject successfully.');

    }


}

