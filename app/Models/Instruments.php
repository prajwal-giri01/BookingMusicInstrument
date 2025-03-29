<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instruments extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'rental_price',
        'rental_duration',
        'availability_status',
        'image_path',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
