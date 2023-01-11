<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\APi\CarControllers;
use App\Http\Controllers\APi\DriverController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('car',[CarControllers::class,'index']);
Route::get('driver',[DriverController::class,'index']);
Route::get('booking',[BookingController::class,'index']);