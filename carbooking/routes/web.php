<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\CarsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::post('user/send',function(Request $request){
    dd($request->all());
})->name('sendRe');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('users/dashboard', [\App\Http\Controllers\frontend\UserController::class, 'index'])->name('user.dashboard');
Route::get('users/booking', [\App\Http\Controllers\frontend\UserController::class, 'viewBooking'])->name('users.view-booking');

Route::get('admin/dashboard', [\App\Http\Controllers\frontend\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('admin/request', [\App\Http\Controllers\frontend\AdminController::class, 'bookingRequest'])->name('admin.booking_request');
Route::get('admin/manage-driver', [DriverController::class,'index'])->name('admin.manageDriver');
Route::get('admin/manage-driver/{id}',[DriverController::class,'changestatus'])->name('driverstatus');
Route::get('admin/manage-car', [CarsController::class,'index'])->name('admin.manageCar');
Route::get('admin/manage-car/{id}',[CarsController::class,'changestatus'])->name('changestatus');
Route::post('admin/GG',function(Request $request){

    dd($request->all());

})->name('GG');
Route::post('admin/Test',function(Request $request){

    dd($request->all());

})->name('Test');
