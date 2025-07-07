<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customPackages extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'quantity',
        'price',
        'rental_start_date',
        'rental_end_date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function items(){
        return $this->hasMany(customPackagesItems::class, 'custom_package_id');
    }

}
