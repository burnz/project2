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
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();

        if($today > config('app.pre_sale_end')) return ;

        set_time_limit(0);
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();
        try {
            $lstOrder = OrderList::where('created_at', '>', $yesterday)
                            ->where('created_at', '<', $today)
                            ->where('status', 1)
                            ->orderBy('price', 'desc')
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
                    $userCoin->btcCoinAmount = ($userCoin->btcCoinAmount + $order->btc_value);
                    $userCoin->save();
                }

                if($order->amount <= $maxCoinSupply)
                {
                    //Send coin to user car wallet
                    $userCoin = UserCoin::where('userId', $order->user_id)->first();
                    $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $order->amount);
                    $userCoin->save();

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

                    //Chang status order from pending => success, update amount order
                    $order->status = 2;
                    $order->amount = $maxCoinSupply;
                    $order->save();

                    //Create new order with cancel status
                    $totalValue = ($order->amount - $maxCoinSupply) * $order->price;
                    $btcValue = ($order->amount - $maxCoinSupply) / $order->amount * $order->btc_value;
                    $cancelOrder = [
                            'user_id' => $order->user_id,
                            'amount' => ($order->amount - $maxCoinSupply),
                            'price' => $order->price,
                            'total' = $totalValue,
                            'btc_rate' = $order->btc_rate,
                            'btc_value' = $btcValue,
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
