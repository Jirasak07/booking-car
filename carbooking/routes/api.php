<?php

use App\Http\Controllers\api\AppMobile\Aproveapi;
use App\Http\Controllers\Api\AppMobile\Bookingapi;
use App\Http\Controllers\api\AppMobile\Emailapi;
use App\Http\Controllers\Api\AppMobile\ManageBookingAPI;
use App\Http\Controllers\api\AppMobile\Settingapi;
use App\Http\Controllers\api\AppMobile\ShowDataBookingapi;
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
Route::get('calendar',[BookingController::class,'showcalendar']);
Route::get('pageupdate',[BookingController::class,'pageupdate']);
Route::get('showhistory',[BookingController::class,'showhistory']);




//Mobile
Route::get('show/car',[ShowDataBookingapi::class,'showcar']);
Route::get('show/driver',[ShowDataBookingapi::class,'showdriver']);
Route::get('show/booking',[ShowDataBookingapi::class,'showbooking']);//show before aprove
Route::get('show/booking/{id}',[ShowDataBookingapi::class,'show_booking']);//show การจองฝั่ง User
Route::get('show/history',[ShowDataBookingapi::class,'showhistory']);
Route::get('show/history/detail/{id}',[ShowDataBookingapi::class,'detail_history']);
Route::get('caranddrive/aprove/{id}',[ShowDataBookingapi::class,'caranddriver_aprove']);
Route::get('caranddrive/edit/{id}',[ShowDataBookingapi::class,'caranddriver_edit']);
Route::get('Validates',[Bookingapi::class,'Validates']);

Route::post('booking/add',[Bookingapi::class,'bookingcar']);
Route::patch('booking/edit',[Bookingapi::class,'edit_booking']);
Route::patch('booking/edit/aproved',[Bookingapi::class,'edit_bookingin']);
Route::patch('cancle/{id}',[Bookingapi::class,'cancle']);

Route::patch('Aprove/car/in/{id}',[Aproveapi::class,'Aprove_in']);
Route::patch('Aprove/car/out/{id}',[Aproveapi::class,'Aprove_out']);


Route::get('send-mail/booking/{id}',[Emailapi::class,'mailbooking']);
Route::get('send-mail/bookingin/{id_in}',[Emailapi::class,'sendEmail']);
Route::get('send-mail/bookingout/{id_out}',[Emailapi::class,'sendmailout']);


Route::get('show/setting',[Settingapi::class,'showsetting']);
Route::patch('edit/setting',[Settingapi::class,'edit_time']);
Route::get('change-status/driver/{id}',[Settingapi::class,'DriverchangeStatus']);
Route::get('change-status/car/{id}',[Settingapi::class,'CarchangeStatus']);