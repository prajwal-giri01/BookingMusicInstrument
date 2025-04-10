<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'instrument_id',
        'quantity',
        'rental_start_date',
        'rental_end_date',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function instrument()
    {
        return $this->belongsTo(Instruments::class);
    }
}
