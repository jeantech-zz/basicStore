<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property $id
 * @property $code
 * @property $name
 * @property $description
 * @property $price
 * @property $quantity
 * @property $disable_at
 * @property $image
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Product extends Model
{
    
    static $rules = [
		'code' => 'required',
		'name' => 'required',
		'description' => 'required',
		'price' => 'required',
		'quantity' => 'required',
		'image' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['code','name','description','price','quantity','disable_at','image'];



}
