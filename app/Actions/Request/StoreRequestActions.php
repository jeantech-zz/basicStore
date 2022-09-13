<?php

namespace App\Actions\Request; 

use App\Models\Request;

class StoreRequestActions
{
    public static function execute(array $data): Request
    {
            $request = Request::create([
                'order_id' => $data['order_id'],
                'reference' => $data['reference'],
                'returnUrl' => $data['returnUrl'],
                'description' => $data['description'],
                
                'response' => $data['response'],
                'processUrl' => $data['processUrl'],
                'requestId' => $data['requestId']
                
            ]);

        return  $request;
       
    }
}


