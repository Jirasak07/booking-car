<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
       
        return view('user.dashboard');
    }

    public function viewBooking()
    {
        return view('user.booking');
    }
}
