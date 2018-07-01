<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;


class JackpotController extends Controller
{ 
    public function createUser(Request $request)
    {
        if($request->isMethod('post'))
        {
            $accessToken = $request->first_token;
            $secondToken = $request->second_token;
            $email = $request->email;

            if($accessToken != config('app.access_token')) {
                return response()->json(['result' => '0', 'error_msg' => 'Access token is invalid'], 500);
            }

            $hash = md5($email . config('app.salt'));
            if($hash != strtolower($secondToken)) {
                return response()->json(['result' => '0', 'error_msg' => 'Validation token is invalid'], 500);
            }

            //create user


            return response()->json(['result' => '1'], 200);
        } else {
            return response()->json(['result' => '0', 'error_msg' => 'Request is invalid'], 500);
        }
    }

    public function updateTicket(Request $request)
    {
        if($request->isMethod('post'))
        {
            $accessToken = $request->first_token;
            $secondToken = $request->second_token;
            $email = $request->email;
            $ticket = $request->num_of_ticket;

            if($accessToken != config('app.access_token')) {
                return response()->json(['result' => '0', 'error_msg' => 'Access token is invalid'], 500);
            }

            $hash = md5($email . $ticket . config('app.salt'));
            if($hash != strtolower($secondToken)) {
                return response()->json(['result' => '0', 'error_msg' => 'Validation token is invalid'], 500);
            }

            return response()->json(['result' => '1'], 200);
        } else {
            return response()->json(['result' => '0', 'error_msg' => 'Request is invalid'], 500);
        }
        
    }

    public function updateAward(Request $request)
    {
        if($request->isMethod('post'))
        {
            $accessToken = $request->first_token;
            $secondToken = $request->second_token;
            $email = $request->email;
            $award = $request->value;

            if($accessToken != config('app.access_token')) {
                return response()->json(['result' => '0', 'error_msg' => 'Access token is invalid'], 500);
            }

            $hash = md5($email . $award . config('app.salt'));
            if($hash != strtolower($secondToken)) {
                return response()->json(['result' => '0', 'error_msg' => 'Validation token is invalid'], 500);
            }


            return response()->json(['result' => '1'], 200);
        } else {
            return response()->json(['result' => '0', 'error_msg' => 'Request is invalid'], 500);
        }
    }

}
