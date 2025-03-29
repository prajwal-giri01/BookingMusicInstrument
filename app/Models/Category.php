<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'image_path'];



    public function instruments(){
        return $this->hasMany(Instruments::class);
    }
}
