<?php

use App\Events\StoreNotification;
use App\Http\Controllers\backend\DashboardAdminController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\ShowdataController;
use App\Http\Controllers\backend\UserBookingController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\DriverController;
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

        Route::get('dashboard', [\App\Http\Controllers\backend\ShowdataController::class, 'showcalendar'])->name('users.dashboard');
        Route::get('dashboard/refresh', [\App\Http\Controllers\backend\ShowdataController::class, 'refresh_calendar']);
        Route::get('booking', [\App\Http\Controllers\backend\ShowdataController::class, 'show_booking'])->name('users.view-booking');
        Route::get('booking/refresh', [\App\Http\Controllers\backend\ShowdataController::class, 'refresh_booking']);
        Route::post('send', [\App\Http\Controllers\backend\Bookingcontroller::class, 'store'])->name('sendRe');
        Route::post('edit', [\App\Http\Controllers\backend\Bookingcontroller::class, 'edit_booking'])->name('user.edit.booking');
        Route::get('cancel/{id}/{note}', [\App\Http\Controllers\backend\Bookingcontroller::class, 'cancle'])->name('users.booking_cancel');
        Route::get('detail/{id}', [\App\Http\Controllers\backend\ShowdataController::class, 'detail_booking']);
        Route::get('validate_booking', [\App\Http\Controllers\backend\Bookingcontroller::class, 'validate_booking']);
        Route::get('store-mail/{id}', [\App\Http\Controllers\backend\Bookingcontroller::class, 'mailbooking']);
        Route::get('message', [\App\Http\Controllers\backend\Bookingcontroller::class, 'shownoti']);
    }
);
Route::get('admin/request', [\App\Http\Controllers\backend\ShowdataController::class, 'show_booking']);
Route::get('admin/detail/{id}', [\App\Http\Controllers\backend\ShowdataController::class, 'detail_booking']);
Route::post('admin/edit', [\App\Http\Controllers\backend\Bookingcontroller::class, 'edit_booking'])->name('user.edit.booking');
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['IsAdmin'],
    ],
    function () {

        Route::get('dashboard', [\App\Http\Controllers\backend\ShowdataController::class, 'index2'])->name('admin.dashboard');
        Route::get('dashboard/refresh', [\App\Http\Controllers\backend\ShowdataController::class, 'refresh']);
        Route::get('dashboard/eventcalen', [\App\Http\Controllers\backend\ShowdataController::class, 'eventcalen']);
        Route::get('history/{id}', [\App\Http\Controllers\backend\ShowdataController::class, 'detail_history']);
        Route::get('request-all', [\App\Http\Controllers\backend\ShowdataController::class, 'index'])->name('admin.booking_request');
        Route::get('request/data', [\App\Http\Controllers\backend\ShowdataController::class, 'requestDataTable']);
        Route::get('manage-driver', [ShowdataController::class, 'show_driver'])->name('admin.manage-driver');
        Route::get('manage-driver/{id}', [SettingController::class, 'changestatus'])->name('driverstatus');
        Route::get('manage-car', [ShowdataController::class, 'show_car'])->name('admin.manage-car');
        Route::get('manage-car/{id}', [SettingController::class, 'changestatus_car'])->name('changestatus');
        Route::get('manage-user', [\App\Http\Controllers\backend\ShowdataController::class, 'Show_user'])->name('admin.manage-user');
        Route::get('manage-role/{id}', [\App\Http\Controllers\backend\SettingController::class, 'edit_role']);
        Route::get('manage/{id}', [\App\Http\Controllers\backend\ShowdataController::class, 'caranddriver_aprove']);
        Route::get('manage-carin/{id}', [\App\Http\Controllers\backend\ShowdataController::class, 'caranddriver_edit']);
        Route::get('history', [\App\Http\Controllers\backend\ShowdataController::class, 'history'])->name('admin.booking_history');
        Route::get('setting', [\App\Http\Controllers\backend\SettingController::class, 'index'])->name('admin.setting');
        Route::post('approve', [\App\Http\Controllers\backend\AproveController::class, 'aprove_in'])->name('update');
        Route::post('approve-out', [\App\Http\Controllers\backend\AproveController::class, 'aprove_out'])->name('updateout');
        Route::get('cancel/{id}/{note}', [\App\Http\Controllers\backend\Bookingcontroller::class, 'cancle']);
        Route::post('admin/booking', [\App\Http\Controllers\backend\Bookingcontroller::class, 'store'])->name('send-booking');
        Route::post('edit-setting', [\App\Http\Controllers\backend\SettingController::class, 'edit_time']);
        Route::post('edit-book', [\App\Http\Controllers\backend\AproveController::class, 'edit_booking']);
        Route::post('edit-book', [\App\Http\Controllers\backend\AproveController::class, 'edit_']);
        Route::get('validate_booking', [\App\Http\Controllers\backend\Bookingcontroller::class, 'validate_booking']);
        Route::get('send-in/{id}', [\App\Http\Controllers\backend\EmailController::class, 'sendmail']);
        Route::get('send-out/{id}', [\App\Http\Controllers\backend\EmailController::class, 'sendmailout']);
        Route::get('booking-mail/{id}', [\App\Http\Controllers\backend\EmailController::class, 'mailbooking']);
        Route::get('message', [\App\Http\Controllers\backend\Bookingcontroller::class, 'shownoti']);


    }
);

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/noti', [DashboardAdminController::class, 'noti_menu'])->name('test');
Route::get('car/{id}', [\App\Http\Controllers\backend\ManagementAdminController::class, 'caranddriver_aprove']);



