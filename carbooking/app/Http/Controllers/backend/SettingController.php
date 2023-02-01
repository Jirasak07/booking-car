<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\timebookingModel;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //

    public function edit_time(Request $request){
        $id = $request->id_form;
        $time = timebookingModel::find($id);
        $time->time = $request->time;
        $time->unit = $request->unit;
        $time->save();
    }
}
