<?php

namespace App\Actions\Order;

use App\Models\Order;
use App\Models\OrderProduct;

class UpdateOrderActions
{
    public static function execute(Order $order, array $data = [] ): bool
    {
        $orderRecord = Order::find($order->id);

        $orderProduct = OrderProduct::Where('order_id', $order->id )->get();
        $totalOrderProduct = $orderProduct->sum('amount');


        $dataRecord = [];

        if ($data <> null ){
            if ($data['customer_name'] <>   $orderRecord->customer_name ){
                $dataRecord['customer_name']  = $data['customer_name'];
            }else{
                $dataRecord['customer_name']  = $orderRecord->customer_name;
            }

            if ($data['customer_email'] <>   $orderRecord->customer_email){
                $dataRecord['customer_email']  = $data['customer_email'];
            }else{
                $dataRecord['customer_email']  = $orderRecord->customer_email;
            }

            if ($data['customer_mobile'] <>   $orderRecord->customer_mobile){
                $dataRecord['customer_mobile']  = $data['customer_mobile'];
            }else{
                $dataRecord['customer_mobile']  = $orderRecord->customer_mobile;
            }

            if ($data['currency'] <>   $orderRecord->currency){
                $dataRecord['currency']  = $data['currency'];
            }else{
                $dataRecord['currency']  = $orderRecord->currency;
            }

            if ($data['status'] <>   $orderRecord->status){
                $dataRecord['status']  = $data['status'];
            }else{
                $dataRecord['status']  = $orderRecord->status;
            }

            $dataRecord['total']  = $totalOrderProduct;

        }else{
            $dataRecord = [
                'customer_name' =>  $order->customer_name,
                'customer_email' => $order->customer_email,
                'customer_mobile' => $order->customer_mobile,
                'total' =>  $totalOrderProduct,
                'currency' => $order->currency,
                'status' => $order->status,
            ];

        }

        $record = $orderRecord->update([
            'customer_name' =>  $dataRecord['customer_name'],
            'customer_email' => $dataRecord['customer_email'],
            'customer_mobile' => $dataRecord['customer_mobile'],
            'total' =>  $dataRecord['total'],
            'currency' => $dataRecord['currency'],
            'status' => $dataRecord['status'],
        ]);

        return $record;
    }
}
