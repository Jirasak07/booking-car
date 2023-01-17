<?php

use App\Http\Controllers\backend\DashboardAdminController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\DriverController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

Route::group(
    [
        'prefix' => 'users',
        'middleware' => ['Isuser'],
    ],
    function () {
        Route::get('dashboard', [\App\Http\Controllers\backend\Bookingcontroller::class, 'showcalendar'])->name('users.dashboard');
        Route::get('booking', [\App\Http\Controllers\backend\Bookingcontroller::class, 'booking_user'])->name('users.view-booking');
        Route::post('user/send', [\App\Http\Controllers\backend\Bookingcontroller::class, 'store'])->name('sendRe');
        Route::post('edit', [\App\Http\Controllers\backend\UserBookingcontroller::class, 'edit_booking'])->name('user.edit.booking');
        Route::get('cancel/{id}', [\App\Http\Controllers\backend\Bookingcontroller::class, 'cancle'])->name('users.booking_cancel');
    }
);

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['IsAdmin'],
    ],
    function () {
        Route::get('dashboard', [\App\Http\Controllers\backend\DashboardAdminController::class, 'index'])->name('admin.dashboard');
        Route::get('request', [\App\Http\Controllers\backend\Bookingcontroller::class, 'index'])->name('admin.booking_request');
        Route::get('manage-driver', [DriverController::class, 'index'])->name('admin.manage-driver');
        Route::get('manage-driver/{id}', [DriverController::class, 'changestatus'])->name('driverstatus');
        Route::get('manage-car', [CarsController::class, 'index'])->name('admin.manage-car');
        Route::get('manage-car/{id}', [CarsController::class, 'changestatus'])->name('changestatus');
        Route::get('manage-user', [App\Http\Controllers\frontend\AdminController::class, 'manageUser'])->name('admin.manage-user');
        Route::get('history', [\App\Http\Controllers\backend\Bookingcontroller::class, 'history'])->name('admin.booking_history');
        Route::post('GG', function (Request $request) {
            dd($request->all());
        })->name('GG');

        Route::post('approve', [\App\Http\Controllers\backend\Bookingcontroller::class, 'update'])->name('update');

        Route::get('request/{id}', [\App\Http\Controllers\backend\Bookingcontroller::class, 'cancle'])->name('cancle');
    }
);

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('countcar1', [DashboardAdminController::class, 'index'])->name('test');
