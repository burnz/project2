<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tickets;
use App\Awards;
use App\UserData;
use Carbon\Carbon;
use App\User;


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


            return response()->json(['result' => '1', 'email' => $email], 200);
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
            $dateTime = $request->date_time;

            if($accessToken != config('app.access_token')) {
                return response()->json(['result' => '0', 'error_msg' => 'Access token is invalid'], 500);
            }

            $hash = md5($email . $ticket . config('app.salt'));
            if($hash != strtolower($secondToken)) {
                return response()->json(['result' => '0', 'error_msg' => 'Validation token is invalid'], 500);
            }

            //Update ticket
            try {
                $year = date('Y');
                
                $dt = Carbon::parse($dateTime);
                $weeked = $dt->weekOfYear;
                //neu la CN thi day la ve cua tuan moi
                if($dt->dayOfWeek == 0){
                    $weeked = $weeked + 1;
                }

                //neu la thu 7 nhung qua 9h thi day la ve cua tuan moi
                if($dt->dayOfWeek == 6 && $dt->hour > 8){
                    $weeked = $weeked + 1;
                }

                if($weeked == 53) {
                    $weeked = 1;
                    $year += 1;
                }

                $weekYear = $year . $weeked;

                //get user id from name
                $oUser = User::where('email', $email)->first();

                $oTicket = Tickets::where('user_id', $oUser->id)->where('week_year', $weekYear)->first();
                if(isset($oTicket)) {
                    $oTicket->personal_quantity += $ticket;
                    $oTicket->quantity += $ticket;
                    $oTicket->save();

                } else {
                    $field = ['user_id' => $oUser->id, 'week_year' => $weekYear, 'personal_quantity' => $ticket, 'quantity' => $ticket];
                    Tickets::create($field);
                }

                //Update doanh so cho dai ly
                if($oUser->userData->packageId == 0) {
                    //get id agency
                    $agencyId = User::_getAgency($oUser->id);
                    $oTicket = Tickets::where('user_id', $agencyId)->where('week_year', $weekYear)->first();
                    if(isset($oTicket)) {
                        $oTicket->quantity += $ticket;
                        $oTicket->save();
                    } else {
                        $field = ['user_id' => $agencyId, 'week_year' => $weekYear, 'quantity' => $ticket];
                        Tickets::create($field);
                    }
                }

            } catch (\Exception $e) {
                return response()->json(['result' => '0', 'error_msg' => 'Somethings wrong'], 500);
            }

            return response()->json(['result' => '1', 'email' => $email, 'num_of_ticket' => $ticket], 200);
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
            $dateTime = $request->date_time;

            if($accessToken != config('app.access_token')) {
                return response()->json(['result' => '0', 'error_msg' => 'Access token is invalid'], 500);
            }

            $hash = md5($email . $award . config('app.salt'));
            if($hash != strtolower($secondToken)) {
                return response()->json(['result' => '0', 'error_msg' => 'Validation token is invalid'], 500);
            }

            //Update award
            try {
                $year = date('Y');
                
                $dt = Carbon::parse($dateTime);
                $weeked = $dt->weekOfYear;
                //neu la CN thi day la ve cua tuan moi
                if($dt->dayOfWeek == 0){
                    $weeked = $weeked + 1;
                }

                //neu la thu 7 nhung qua 9h thi day la ve cua tuan moi
                if($dt->dayOfWeek == 6 && $dt->hour > 8){
                    $weeked = $weeked + 1;
                }

                if($weeked == 53) {
                    $weeked = 1;
                    $year += 1;
                }

                $weekYear = $year . $weeked;

                //get user id from name
                $oUser = User::where('email', $email)->first();

                $oTicket = Awards::where('user_id', $oUser->id)->where('week_year', $weekYear)->first();
                if(isset($oTicket)) {
                    $oTicket->personal_value += $award;
                    $oTicket->value += $award;
                    $oTicket->save();

                } else {
                    $field = ['user_id' => $oUser->id, 'week_year' => $weekYear, 'personal_value' => $award, 'value' => $award];
                    Awards::create($field);
                }

                //Update doanh so cho dai ly
                if($oUser->userData->packageId == 0) {
                    //get id agency
                    $agencyId = User::_getAgency($oUser->id);
                    $oTicket = Awards::where('user_id', $agencyId)->where('week_year', $weekYear)->first();
                    if(isset($oTicket)) {
                        $oTicket->value += $award;
                        $oTicket->save();
                    } else {
                        $field = ['user_id' => $agencyId, 'week_year' => $weekYear, 'value' => $award];
                        Awards::create($field);
                    }
                }

            } catch (\Exception $e) {
                return response()->json(['result' => '0', 'error_msg' => 'Somethings wrong'], 500);
            }

            return response()->json(['result' => '1', 'email' => $email, 'value' => $award], 200);
        } else {
            return response()->json(['result' => '0', 'error_msg' => 'Request is invalid'], 500);
        }
    }
}
