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
        $url = ('http://127.0.0.1:8000/api/booking');
        dd($url);
        return view('user.dashboard');
    }

    public function viewBooking()
    {
        return view('user.booking');
    }
}
