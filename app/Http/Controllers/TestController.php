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
        $users = UserData::where('packageId', '>', 0)->where('userId', '>', 2)->get();
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

    function test() 
    {
        //
        $userCoins = UserCoin::where('reinvestAmount', '>', 0)->get();

        foreach($userCoins as $user)
        {
            
            //insert log
            $fieldUsd = [
                'walletType' => Wallet::CLP_WALLET,//usd
                'type' =>  100,//bonus week
                'inOut' => Wallet::IN,
                'userId' => $user->userId,
                'amount' => $user->reinvestAmount,
                'note'  => 'Return car from reinvest wallet'
            ];

            Wallet::create($fieldUsd);

            $user->clpCoinAmount += $user->reinvestAmount;
            $user->reinvestAmount = 0;
            $user->save();
        }

        dd("XXX");
    }

    

}
