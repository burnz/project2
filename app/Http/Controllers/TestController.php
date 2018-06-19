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
        $users = UserData::where('packageId','>', 0)->where('userId', '>', 2)->get();
        foreach($users as $user) {
            //get package value
            $packValue = DB::table('user_packages')->where('userId', $user->userId)->sum('amount_increase');

            if($packValue > 0 && $packValue < 2000) $user->packageId = 1;
            if($packValue >= 2000 && $packValue < 5000) $user->packageId = 2;
            if($packValue >= 5000 && $packValue < 10000) $user->packageId = 3;
            if($packValue >= 10000 && $packValue < 20000) $user->packageId = 4;
            if($packValue >= 20000) $user->packageId = 5;

            $user->save();
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

            $oAward = Award::where('user_id', $oUser->id)->where('week_year', $weekYear)->first();
            if(isset($oAward)) {
                $oAward->value += $ticket;
                $oAward->save();

            } else {
                $field = ['user_id' => $oUser->id, 'week_year' => $weekYear, 'value' => $award];
                Award::create($field);
            }

            flash()->success('Update successully.');

        } catch (\Exception $e) {
            flash()->fail('Update fail.');
        }

        return redirect()->route('test.showAward');
    }

    function test() 
    {
        //
    }

    

}
