<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceAlert extends Model
{
    // Drop the firewall so we can mass-assign
    protected $guarded = [];

    // Relationship: This alert belongs to one Truck
    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
    
}
