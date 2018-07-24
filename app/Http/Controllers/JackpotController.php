<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tickets;
use App\Awards;
use App\UserData;
use App\UserCoin;
use App\Notifications\UserAPI;
use Carbon\Carbon;
use App\User;
use Google2FA;
use Illuminate\Support\Str;


class JackpotController extends Controller
{ 
    public function createUser(Request $request)
    {
        try
        {
            if($request->isMethod('post'))
            {
                $accessToken = $request->api_key;
                $email = trim($request->email);
                $referralEmail = trim($request->referral_email);

                if($accessToken != config('app.access_token')) {
                    return response()->json(['result' => '0', 'error_msg' => 'Access token is invalid'], 500);
                }

                if($email == null){
                    return response()->json(['result' => '0', 'error_msg' => 'email is required'], 500);
                }

                if($referralEmail == null){
                    return response()->json(['result' => '0', 'error_msg' => 'referral_email is required'], 500);
                }

                //create user
                $exist = User::where('email', $email)->first();
                if($exist) {
                    return response()->json(['result' => '0', 'error_msg' => 'This email has been taken'], 500);
                }

                $emailSplit = explode("@", $email);
                $name = $emailSplit[0];

                $existName = User::where('name', $name)->first();
                if($existName) {
                    $dt = Carbon::now();
                    $name = $name . "csc" . $dt->hour;
                }

                //get referral id
                $referral = User::where('email', $referralEmail)->first();
                $password = Str::random();

                $fields = [
                        'name'              => $name,
                        'email'             => $email,
                        'password'          => bcrypt($password),
                        'refererId'         => isset($referral) ? $referral->id : 3042, //cscglobal
                        'active'            => 1,
                        'uid'               => User::getUid(),
                        'google2fa_secret'  => Google2FA::generateSecretKey(16)
                    ];

                $user = User::create($fields);

                //send email cho user
                $user->notify(new UserAPI($user, $password));

                //user_data
                $fieldData = [
                        'userId' => $user->id,
                        'refererId' => isset($referral) ? $referral->id : 3042 //cscglobal,
                    ];

                $userData = UserData::create($fieldData);

                //user_coin
                $userCoin = UserCoin::create(['userId' => $user->id]);

                return response()->json(['result' => '1', 'email' => $email], 200);
            } else {
                return response()->json(['result' => '0', 'error_msg' => 'Request is invalid'], 500);
            }

        }catch (\Exception $e){
            return response()->json(['result' => '0', 'error_msg' => 'Application have error'], 500);
        }
    }

    public function updateTicket(Request $request)
    {
        if($request->isMethod('post'))
        {
            $accessToken = $request->api_key;
            $emailTicketList = json_decode($request->data);

            if($accessToken != config('app.access_token')) {
                return response()->json(['result' => '0', 'error_msg' => 'Access token is invalid'], 500);
            }

            $successList = [];
            foreach($emailTicketList as $item)
            {
                //Update ticket
                try {
                    $year = date('Y');
                    
                    $dt = Carbon::parse($item->date_time);
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
                    $oUser = User::where('email', $item->email)->first();

                    //if not exist user continue check next item
                    if($oUser == null) continue;

                    $oTicket = Tickets::where('user_id', $oUser->id)->where('week_year', $weekYear)->first();
                    if(isset($oTicket)) {
                        $oTicket->personal_quantity += $item->ticket;
                        $oTicket->quantity += $item->ticket;
                        $oTicket->save();

                    } else {
                        $field = [
                                'user_id' => $oUser->id, 
                                'week_year' => $weekYear, 
                                'personal_quantity' => $item->ticket, 
                                'quantity' => $item->ticket
                            ];
                        Tickets::create($field);
                    }

                    //Update doanh so cho dai ly
                    if($oUser->userData->packageId == 0) {
                        //get id agency
                        $agencyId = User::_getAgency($oUser->id);
                        $oTicket = Tickets::where('user_id', $agencyId)->where('week_year', $weekYear)->first();
                        if(isset($oTicket)) {
                            $oTicket->quantity += $item->ticket;
                            $oTicket->save();
                        } else {
                            $field = ['user_id' => $agencyId, 'week_year' => $weekYear, 'quantity' => $item->ticket];
                            Tickets::create($field);
                        }
                    }

                    //add to success list
                    $successList[] = ['id' => $item->id];
                } catch (\Exception $e) {
                    \Log::info($e->getMessage());
                    \Log::info($e->getTraceAsString());
                    return response()->json(['result' => '0', 'error_msg' => 'Somethings wrong'], 500);
                }
            }

            return response()->json(['result' => '1', 'sucess_list' => $successList], 200);
        } else {
            return response()->json(['result' => '0', 'error_msg' => 'Request is invalid'], 500);
        }
    }

    public function updateAward(Request $request)
    {
        if($request->isMethod('post'))
        {
            $accessToken = trim($request->api_key);
            $emailWinningList = json_decode($request->data);

            if($accessToken != config('app.access_token')) {
                return response()->json(['result' => '0', 'error_msg' => 'Access token is invalid'], 500);
            }

            $successList = [];
            foreach($emailWinningList as $item)
            {
                //Update award
                try {
                    $year = date('Y');
                    
                    $dt = Carbon::parse($item->date_time);
                    $weeked = $dt->weekOfYear;
                    
                    $weekYear = $year . $weeked;

                    //get user id from name
                    $oUser = User::where('email', $item->email)->first();

                    //if not exist user continue check next item
                    if($oUser == null) {
                        \Log::info('winning ' . $item->email . ' not exits');
                        continue;
                    }

                    $oTicket = Awards::where('user_id', $oUser->id)->where('week_year', $weekYear)->first();
                    if(isset($oTicket)) {
                        $oTicket->personal_value += $item->value;
                        $oTicket->value += $item->value;
                        $oTicket->save();

                    } else {
                        $field = ['user_id' => $oUser->id, 'week_year' => $weekYear, 'personal_value' => $item->value, 'value' => $item->value];
                        Awards::create($field);
                    }

                    //Update doanh so cho dai ly
                    if($oUser->userData->packageId == 0) {
                        //get id agency
                        $agencyId = User::_getAgency($oUser->id);
                        $oTicket = Awards::where('user_id', $agencyId)->where('week_year', $weekYear)->first();
                        if(isset($oTicket)) {
                            $oTicket->value += $item->value;
                            $oTicket->save();
                        } else {
                            $field = ['user_id' => $agencyId, 'week_year' => $weekYear, 'value' => $item->value];
                            Awards::create($field);
                        }
                    }

                    //add to success list
                    $successList[] = ['id' => $item->id];
                } catch (\Exception $e) {
                    \Log::info($e->getMessage());
                    \Log::info($e->getTraceAsString());
                    return response()->json(['result' => '0', 'error_msg' => 'Somethings wrong'], 500);
                }
            }

            return response()->json(['result' => '1', 'sucess_list' => $successList], 200);
        } else {
            return response()->json(['result' => '0', 'error_msg' => 'Request is invalid'], 500);
        }
    }
}
