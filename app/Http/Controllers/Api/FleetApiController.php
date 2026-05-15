<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\FuelLog;

class FleetApiController extends Controller
{
    // 1. GET ALL ASSETS (TRUCKS)
    public function getAssets()
    {
        $trucks = Truck::all();
        
        // Return pure JSON data instead of a Blade view!
        return response()->json([
            'status' => 'success',
            'message' => 'Fleet assets retrieved successfully.',
            'count' => $trucks->count(),
            'data' => $trucks
        ], 200);
    }

    // 2. GET DRIVER ROSTER
    public function getDrivers()
    {
        $drivers = Driver::all();
        
        return response()->json([
            'status' => 'success',
            'data' => $drivers
        ], 200);
    }

    // 3. GET SECURE FUEL TELEMETRY
    public function getFuelLogs()
    {
        // 'with('truck')' includes the truck details nested inside the JSON!
        $logs = FuelLog::with('truck')->latest()->take(50)->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $logs
        ], 200);
    }
}
