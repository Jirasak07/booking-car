<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\CarModel;

class AdminController extends Controller
{
    //
    public function index()
    {
        $car = CarModel::All();
        return view('admin.dashboard')->with(['car' => $car]);
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
