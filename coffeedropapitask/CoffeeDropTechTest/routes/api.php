<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashcalcController;
use App\Http\Controllers\LocationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/cash-exchange', [CashcalcController::class, 'calculateCash']);
Route::post('/locations', [LocationController::class, 'store']);
Route::get('/locations/nearest', [LocationController::class, 'getNearestLocation']);

Route::get('/test', function () {
    return 'Route is working!';
});