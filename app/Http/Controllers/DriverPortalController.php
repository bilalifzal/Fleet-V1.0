<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Truck;
use App\Models\MaintenanceAlert;
use App\Models\FuelLog;           // <-- Added for Fuel Logging
use App\Models\LedgerTransaction; // <-- Added to Auto-Deduct Money

class DriverPortalController extends Controller
{
    public function showLogin() { return view('portal.login'); }

    public function authenticate(Request $request)
    {
        $driver = Driver::where('employee_id', strtoupper($request->employee_id))->first();
        if ($driver) {
            session([
                'driver_id' => $driver->id, 
                'driver_name' => $driver->name,
                'employee_id' => $driver->employee_id
            ]);
            return redirect('/portal/mission');
        }
        return back()->with('error', 'ACCESS DENIED: Invalid Employee ID');
    }

    // --- THE MEGA MISSION DASHBOARD ---
    public function showMission()
    {
        if (!session()->has('driver_id')) return redirect('/portal/login');

        $availableTrucks = Truck::where('current_speed', 0)->get();
        $fuelLogs = [];

        // If the driver has a truck locked, fetch ONLY that truck's fuel history!
        if (session()->has('active_truck_id')) {
            $fuelLogs = FuelLog::where('truck_id', session('active_truck_id'))->latest()->take(5)->get();
        }

        return view('portal.mission', compact('availableTrucks', 'fuelLogs'));
    }

    public function lockAsset(Request $request)
    {
        $request->validate(['truck_id' => 'required|exists:trucks,id']);
        session(['active_truck_id' => $request->truck_id]);
        
        $truck = Truck::find($request->truck_id);
        $truck->update(['current_speed' => 85]);
        return back()->with('success', 'ASSET LOCKED. IN TRANSIT.');
    }

    public function triggerSOS()
    {
        if (!session()->has('active_truck_id')) return back()->with('error', 'LOCK AN ASSET FIRST.');

        MaintenanceAlert::create([
            'truck_id' => session('active_truck_id'),
            'component' => 'SYSTEM EMERGENCY',
            'issue_description' => 'DRIVER INITIATED SOS BEACON',
            'wear_percentage' => 100,
            'status' => 'Critical'
        ]);
        return back()->with('error', 'SOS BEACON TRANSMITTED TO COMMAND CENTER.');
    }

    // --- NEW: MOBILE FUEL LOGGING & LEDGER DEDUCTION ---
    public function logFuel(Request $request)
    {
        if (!session()->has('active_truck_id')) return back()->with('error', 'LOCK AN ASSET FIRST.');

        $status = $request->liters > 500 ? 'Anomalous' : 'Verified';
        $truck_id = session('active_truck_id');

        FuelLog::create([
            'truck_id'        => $truck_id,
            'liters'          => $request->liters,
            'cost'            => $request->cost,
            'location'        => strtoupper($request->location),
            'security_status' => $status,
            'blockchain_hash' => '0x' . substr(hash('sha256', time() . rand()), 0, 16),
        ]);

        $truck = Truck::find($truck_id);
        LedgerTransaction::create([
            'tx_hash'     => '0x' . substr(hash('sha256', time()), 0, 10),
            'truck_unit'  => $truck->unit_number,
            'type'        => 'EXPENSE',
            'description' => 'MOBILE DRIVER FUEL LOG',
            'amount'      => $request->cost
        ]);

        return back()->with('success', 'TELEMETRY SECURED. LEDGER UPDATED.');
    }
}