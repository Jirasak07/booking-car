<?php

namespace App\Http\Controllers\api\AppMobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Loginapi extends Controller
{
    //
    function Login(Request $request){
        $data_login = DB::table('users')->where('email',$request->email)->first();
        if (!$data_login) {
            $user = new User();
            //$user->username = $data->Username;
            $user->name = $request->FullName;
            $user->email = $request->Email;
            $user->username = $request->Username;
            $user_tb = DB::table('Users')->count();
            if ($user_tb < 1) {
                $user->role_user = "1";
            } else {
                $user->role_user = "2";
            }

            $user->save();
        }return response()->json(201);

        
    }
}
