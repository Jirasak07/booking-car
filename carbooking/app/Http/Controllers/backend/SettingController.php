<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\timebookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    //
    public function index(){
        $setting = timebookingModel::all();
        return view('admin.setting')->with(['time'=>$setting]);
    }

    public function edit_time(Request $request){
        $id = $request->id_form;
        $time = timebookingModel::find($id);
        $time->time = $request->time;
        $time->unit = $request->unit;
        $time->save();
    }
}
