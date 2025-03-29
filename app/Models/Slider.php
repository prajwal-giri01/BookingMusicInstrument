<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;  // Import the HasFactory trait
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;  // Use the HasFactory trait
        protected $table = 'sliders'; // Make sure the table name is correct
        protected $fillable = ['image']; // If you’re using mass assignment

}

