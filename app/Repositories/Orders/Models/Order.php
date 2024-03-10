<?php

namespace App\Repositories\Orders\Models;

use App\Services\Shared\HttpBuildUrl;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'external_order_id',
        'payment_system_order_id',
        'amount',
        'currency',
        'language',
        'email',
        'phone',
        'return_url',
        'fail_url',
        'json_params',
        'status',
        'expiration_date',
    ];
}
