<?php
namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => [ 'required'],
            'user_id' => [ 'required'],
            'customer_name' => [ 'string'],
            'customer_email' => [ 'string'],
            'customer_mobile' => [ 'string'],
            'total'   =>  [ 'string'  ],
            'currency' => [ 'string' ],
            'status' => [ 'string' ],
         ];
    }
}
