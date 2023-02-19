<?php

use App\Http\Controllers\API\OccupancyRateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api.')->group(function() {
    Route::get('/daily-occupancy-rates/{day}', [OccupancyRateController::class, 'getDailyOccupancyRates'])->name('occupancy.daily');
    Route::get('/monthly-occupancy-rates/{monthly}', [OccupancyRateController::class, 'getMonthOccupancyRates'])->name('occupancy.daily');
});
