<?php

use App\Http\Controllers\backend\DashboardAdminController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\DriverController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

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
Route::post('user/send', function (Request $request) {
    if ($request->location == "") {
        Alert::error('โปรดใส่ข้อมูลรายละเอียดการจอง');
        return redirect()->back();
    }
    dd($request->all());
})->name('sendRe');
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('users/dashboard', [\App\Http\Controllers\backend\Bookingcontroller::class, 'showcalendar'])->name('user.dashboard');
Route::get('users/booking', [\App\Http\Controllers\frontend\UserController::class, 'viewBooking'])->name('users.view-booking');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('admin/dashboard', [\App\Http\Controllers\frontend\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('admin/request', [\App\Http\Controllers\backend\Bookingcontroller::class, 'index'])->name('admin.booking_request');
Route::get('admin/manage-driver', [DriverController::class, 'index'])->name('admin.manageDriver');
Route::get('admin/manage-driver/{id}', [DriverController::class, 'changestatus'])->name('driverstatus');
Route::get('admin/manage-car', [CarsController::class, 'index'])->name('admin.manageCar');
Route::get('admin/manage-car/{id}', [CarsController::class, 'changestatus'])->name('changestatus');
Route::get('/admin/manage-user', [App\Http\Controllers\frontend\AdminController::class, 'manageUser'])->name('admin/manage-user');
Route::get('/admin/history', [App\Http\Controllers\frontend\AdminController::class, 'history'])->name('admin/history');
Route::post('admin/GG', function (Request $request) {

    dd($request->all());

})->name('GG');
Route::post('admin/Test', function (Request $request) {

    dd($request->all());

})->name('Test');


Route::get('countcar1',[DashboardAdminController::class,'index']);