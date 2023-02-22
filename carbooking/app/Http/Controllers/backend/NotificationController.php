<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    //
    public function noti_aprove($id_booking)
    {
        $id = $id_booking;
        $booking = BookingModel::find($id);
        $token_device = DB::table('users')->where('id', '=', $booking->username)->
      select('token_device')->get();
    $token_de = array();
    foreach ($token_device as $item) {
        $token_de[] = [
            'token' => $item->token_device,
        ];
    }
    $token_de_string = implode(', ', array_column($token_de, 'token'));

        // $token = "d0SvAc8pAHg:APA91bHyjt1WtXJp2ZsadmR2iJmnKZjtA0R-EjhN4dSK_YCSj8GhqhFlYYDJHnXvVuyE3ixx36mPBI_pBbqE9IVyh-0kdZPVDZXOWqHO66Fnai3DnrXZgldPBdYHJ6Va76Om1KekE-za";
        // $token = User::whereNotNull()->where('id',$booking->username)->pluck('token_device')->all();
        $token =  $token_de_string;
        $from = "AAAAaxjJHUA:APA91bHLdfsZ_7JfjQEbgDKY49kG21k_OrbGepMG4F-7fq0QN3iaVrS1pXrsyTsmx2ptEvtOGs-lurR8MH_o4RpLUpV5FNCNmrfRQ1504-15_Cg5us3rJ4xA601T9MM842NO7Fz0EUgv";
        $msg = array(
            'body'  => "การจองอนุมัติแล้ว",
            'title' => "BookingCar Lannacom",
            'receiver' => 'erw',
            'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
            // 'sound' => 'mySound'/*Default sound*/
        );

        $fields = array(
            'to'        => $token,
            'notification'  => $msg
        );

        $headers = array(
            'Authorization: key=' . $from,
            'Content-Type: application/json'
        );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch );
        dd($result);
        curl_close( $ch );
    
    }

    public function noti_booking()
    {

        $token_device = DB::table('users')->where('role_user',3)->get();
        foreach($token_device as $item){
            $token = $item->token_device;
            $from = "AAAAaxjJHUA:APA91bHLdfsZ_7JfjQEbgDKY49kG21k_OrbGepMG4F-7fq0QN3iaVrS1pXrsyTsmx2ptEvtOGs-lurR8MH_o4RpLUpV5FNCNmrfRQ1504-15_Cg5us3rJ4xA601T9MM842NO7Fz0EUgv";
            $msg = array(
                'body'  => "มีรายการจองใหม่",
                'title' => "BookingCar Lannacom",
                'receiver' => 'erw',
                'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
                // 'sound' => 'mySound'/*Default sound*/
            );
                $fields = array(
                    'to'        => $token,
                    'notification'  => $msg
                );
        
                $headers = array(
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
                //#Send Reponse To FireBase Server 
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch );
                dd($result);
                curl_close( $ch );
            
            
        }
       

     
    }
}
