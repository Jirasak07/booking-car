<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\timebookingModel;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function index()
    {
        $setting = timebookingModel::all();
        return view('admin.setting')->with(['time' => $setting]);
    }

    public function edit_time(Request $request)
    {

        $id = $request->id_form;
        $time = timebookingModel::find($id);
        $time->time = $request->time;
        $time->unit = $request->unit;
        if($request->unit == 'hours'){
            $time->unit_th = 'ชม.';
        }else if($request->unit == 'day'){
            $time->unit_th = 'วัน';
        }else{
            $time->unit_th = 'เดือน';
        }
        $time->save();
        return response()->json(['success' => 'Successfully']);
    }
}
