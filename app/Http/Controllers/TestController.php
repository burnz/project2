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
use App\BonusBinary;
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
        Bonus::bonusLeadershipMonthCron();
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
        //Insert log for user root (2)
        $field = ['userId' => 2, 'status' => 0];
        CronLeadershipLogs::create($field);
        CronMatchingLogs::create($field);
        CronProfitLogs::create($field);
        CronBinaryLogs::create($field);

        // dd("XXX");
        //Update logs for Land users
        $listUser = DB::table('bonus_binary')->distinct()->whereNull('bonus')->where('bonus_tmp', '>', 0)->get(['userId']);
        //dd($listUser);
        foreach ($listUser as $key => $value) 
        {
            //if(in_array($value->userId, array('875', '876', '908', '1240', '1318', '2423' , '3042', '3637', '3673', '3727', '3731', '3827'))) continue;
            $bonusList = BonusBinary::whereNull('bonus')->where('weeked', '>', 2)->where('weeked', '<', 7)->where('userId', '=', $value->userId)->orderBy('id', 'asc')->get();
            
            $rightOpen = 0; $leftOpen = 0;
            foreach ($bonusList as $key => $val) {
                if($val->bonus_tmp === 0) continue; 
                $rightOpen += $val->rightOpen + $val->rightNew;
                $leftOpen += $val->leftOpen + $val->leftNew;
            }

            //dd($bonusList);

            //dd($value->userId . '---L:' . $leftOpen . '---R:' . $rightOpen);

            //select weeked 7
            $weeked = BonusBinary::where('weeked', 7)->where('userId', $value->userId)->first();
            if($weeked) {
                $weeked->rightOpen = $rightOpen;
                $weeked->leftOpen = $leftOpen;
                $weeked->save();
            } else {
                $fieldUsd = [
                    'userId' => $value->userId,
                    'rightOpen' => $rightOpen,
                    'leftOpen' => $leftOpen,
                    'rightNew' => 0,
                    'leftNew' => 0,
                    'weeked' => 7,
                    'year' => 2018,
                    'weekYear' => '201807'
                ];

                BonusBinary::create($fieldUsd);
            }

        }
        dd("DONE");
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
