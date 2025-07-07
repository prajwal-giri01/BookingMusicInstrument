<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customPackagesItems extends Model
{
  protected $fillable = [
      'custom_package_id',
      'instrument_id'
  ];

    public function customPackages()
    {
        return $this->belongsTo(customPackages::class);
    }
    public function instrument()
    {
        return $this->belongsTo(Instruments::class, 'instrument_id');
    }
}
