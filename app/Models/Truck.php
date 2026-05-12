<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    // Allow mass insertion of data
    protected $guarded = [];

    // The Relationship: A Truck has many Fuel Logs
    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class);
    }
}