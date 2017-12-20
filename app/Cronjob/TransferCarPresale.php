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
use App\OrderList;
use App\ExchangeRate;
use DB;
use App\Wallet;
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
        $today = Carbon::today();

        if($today > config('app.pre_sale_end')) return ;

        set_time_limit(0);
        
        $endTime = date('Y-m-d 21:00:00');
        
        $yesterday = Carbon::yesterday()->toDateString();
        $startTime = strtotime($yesterday . '+21 hours');

        $startTime = date('Y-m-d H:i:s', $startTime);

        try {
            $lstOrder = OrderList::where('created_at', '>', $startTime)
                            ->where('created_at', '<', $endTime)
                            ->where('status', 1)
                            ->orderBy('price', 'desc')
                            ->orderBy('created_at', 'asc')
                            ->get();

            $maxCoinSupply = 200000;

            foreach($lstOrder as $order)
            {
                //if order success continue
                if($order->status == 2 || $order->status == 0) continue;

                //If sold out change all order status pending => cancel
                if($maxCoinSupply == 0)
                {
                    $order->status = 0;
                    $order->save();

                    //Return BTC
                    $userCoin = UserCoin::where('userId', $order->user_id)->first();
                    $userCoin->btcCoinAmount = ($userCoin->btcCoinAmount + $order->btc_value);
                    $userCoin->save();
                    continue;
                }

                if($order->amount <= $maxCoinSupply)
                {
                    //Send coin to user car wallet
                    $userCoin = UserCoin::where('userId', $order->user_id)->first();
                    $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $order->amount);
                    $userCoin->save();
                    //+5% cho giới thiêu
                    $sponsorID = User::find($order->user_id)->refererId;
                    if($sponsorID){
                        $bonusSponsor = $order->amount * 5 / 100;
                        //+user coin
                        $userCoin = UserCoin::where('userId', $sponsorID)->first();
                        $userCoin->clpCoinAmount = $userCoin->clpCoinAmount + $bonusSponsor;
                        $userCoin->save();
                        //lưu log
                        $fieldCLP = [
                            'walletType' => Wallet::CLP_WALLET,//usd
                            'type' => 0,
                            'inOut' => Wallet::IN,
                            'userId' => $sponsorID,
                            'amount' => $bonusSponsor,
                            'note'   => '5% from ' . User::find($order->user_id)->name . '\'s auction'
                        ];
                        Wallet::create($fieldCLP);
                    }
                    //Chang status order from pending => success
                    $order->status = 2;
                    $order->save();
                    $maxCoinSupply = $maxCoinSupply - $order->amount;
                } else
                {
                    //Send coin to user car wallet
                    $userCoin = UserCoin::where('userId', $order->user_id)->first();
                    $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $maxCoinSupply);
                    $userCoin->save();

                    //+5% cho giới thiêu
                    $sponsorID = User::find($order->user_id)->refererId;
                    if($sponsorID){
                        $bonusSponsor = $maxCoinSupply * 5 / 100;
                        //+user coin
                        $userCoin = UserCoin::where('userId', $sponsorID)->first();
                        $userCoin->clpCoinAmount = $userCoin->clpCoinAmount + $bonusSponsor;
                        $userCoin->save();
                        //lưu log
                        $fieldCLP = [
                            'walletType' => Wallet::CLP_WALLET,//usd
                            'type' => 0,
                            'inOut' => Wallet::IN,
                            'userId' => $sponsorID,
                            'amount' => $bonusSponsor,
                            'note'   => '5% from ' . User::find($order->user_id)->name . '\'s auction'
                        ];
                        Wallet::create($fieldCLP);
                    }

                    //Create new order with cancel status
                    $totalValue = ($order->amount - $maxCoinSupply) * $order->price;
                    $btcValue = ($order->amount - $maxCoinSupply) / $order->amount * $order->btc_value;

                    //Chang status order from pending => success, update amount order
                    $order->status = 2;
                    $order->amount = $maxCoinSupply;
                    $order->save();

                    //Create new order with cancel status
                    $cancelOrder = [
                            'user_id' => $order->user_id,
                            'code' => md5(uniqid($order->user_id, true)),
                            'amount' => ($order->amount - $maxCoinSupply),
                            'price' => $order->price,
                            'total' => $totalValue,
                            'btc_rate' => $order->btc_rate,
                            'btc_value' => $btcValue,
                            'status' => 0,
                            'created_at' => $order->created_at,
                            'updated_at' => $order->updated_at
                        ];

                    OrderList::create($cancelOrder);

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
}
