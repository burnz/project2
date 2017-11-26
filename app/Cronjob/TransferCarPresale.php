<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Cronjob;

use App\UserPackage;
use App\User;
use App\UserCoin;
use App\Order;
use App\ExchangeRate;
use DB;
use Carbon\Carbon;

/**
 * Description of UpdateStatusBTCTransaction
 *
 * @author giangdt
 */
class TransferCarPresale
{
    
    /**
    * This cronjob function will every days to caculate and return interest to user's wallet 
    */
    public static function transfer(){
        set_time_limit(0);
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();
        try {
            $lstOrder = Order::where('created_at', '>', $yesterday)
                            ->where('created_at', '<', $today)
                            ->where('status', 0)
                            ->orderBy('price', 'desc')
                            ->get();

            $maxCoinSupply = 200000;

            foreach($lstOrder as $order)
            {
                //if order success continue
                if($order->status == 1 || $order->status == 2) continue;

                //If sold out change all order status pending => cancel
                if($maxCoinSupply == 0)
                {
                    $order->status = 2;
                    $order->save();

                    //Return BTC
                    $userCoin->btcCoinAmount = ($userCoin->btcCoinAmount + $order->value);
                    $userCoin->save();
                }

                if($order->amount <= $maxCoinSupply)
                {
                    //Send coin to user car wallet
                    $userCoin = UserCoin::where('userId', $order->user_id)->first();
                    $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $order->amount);
                    $userCoin->save();

                    //Chang status order from pending => success
                    $order->status = 1;
                    $order->save();
                    $maxCoinSupply = $maxCoinSupply - $order->amount;
                } else
                {
                    //Send coin to user car wallet
                    $userCoin = UserCoin::where('userId', $order->user_id)->first();
                    $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $maxCoinSupply);
                    $userCoin->save();

                    //Chang status order from pending => success, update amount order
                    $order->status = 1;
                    $order->amount = $maxCoinSupply;
                    $order->save();

                    //Create new order with cancel status
                    $btcValue = ($order->amount - $maxCoinSupply) * $order->price;
                    $cancelOrder = [
                            'user_id' => $order->user_id,
                            'amount' => ($order->amount - $maxCoinSupply),
                            'price' => $order->price,
                            'value' = $btcValue,
                            'status' => 2,
                            'created_at' => $order->created_at,
                            'updated_at' => $order->created_at
                        ];
                    Order::create($cancelOrder);

                    //Return BTC
                    $userCoin->btcCoinAmount = ($userCoin->btcCoinAmount + $btcValue);
                    $userCoin->save();

                    $maxCoinSupply = 0;
                }
            }
        } catch(\Exception $e) {
            \Log::error('Running auction has error: ' . date('Y-m-d') .$e->getMessage());
            \Log::error($e->getTraceAsString());
        }
    }    


    /**
    * This cronjob function will run every 00:01 Monday of week to caculate and return bonus to user's wallet 
    */
    public static function bonusBinaryWeekCron()
    {
        set_time_limit(0);
        /* Get previous weekYear */
        /* =======BEGIN ===== */
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        if($weeked < 10) $weekYear = $year.'0'.$weeked;

        $firstWeek = $weeked - 1;
        $firstYear = $year;
        $firstWeekYear = $firstYear.$firstWeek;

        if($firstWeek == 0){
            $firstWeek = 52;
            $firstYear = $year - 1;
            $firstWeekYear = $firstYear.$firstWeek;
        }

        if($firstWeek < 10) $firstWeekYear = $firstYear.'0'.$firstWeek;

        /* =======END ===== */

        $lstBinary = BonusBinary::where('weekYear', '=', $firstWeekYear)->get();
        foreach ($lstBinary as $binary) 
        {
            //Get cron status
            $cronStatus = CronBinaryLogs::where('userId', $binary->userId)->first();
            if(isset($cronStatus) && $cronStatus->status == 1) continue;

            $leftOver = $binary->leftOpen + $binary->leftNew;
            $rightOver = $binary->rightOpen + $binary->rightNew;

            if ($leftOver >= $rightOver) {
                $leftOpen = $leftOver - $rightOver;
                $rightOpen = 0;
                $settled = $rightOver;
            } else {
                $leftOpen = 0;
                $rightOpen = $rightOver - $leftOver;
                $settled = $leftOver;
            }

            $bonus = 0;
            $userPackage = $binary->userData->package;
            if(isset($userPackage))
            {
                if (User::checkBinaryCount($binary->userId, 1)) {
                    if ($userPackage->pack_id == 1) {
                        $bonus = $settled * config('cryptolanding.binary_bonus_1_pay');
                    } elseif ($userPackage->pack_id == 2) {
                        $bonus = $settled * config('cryptolanding.binary_bonus_2_pay');
                    } elseif ($userPackage->pack_id == 3) {
                        $bonus = $settled * config('cryptolanding.binary_bonus_3_pay');
                    } elseif ($userPackage->pack_id == 4) {
                        $bonus = $settled * config('cryptolanding.binary_bonus_4_pay');
                    } elseif ($userPackage->pack_id == 5) {
                        $bonus = $settled * config('cryptolanding.binary_bonus_5_pay');
                    } elseif ($userPackage->pack_id == 6) {
                        $bonus = $settled * config('cryptolanding.binary_bonus_6_pay');
                    }
                }
            }

            $binary->settled = $settled;

            //Bonus canot over maxout $35,000
            if($bonus > config('cryptolanding.bonus_maxout')) $bonus = config('cryptolanding.bonus_maxout');

            $binary->bonus = $bonus;
            $binary->save();

            if($bonus > 0){
                $usdAmount = $bonus * config('cryptolanding.usd_bonus_pay');
                $reinvestAmount = $bonus * config('cryptolanding.reinvest_bonus_pay') / ExchangeRate::getCLPUSDRate();

                $userCoin = $binary->userCoin;
                $userCoin->usdAmount = ($userCoin->usdAmount + $usdAmount);
                $userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
                $userCoin->save();

                $fieldUsd = [
                    'walletType' => Wallet::USD_WALLET,//usd
                    'type' =>  Wallet::BINARY_TYPE,//bonus week
                    'inOut' => Wallet::IN,
                    'userId' => $binary->userId,
                    'amount' => $usdAmount,
                ];

                Wallet::create($fieldUsd);

                $fieldInvest = [
                    'walletType' => Wallet::REINVEST_WALLET,//reinvest
                    'type' => Wallet::BINARY_TYPE,//bonus week
                    'inOut' => Wallet::IN,
                    'userId' => $binary->userId,
                    'amount' => $reinvestAmount,
                ];

                Wallet::create($fieldInvest);
            }

            //Check already have record for this week?
            
            $weeked = date('W');
            $year = date('Y');
            $weekYear = $year.$weeked;

            if($weeked < 10) $weekYear = $year.'0'.$weeked;

            $week = BonusBinary::where('userId', '=', $binary->userId)->where('weekYear', '=', $weekYear)->first();
            // Yes => update L-Open, R-Open
            if(isset($week) && $week->id > 0) {
                $week->leftOpen = $leftOpen;
                $week->rightOpen = $rightOpen;

                $week->save();
            } else {
                // No => create new
                $field = [
                    'userId' => $binary->userId,
                    'weeked' => $weeked,
                    'year' => $year,
                    'leftNew' => 0,
                    'rightNew' => 0,
                    'leftOpen' => $leftOpen,
                    'rightOpen' => $rightOpen,
                    'weekYear' => $weekYear,
                ];

                BonusBinary::create($field);
            }

            //Update cron status from 0 => 1
            $cronStatus->status = 1;
            $cronStatus->save();
        }

        //Update status from 1 => 0 after run all user
        DB::table('cron_binary_logs')->update(['status' => 0]);
    }
}
