<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;

class ManagementAdminController extends Controller
{
    //
    public function index()
    {
        $user = User::all();

        return view('admin.manage_user', ['user' => $user]);

    }

    public function edit_role($id)
    {
        $findSumAdmin = User::where('role_user', 1)->sum('id');

        $user = User::find($id);
        if ($user->role_user == 1) {
            if ($findSumAdmin > 1) {
                $user->role_user = 2;
                $user->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error']);
            }
        } else if ($user->role_user == 2) {
            $user->role_user = 1;
            $user->save();
            return response()->json(['status' => 'success']);
        }

    }
}
