<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'reference',
        'description',
        'returnUrl' ,
        'response',
        'processUrl',
        'requestId'
        ];
}
