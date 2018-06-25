<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Cronjob;

use App\UserCoin;
use App\User;
use App\UserPackage;
use App\Wallet;
use DB;
use Log;

/**
 * 
 * @author giangdt
 *
 */

class ReturnCarForLandUser {
    
    public static function return() 
    {
        set_time_limit(0);
        //Get Land users
        $landUsers = UserCoin::where('usdAmount', '>', 1)->get();

        //Caculate revenue F1 from day (01/01/2018) project started
        foreach($landUsers as $user)
        {
            try {
                //Get F1 users
                $listF1 = User::where('refererId', $user->userId)->pluck('id')->toArray();
                
                $revenueF1 = DB::table('user_packages')
                                ->select(DB::raw('SUM(amount_increase) as sumamount'))
                                ->whereIn('userId', $listF1)
                                ->where('created_at', '>', '2018-01-01 00:00:01')
                                ->first();

                $percentReturn = 0.001;

                if($revenueF1->sumamount > 10000) $percentReturn = 0.002;
                if($revenueF1->sumamount > 20000) $percentReturn = 0.003;
                if($revenueF1->sumamount > 30000) $percentReturn = 0.004;
                if($revenueF1->sumamount > 40000) $percentReturn = 0.005;
                if($revenueF1->sumamount > 50000) $percentReturn = 0.006;
                if($revenueF1->sumamount > 60000) $percentReturn = 0.007;
                if($revenueF1->sumamount > 70000) $percentReturn = 0.008;
                if($revenueF1->sumamount > 80000) $percentReturn = 0.009;
                if($revenueF1->sumamount > 90000) $percentReturn = 0.01;

                //Return coin
                $returnAmount = $percentReturn * $user->availableAmount;
                if($user->usdAmount > $returnAmount)
                    $user->usdAmount -= $returnAmount;
                else{
                    $user->usdAmount = 0;
                    $returnAmount = $user->usdAmount;
                }
                $user->clpCoinAmount += $returnAmount;
                $user->save();

                $field = [
                    'walletType' => Wallet::CLP_WALLET,
                    'type' => Wallet::LAND_RETURN,
                    'inOut' => Wallet::IN,
                    'userId' => $user->userId,
                    'amount' => $returnAmount,
                    'note' => 'Return CAR for Land Users'
                ];

                Wallet::create($field);
            } catch (\Exception $e) {
                Log::info('Return CAR has error for user:' . $user->userId);
                Log::info($e->getTraceAsString());
            }
        }   
    }
}
