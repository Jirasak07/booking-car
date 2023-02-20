<?php

namespace App\Http\Controllers\api\AppMobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Loginapi extends Controller
{
    //
    public function login(Request $request)
    {

   
      
        if ($request->email == "" || $request->password == "") {
            return response()->json(['status'=>'error']);
        } else {
            // return response()->json($request);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.lanna.co.th/Profile/checkuser',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
    "Username":"' . $request->email . '",
    "Password":"' . $request->password . '"

}',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                ),
            ));

            $response = json_decode(curl_exec($curl));

            curl_close($curl);
            // return response()->json($response);
            if ($response->Result == "true") {
                $data = $response->Data[0];
                // dd('true');
                $email_chk = $data->Email;
                $user = User::where('email', $email_chk)->first();
                if (!$user) {
                    $user = new User();
                    //$user->username = $data->Username;
                    $user->name = $data->FullName;
                    $user->email = $data->Email;
                    $user->username = $data->Username;
                    $user_tb = DB::table('Users')->count();
                    if ($user_tb < 1) {
                        $user->role_user = "1";
                    } else {
                        $user->role_user = "2";
                    }
                    

                    $user->save();
                }
               
                if($user->role_user == "1"){
                    return response()->json(['role'=>'admin','status'=>'success','id'=>$user->id]);
                }else if($user->role_user == "2"){
                    return response()->json(['role'=>'user','status'=>'success','id'=>$user->id]);
                }
                
               
            } elseif ($response->Result == "authenfailed") { //password incorrect
                return response()->json(['status'=>$response->Result]);
            } elseif ($response->Result == "failed") { //email incorrect
                return response()->json(['status'=>$response->Result]);
            } elseif ($response->Result == "notfound") { //password and email incorrect or email incorrect
                return response()->json(['status'=>$response->Result]);
            }
        }
    }
}
