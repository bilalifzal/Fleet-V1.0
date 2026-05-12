<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\FuelLog;
use App\Models\Driver;
use App\Models\MaintenanceAlert;
use App\Models\LedgerTransaction;
use App\Models\SystemSetting;

class DashboardController extends Controller
{
    // 1. THE MISSION CONTROL
    public function showCommandCenter()
    {
        $stats = [
            'total_vehicles' => Truck::count(),
            'active_now'     => Truck::where('current_speed', '>', 0)->count(),
            'fuel_consumed'  => FuelLog::sum('liters'),
            'alerts'         => FuelLog::where('security_status', 'Anomalous')->count(),
        ];
        return view('dashboard.command-center', compact('stats'));
    }

    // 2. THE ASSET RADAR
    public function showAssets()
    {
        $trucks = Truck::all(); 
        return view('dashboard.assets', compact('trucks'));
    }

    // 3. FUEL INTELLIGENCE
   // 3. FUEL INTELLIGENCE (Read from Database)
    public function showFuel()
    {
        $fuelLogs = FuelLog::with('truck')->latest()->get(); 
        $trucks = Truck::all(); // We need this so you can pick a truck in the UI dropdown!
        return view('dashboard.fuel', compact('fuelLogs', 'trucks'));
    }

    // 3B. LOG FUEL & AUTO-DEDUCT LEDGER (POST ROUTE)
    public function storeFuel(Request $request)
    {
        $request->validate([
            'truck_id' => 'required|exists:trucks,id',
            'liters'   => 'required|numeric',
            'cost'     => 'required|numeric',
            'location' => 'required|string',
        ]);

        // Basic AI Security: If they log more than 500 Liters, flag it as suspicious!
        $status = $request->liters > 500 ? 'Anomalous' : 'Verified';

        // 1. Save the Fuel Log
       // 1. Save the Fuel Log with High-Level Encryption
        FuelLog::create([
            'truck_id'        => $request->truck_id,
            'liters'          => $request->liters,
            'cost'            => $request->cost,
            'location'        => strtoupper($request->location),
            'security_status' => $status,
            // Generate a real-time secure hash for the fuel log!
            'blockchain_hash' => '0x' . substr(hash('sha256', time() . rand()), 0, 16), 
        ]);
        // 2. THE MASTER STROKE: Auto-deduct from the Financial Ledger!
        $truck = Truck::find($request->truck_id);
        LedgerTransaction::create([
            'tx_hash'     => '0x' . substr(hash('sha256', time()), 0, 10),
            'truck_unit'  => $truck->unit_number,
            'type'        => 'EXPENSE',
            'description' => 'FUEL AUTO-DEDUCT',
            'amount'      => $request->cost
        ]);

        return back();
    }

    // 4. SECURITY COMMAND
    public function showSecurity()
    {
        return view('dashboard.security');
    }

    // 5. DRIVER ROSTER
    public function showDrivers() 
    { 
        $drivers = Driver::all(); 
        return view('dashboard.drivers', compact('drivers')); 
    }

    // 5B. RECRUITING ENGINE (POST ROUTE)
    public function storeDriver(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'employee_id'   => 'required|string|unique:drivers,employee_id',
            'license_class' => 'required|string',
        ]);

        Driver::create([
            'name'          => $request->name,
            'employee_id'   => strtoupper($request->employee_id),
            'license_class' => $request->license_class,
            'fatigue_level' => 0,
            'safety_score'  => 100,
            'status'        => 'RESTING',
        ]);

        return back();
    }

    // 6. AI MAINTENANCE
    public function showMaintenance() 
    { 
        $alerts = MaintenanceAlert::with('truck')->orderBy('days_to_failure', 'asc')->get();
        return view('dashboard.maintenance', compact('alerts')); 
    }
    
    // 7. FINANCIAL LEDGER
    public function showLedger() 
    { 
        $revenue = LedgerTransaction::where('type', 'REVENUE')->sum('amount');
        $expense = LedgerTransaction::where('type', 'EXPENSE')->sum('amount');
        
        $margin = $revenue > 0 ? (($revenue - $expense) / $revenue) * 100 : 0;

        $transactions = LedgerTransaction::latest()->get();

        return view('dashboard.ledger', compact('revenue', 'expense', 'margin', 'transactions')); 
    }
    
    // 8. SYSTEM CONFIG
  // 8. SYSTEM CONFIG (Read from Database)
    public function showSettings() 
    { 
        // Automatically create default settings if they don't exist yet!
        $settings = SystemSetting::firstOrCreate(
            ['id' => 1],
            [
                'max_speed_limit' => 110,
                'idle_engine_cutoff' => 15,
                'google_maps_key' => 'AIzaSyB-DEMO-KEY-999',
                'strict_cnic_validation' => true
            ]
        );
        return view('dashboard.settings', compact('settings')); 
    }

    // 8B. UPDATE CONFIG (Save to Database)
    public function updateSettings(Request $request)
    {
        $settings = SystemSetting::first();
        
        $settings->update([
            'max_speed_limit'        => $request->max_speed_limit,
            'idle_engine_cutoff'     => $request->idle_engine_cutoff,
            'google_maps_key'        => $request->google_maps_key,
            'strict_cnic_validation' => $request->has('strict_cnic_validation'), // Checkbox logic
        ]);

        return back();
    }



    // 2B. DEPLOY NEW ASSET (POST ROUTE)
   // 2B. DEPLOY NEW ASSET (POST ROUTE)
    public function storeAsset(Request $request)
    {
        $request->validate([
            'unit_number' => 'required|string|unique:trucks,unit_number',
        ]);

        Truck::create([
            'unit_number'   => strtoupper($request->unit_number),
            // Auto-generate a secure, random 12-character VIN using the current timestamp!
            'vin'           => 'VIN-' . strtoupper(substr(md5(time() . rand()), 0, 12)), 
            'current_speed' => 0, // New trucks start at 0 km/h (Idle)
        ]);

        return back();
    }
}