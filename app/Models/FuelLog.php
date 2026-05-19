<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelLog extends Model
{
    protected $guarded = []; // Unlock mass-assignment

    // A Fuel Log belongs to ONE specific Truck
    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
}

