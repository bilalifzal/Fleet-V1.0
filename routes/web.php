<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\DashboardController; 

// <--- IS THIS LINE MISSING?

Route::get('/gateway', [SecurityController::class, 'showGateway'])->name('login');
Route::post('/gateway/auth', [SecurityController::class, 'authenticate']);

Route::middleware('auth')->group(function () {
    Route::get('/command-center', function () {
        return "Welcome to the Billion-Dollar Fleet Dashboard";
    });
});
// ... existing code ...

// The secure Command Center (Only accessible if logged in)
Route::middleware('auth')->group(function () {
    // Existing Routes
    Route::get('/command-center', [DashboardController::class, 'showCommandCenter']);Route::get('/dashboard/assets', [DashboardController::class, 'showAssets']);
    Route::post('/dashboard/assets/deploy', [DashboardController::class, 'storeAsset']); // <-- ADD THIS
   Route::get('/dashboard/fuel', [DashboardController::class, 'showFuel']);
    Route::post('/dashboard/fuel/log', [DashboardController::class, 'storeFuel']); // <-- ADD THIS
    Route::get('/dashboard/security', [DashboardController::class, 'showSecurity']);
    
    // NEW: The 4 Fleet Modules
    Route::get('/dashboard/maintenance', [DashboardController::class, 'showMaintenance']);Route::get('/dashboard/drivers', [DashboardController::class, 'showDrivers']);
    Route::post('/dashboard/drivers/recruit', [DashboardController::class, 'storeDriver']); // <-- ADD THIS
    Route::get('/dashboard/ledger', [DashboardController::class, 'showLedger']);Route::get('/dashboard/settings', [DashboardController::class, 'showSettings']);
    Route::post('/dashboard/settings/update', [DashboardController::class, 'updateSettings']); // <-- ADD THIS
    // NEW: The Logout Route
    Route::post('/logout', [SecurityController::class, 'logout'])->name('logout');
});





Route::middleware('auth')->group(function () {
    Route::get('/command-center', [DashboardController::class, 'showCommandCenter']);
    Route::get('/dashboard/assets', [DashboardController::class, 'showAssets']);
    Route::get('/dashboard/fuel', [DashboardController::class, 'showFuel']);
    Route::get('/dashboard/security', [DashboardController::class, 'showSecurity']);
});


/*
|--------------------------------------------------------------------------
| DRIVER PORTAL (MOBILE-FIRST)
|--------------------------------------------------------------------------
*/
Route::get('/portal/login', [App\Http\Controllers\DriverPortalController::class, 'showLogin']);
Route::post('/portal/authenticate', [App\Http\Controllers\DriverPortalController::class, 'authenticate']);
Route::get('/portal/mission', [App\Http\Controllers\DriverPortalController::class, 'showMission']);


Route::post('/portal/mission/lock', [App\Http\Controllers\DriverPortalController::class, 'lockAsset']);
Route::post('/portal/mission/sos', [App\Http\Controllers\DriverPortalController::class, 'triggerSOS']);
Route::post('/portal/mission/fuel', [App\Http\Controllers\DriverPortalController::class, 'logFuel']);