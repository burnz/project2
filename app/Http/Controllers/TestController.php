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

use App\Cronjob\Bonus;
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

        Bonus::bonusDayCron();
        echo "Return bonus day for user successfully!";
    }
    function testInfinityBonus()
    {
        Bonus::bonusBinaryWeekCron();
        return 'Return bonus infinity week for user successfully';
    }
    function testInfinityInterest()
    {
        Bonus::bonusMatchingWeekCron();
        return 'Return bonus Infinity Interest week for user successfully';
    }
    function testGlobalBonus()
    {
        Bonus::globalBonus();
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

    function test() {
        set_time_limit(0);
        //Update logs for Land users
        $landUsers = UserData::where('packageId', '>', 0)->where('userId', '<', 3669)->where('userId', '>', 2)->get();
        foreach($landUsers as $user) {
            if(CronProfitLogs::where('userId', $user->userId)->count() < 1) 
                CronProfitLogs::create(['userId' => $user->userId]);
            if(CronBinaryLogs::where('userId', $user->userId)->count() < 1) 
                CronBinaryLogs::create(['userId' => $user->userId]);
            if(CronMatchingLogs::where('userId', $user->userId)->count() < 1) 
                CronMatchingLogs::create(['userId' => $user->userId]);
            if(CronLeadershipLogs::where('userId', $user->userId)->count() < 1) 
                CronLeadershipLogs::create(['userId' => $user->userId]);
            if(TotalWeekSales::where('userId', $user->userId)->count() < 1) 
                TotalWeekSales::create(['userId' => $user->userId]);
        }
    }

    private function GenerateAddress( $name = null ) {
        $data = [];
       
        // tạo acc ví cho tk
        $configuration = Configuration::apiKey( config('app.coinbase_key'), config('app.coinbase_secret'));
        $client = Client::create($configuration);

        //Account detail
        $account = $client->getAccount(config('app.coinbase_account'));

        // Generate new address and get this adress
        $address = new Address([
            'name' => $name
        ]);

        //Generate new address
        $client->createAccountAddress($account, $address);

        //Get all address
        $listAddresses = $client->getAccountAddresses($account);

        $address = '';
        $id = '';
        foreach($listAddresses as $add) {
            if($add->getName() == $name) {
                $address = $add->getAddress();
                $id = $add->getId();
                break;
            }
        }

        $data = [ "accountId" => $id,
            "walletAddress" => $address ];

        return $data;
            
    }

}
