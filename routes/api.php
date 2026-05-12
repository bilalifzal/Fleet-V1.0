<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FleetApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Notice that Laravel automatically adds "/api" to the front of all these URLs!
*/

Route::get('/assets', [FleetApiController::class, 'getAssets']);
Route::get('/drivers', [FleetApiController::class, 'getDrivers']);
Route::get('/fuel-logs', [FleetApiController::class, 'getFuelLogs']);