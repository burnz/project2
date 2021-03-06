<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Notification;
use App\UserCoin;
use App\UserData;
use App\User;
use App\Wallet;
use DB;
use Log;
use App\ExchangeRate;
use App\ExchangeRateAPI;
use App\Cronjob\AutoAddBinary;
use App\CLPWallet;
use App\CLPWalletAPI;
use App\Helper\Helper;
use App\Cronjob\GetClpWallet;
use App\Cronjob\TransferCarPresale;
use App\OrderList;
use Carbon\Carbon;
use App\CronProfitLogs;
use App\CronBinaryLogs;
use App\CronMatchingLogs;
use App\CronLeadershipLogs;
use App\TotalWeekSales;
use App\UserPackage;

use App\Cronjob\Bonus;
use App\BonusBinary;

use Ratchet\Client\Connector as Connection;
use React\Socket\Connector;
use React\EventLoop\Factory;

use App\Tickets;
use App\Awards;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzClient;
use App\UserFailList;

/**
 * Description of TestController
 *
 * @author giangdt
 */
class TestController {
     private $helper;
    private $clpwallet;
    private $clpwalletapi;

    function __construct(Helper $helper, CLPWallet $clpwallet, CLPWalletAPI $clpwalletapi) {
        $this->helper = $helper;
        $this->clpwallet = $clpwallet;
        $this->clpwalletapi = $clpwalletapi;
    }
    //put your code here
    function testInterest($param = null) {
        //Get Notification
        Bonus::bonusNewAgencyCron();
        echo "Return bonus day for user successfully!";
    }
    function testInfinityBonus()
    {
        Bonus::bonusBinaryWeekCron();
        return 'Return bonus infinity week for user successfully';
    }
    function testInfinityInterest()
    {
        Bonus::bonusRevenueCron();
        return 'Return bonus Infinity Interest week for user successfully';
    }
    function testGlobalBonus()
    {
        Bonus::bonusAwardCron();
        return 'Return gobal bonus month for user successfully';
    }

    function testBinary($param = null) {
        //Get Notification
        User::bonusBinaryWeekCron();
        echo "Return binary bonus this week for user successfully!";
    }

    function testAutoAddBinary($param = null) {
        //Get Notification
        AutoAddBinary::addBinary();
        echo "Return auto add binary successfully!";
    }

    public function convertPackage()
    {
        //auto add
        $users = UserData::where('packageId', '>', 0)->where('userId', '>', 2)->whereNotIn('userId', [1318,909,908,876,2401,2418,2405,2402,2407,2419,2515,451,2153,2145,2134,2068,2071,2107,2164,584,580,611,627,590,602,599,2161,2999,2993,3010,3007,2991,1238,1196,1226,1224,1186,1143,1144,1146,1138,1199,1168,1162,1220,1234,1235,1180,1147,2423,3301,3289,3206,3277,3292,1240,1077,1142])->get();
        foreach($users as $user) {
            //get package value
            $packValue = DB::table('user_packages')->where('userId', $user->userId)->where('withdraw', 0)->sum('amount_increase');
            $packCar = DB::table('user_packages')->where('userId', $user->userId)->where('withdraw', 0)->sum('amount_carcoin');
            $pack = UserPackage::where('userId', $user->userId)->first();

            $packId = 0;
            if($packValue > 0 && $packValue < 2000) $packId = 1;
            if($packValue >= 2000 && $packValue < 5000) $packId = 2;
            if($packValue >= 5000 && $packValue < 10000) $packId = 3;
            if($packValue >= 10000 && $packValue < 20000) $packId = 4;
            if($packValue >= 20000) $packId = 5;

            //update all pack release
            UserPackage::where('userId', $user->userId)->update(['withdraw' => 1]);

            if($packId > 0)
            {
                $field = [
                    'userId' => $user->userId,
                    'packageId' => $packId,
                    'amount_increase' => $packValue,
                    'amount_carcoin' => $packCar,
                    'created_at' => '2018-07-01 07:18:07',
                    'updated_at' => '2018-07-01 07:18:07',
                    'buy_date' => '2018-07-01 07:18:07',
                    'withdraw' => 0,
                    'weekYear' => '201827',
                    'refund_type' => $pack->refund_type,
                ];

                UserPackage::create($field);
            }

            
        }

        dd("successfully");
    }

    function getAvailableAmount() {

        try {

            $passDate = date('Y-m-d', strtotime("-6 months"));

            $dataRelaseTimeToday = DB::table('wallets')
                    ->select('userId', 'inOut', DB::raw('SUM(amount) as sumamount'))
                    ->whereDate('created_at', $passDate)
                    ->groupBy('userId', 'inOut')
                    ->get();

            //get all userId from all record from $dataRelaseTimeYesterday
            $availableUser = array();
            foreach ($dataRelaseTimeToday as $value) {
                if ($value->inOut == 'in')
                    $availableUser[$value->userId] = $value->sumamount;
            }
            //update available amount
            if (isset($availableUser) && count($availableUser) > 0) {
                foreach ($availableUser as $key => $value) {
                    UserCoin::where("userId", $key)
                            ->update(
                                    ["availableAmount" =>
                                        ( UserCoin::where("userId", $key)->first()->
                                        availableAmount + $value )
                                    ]
                    );
                }
            }
        } catch (\Exception $ex) {
            Log::error($ex->gettraceasstring());
        }
    }

    function showUpdateTicket() 
    {
        return view('adminlte::user.test_update_ticket');
    }

    function updateTicket(Request $request) 
    {
        $username = $request->name;
        $ticket = $request->ticket;

        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        try {
            //get user id from name
            $oUser = User::where('name', $username)->first();

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
                $oTicket = Tickets::where('user_id', $oUser->refererId)->where('week_year', $weekYear)->first();
                if(isset($oTicket)) {
                    $oTicket->quantity += $ticket;
                    $oTicket->save();
                } else {
                    $field = ['user_id' => $oUser->refererId, 'week_year' => $weekYear, 'quantity' => $ticket];
                    Tickets::create($field);
                }
            }

            flash()->success('Update successully.');

        } catch (\Exception $e) {
            flash()->fail('Update fail.');
        }

        return redirect()->route('test.showTicket');
    }

    function showUpdateAward() 
    {
        return view('adminlte::user.test_update_award');
    }

    function updateAward(Request $request) 
    {
        $username = $request->name;
        $award = $request->award;

        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        try {
            //get user id from name
            $oUser = User::where('name', $username)->first();

            $oAward = Awards::where('user_id', $oUser->id)->where('week_year', $weekYear)->first();
            if(isset($oAward)) {
                $oAward->personal_value += $award;
                $oAward->value += $award;
                $oAward->save();

            } else {
                $field = ['user_id' => $oUser->id, 'week_year' => $weekYear, 'personal_value' => $award, 'value' => $award];
                Awards::create($field);
            }

            //Update doanh so cho dai ly
            if($oUser->userData->packageId == 0) {
                $oAward = Awards::where('user_id', $oUser->refererId)->where('week_year', $weekYear)->first();
                if(isset($oAward)) {
                    $oAward->value += $award;
                    $oAward->save();
                } else {
                    $field = ['user_id' => $oUser->refererId, 'week_year' => $weekYear, 'value' => $award];
                    Awards::create($field);
                }
            }

            flash()->success('Update successully.');

        } catch (\Exception $e) {
            echo $e->getMessage();
            //flash()->fail('Update fail.');
        }

        return redirect()->route('test.showAward');
    }

    //Call API to create user on cscjackpot
    public function createUserCSCJackpot($email, $referralEmail)
    {
        $client = new GuzzClient([
            'base_uri' => config('app.cscjackpot_uri'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        $data = [
                    'Email' => $email,
                    'EmailReferal' => $referralEmail,
                    'APIKey' => config('app.jackpot_api_key')
                ];
        $request = $client->request('POST', '/api/User/CreateUser', ['json' => $data]);

        $contents = $request->getBody()->getContents();
        $result = json_decode($contents, true);

        //if fail insert to log
        if($result['IsError'] == 1) {
            $fields = ['email' => $email, 'referral_email' => $referralEmail, 'status' => 0];
            UserFailList::create($fields);
        }
    }

    function test() 
    {
        //up gói tự động
        $userPackage = ['chihieu.luong@gmail.com', 'phuonghongcb85@gmail.com', 'sin92tn@gmail.com', 'justin.nguyen.hn@gmail.com', 'hoahoangh2n@gmail.com'];
        $baotro = ['donhung499@gmail.com', 'lequan90tn@gmail.com', 'chuyencoi77@gmail.com', 'chihieu.luong@gmail.com', 'phuonghongcb85@gmail.com'];

        foreach($userPackage as $key => $userData)
        {            
            //echo $userData . '---'  . $baotro[$key];
            $this->createUserCSCJackpot($userData, $baotro[$key]);
        }

        dd("XXX");
    }

    static function getNextActiveAgency($id) {
        $ref = UserData::where('userId', '=', $id)->first();
        if($ref->packageId == 0) {
            self::getNextActiveAgency($ref->userId);
        }else{
            return $ref->userId;
        }
    }

}
