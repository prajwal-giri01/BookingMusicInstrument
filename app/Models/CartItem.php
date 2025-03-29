<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'instrument_id',
        'quantity',
        'rental_start_date',  // New field
        'rental_end_date',    // New field
    ];

    public function instrument()
    {
        return $this->belongsTo(Instruments::class);
    }
}
