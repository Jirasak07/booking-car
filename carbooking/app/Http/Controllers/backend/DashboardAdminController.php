<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DashboardAdminController extends Controller
{
    //
    function index(){
        
       
        
        $date = Carbon::now()->format('d-m-Y H:i:s');
        // // dd($date);
        $bookingcar1ad =DB::table('tb_booking')
        ->where('license_plate' ,'=', 1)
        ->where('type_car' ,'=', 1)
        ->where('booking_status','=', 2)->count();

        $bookingcar2ad =DB::table('tb_booking')
        ->where('license_plate' ,'=', 2)
        ->where('type_car' ,'=', 1)
        ->where('booking_status','=', 2)->count();

        $bookingcar1wil =DB::table('tb_booking')
        ->where('license_plate' ,'=', 1)
        ->where('type_car' ,'=', 1)
        ->where('booking_status','=', 1)->count();

        $bookingcar2wil =DB::table('tb_booking')
        ->where('license_plate' ,'=', 2)
        ->where('type_car' ,'=', 1)->count();

        $bookingcar1wil =DB::table('tb_booking')
        ->where('license_plate' ,'=', 1)
        ->where('type_car' ,'=', 1)
        ->where('booking_status','=', 3)->count();

        $bookingcar1 =DB::table('tb_booking')
        ->where('license_plate' ,'=', 1)
        ->where('type_car' ,'=', 1)->count();

        $bookingcar2 =DB::table('tb_booking')
        ->where('license_plate' ,'=', 2)
        ->where('type_car' ,'=', 1)->count();

        $bookingcarAllin =DB::table('tb_booking')
        ->where('type_car' ,'=', 1)->count();

        $bookingcarAllout =DB::table('tb_booking')
        ->where('type_car' ,'=', 2)->count();
       
       return dd($date);
        
        // return view('admin.dashboard');
    }

}
