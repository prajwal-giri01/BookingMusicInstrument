<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_rental_cost',
        'payment_status',
        'rental_status',
        'transaction_id',
    ];

}
