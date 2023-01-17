<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CarModel;



class AdminController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index()
    {
        $car = CarModel::All();
        $allbooking = BookingModel::count();
        $pending = BookingModel::where('booking_status',1)->count();
        $approve = BookingModel::where('booking_status',2)->count();
        $cancel = BookingModel::where('booking_status',3)->count();
        return view('admin.dashboard')->with(['car' => $car,'allbook'=>$allbooking,'pending'=>$pending ,'approve'=>$approve ,'cancel'=>$cancel]);
    }
    public function bookingRequest()
    {
        return view('admin.booking_request');
    }
    public function manageDriver()
    {
        return view('admin.manage_driver');
    }
    public function manageCar()
    {
        return view('admin.manage_car');
    }
    public function manageUser()
    {
        return view('admin.manage_user');
    }

}
