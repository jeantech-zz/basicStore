<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Order
 *
 * @property $id
 * @property $user_id
 * @property $customer_name
 * @property $customer_email
 * @property $customer_mobile
 * @property $total
 * @property $currency
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Order extends Model
{
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','customer_name','customer_email','customer_mobile','total','currency','status'];



    public function user():HasOne
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }


}
