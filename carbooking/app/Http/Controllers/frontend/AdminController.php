<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index()
    {

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
