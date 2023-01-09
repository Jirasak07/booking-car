<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        return view('admin.dashboard');
    }
    public function bookingRequest(){
        return view('admin.booking_request');
    }
    public function manageDriver(){
        return view('admin.manage_driver');
    }
}
