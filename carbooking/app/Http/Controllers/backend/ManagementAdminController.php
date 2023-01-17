<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagementAdminController extends Controller
{
    //
    function index(){
        $user = User::all();
        
        return view('admin.manage_user',['user'=> $user]);

    }


    function edit_role($id){
        $user = User::find($id);
        if($user->role_user == 1){
            $user->role_user == 2;

        }else{
            $user->role_user == 1;
        }
        $user->save();
        return redirect()->back();
    }
}
