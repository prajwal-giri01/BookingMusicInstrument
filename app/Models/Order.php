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
        'delivery_address',
        'latitude',
        'longitude',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderItems(){
       return $this->hasMany(OrderItem::class);
    }

}
