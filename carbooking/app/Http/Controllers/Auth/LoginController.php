<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {

//dd($request->all());
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
        //  dd($response);
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
                $user->password = encrypt($request->password);
                $user->lore_user = "1";
                $user->save();
            }
            $this->guard()->login($user, true);
            
            return redirect()->route("admin.dashboard");
            //dd(auth()->user());
        } else {
            dd("false");
        }
    }
    public function logout()
    {
        \Auth::logout();
        return redirect('/');
    }
}
