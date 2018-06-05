<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Cronjob;

use App\UserPackage;
use App\User;
use App\UserData;
use App\Wallet;
use App\BonusBinary;
use App\ExchangeRate;
use App\CronProfitLogs;
use App\CronBinaryLogs;
use App\CronMatchingLogs;
use App\CronLeadershipLogs;
use App\TotalWeekSales;
use App\UserTreePermission;
use App\BonusBinaryInterest;
use App\LoyaltyUser;
use App\HighestPrice;

use DB;
use Log;
use App\Package;
use App\UserCoin;
/**

 * Description of UpdateStatusBTCTransaction
 *
 * @author giangdt
 */
class Bonus
{
	
	/**
	* This cronjob function will run every 00:01 Monday of week to caculate and return bonus to user's wallet 
	*/
	public static function bonusBinaryWeekCron()//infinity
	{
		set_time_limit(0);
		/* Get previous weekYear */
		/* =======BEGIN ===== */
		$weeked = date('W');
		$year = date('Y');
		$weekYear = $year.$weeked;

		$firstWeek = $weeked -1; //if run cronjob in 00:00:00 sunday
		$firstYear = $year;
        $firstWeekYear = $firstYear.$firstWeek;

		if($firstWeek == 0){
			$firstWeek = 52;
			$firstYear = $year - 1;
			$firstWeekYear = $firstYear.$firstWeek;
		}

		if($firstWeek < 10 && $firstWeek > 0) $firstWeekYear = $firstYear.'0'.$firstWeek;

		/* =======END ===== */
        try {
            $lstBinary = BonusBinary::where('weekYear', '=', $firstWeekYear)->get();
            foreach ($lstBinary as $binary)
            {
                //Get cron status
                $cronStatus = CronBinaryLogs::where('userId', $binary->userId)->first();
                if(!is_null($cronStatus)) {
                    if( $cronStatus->status == 1) continue;
                } else {
                    //insert to log
                    $field = [
                        'userId' => $binary->userId,
                        'status' => 0,
                    ];
                    
                    CronBinaryLogs::create($field);
                }

                //in the initial period don't care about condition
                if(config('app.condition')) {
                    //get total sale this week
                    $totalTicket = Tickets::where('user_id', $user->userId)->where('week_year', $firstWeekYear)->get();

                    if($totalTicket->quantity >= config('carcoin.condition')[1] &&
                        $user->packageId >= 1)
                    {
                        $maxLevel = 1;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[2] &&
                        $user->packageId >= 2)
                    {
                        $maxLevel = 2;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[3] &&
                        $user->packageId >= 3)
                    {
                        $maxLevel = 3;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[4] &&
                        $user->packageId >= 4)
                    {
                        $maxLevel = 4;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[5] &&
                        $user->packageId >= 5)
                    {
                        $maxLevel = 5;
                    }
                }

                $lefAgencyF1 = UserData::where('refererId', '=', $binary->userId)
                                ->where('status', 1)->where('leftRight',  'left')->count();
                $rightAgencyF1 = UserData::where('refererId', '=', $binary->userId)
                                ->where('status', 1)->where('leftRight',  'right')->count();

                //Caculate level to get binary commision
                $level = 0;
                $percentBonus = 0;
                $packageId = $binary->userData->packageId;

                if($lefAgencyF1 >= 1 &&
                    $rightAgencyF1 >= 1 &&
                    $packageId >= 1 )
                {
                    $percentBonus = config('carcoin.bi_lv_1_bonus');
                }

                if($lefAgencyF1 >= 2 &&
                    $rightAgencyF1 >= 2 &&
                    $packageId >= 2)
                {
                    $percentBonus = config('carcoin.bi_lv_2_bonus');
                }

                if($lefAgencyF1 >= 3 &&
                    $rightAgencyF1 >= 3 &&
                    $packageId >= 3)
                {
                    $percentBonus = config('carcoin.bi_lv_3_bonus');
                }

                if($lefAgencyF1 > 4 &&
                    $rightAgencyF1 > 4 &&
                    $packageId >= 4)
                {
                    $percentBonus = config('carcoin.bi_lv_4_bonus');
                }

                if($lefAgencyF1 > 5 &&
                    $rightAgencyF1 > 5 &&
                    $packageId >= 5)
                {
                    $percentBonus = config('carcoin.bi_lv_5_bonus');
                }

                if($leftOver > $rightOver) $level = $rightOver;
                else $level = $leftOver;

                $leftOpen = $leftOver - $level;
                $rightOpen = $rightOver - $level;

                $bonus = $level * $percentBonus;


                $binary->settled = $level;

                //Bonus canot over maxout $30,000
                if($bonus > config('carcoin.bonus_maxout')) $bonus = config('carcoin.bonus_maxout');

                $binary->bonus = $bonus;
                $binary->save();

                if($bonus > 0){
                    $clpAmount = $bonus / HighestPrice::getCarHighestPrice();

                    $userCoin = $binary->userCoin;
                    $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $clpAmount);
                    $userCoin->save();

                    $fieldUsd = [
                        'walletType' => Wallet::CLP_WALLET,//usd
                        'type' =>  Wallet::BINARY_TYPE,//bonus week
                        'inOut' => Wallet::IN,
                        'userId' => $binary->userId,
                        'amount' => $clpAmount,
                        'amount_usd' => $bonus * config('carcoin.clp_bonus_pay'),
                        'note'	=> ''
                    ];

                    Wallet::create($fieldUsd);
                }

                //Check already have record for this week?
                $weeked = date('W');
                $year = date('Y');
                $weekYear = $year.$weeked;

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
                //echo $binary->userId . "---";
                if(!is_null($cronStatus)) {
                    $cronStatus->status = 1;
                    $cronStatus->save();
                }
            }

            //Update status from 1 => 0 after run all user
            DB::table('cron_binary_logs')->update(['status' => 0]);
        } catch(\Exception $e) {
            Log::error('Running Binary Bonus has error: ' . date('Y-m-d') .$e->getMessage());
            Log::info($e->getTraceAsString());
        }
	}

	/**
	* This cronjob function will run every week ( return by BTC )
	*/
	public static function bonusRevenueCron()
	{
		set_time_limit(0);
        /* Get previous weekYear */
        /* =======BEGIN ===== */
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        $firstWeek = $weeked -1; //if run cronjob in 00:00:00 sunday
        $firstYear = $year;
        $firstWeekYear = $firstYear.$firstWeek;

        if($firstWeek == 0){
            $firstWeek = 52;
            $firstYear = $year - 1;
            $firstWeekYear = $firstYear.$firstWeek;
        }

        if($firstWeek < 10 && $firstWeek > 0) $firstWeekYear = $firstYear.'0'.$firstWeek;

        /* =======END ===== */
        try {
            $lstUser = UserData::where('status', '=', 1)->get();
            foreach($lstUser as $user){
                //Get cron status
                $cronStatus = CronLeadershipLogs::where('userId', $user->userId)->first();
                if(!is_null($cronStatus)) {
                    if($cronStatus->status == 1) continue;
                } else {
                    //insert to log
                    $field = [
                        'userId' => $user->userId,
                        'status' => 0,
                    ];
                    
                    CronLeadershipLogs::create($field);
                }

                $maxLevel = 0;
                //in the initial period don't care about condition
                if(config('app.condition')) {
                    //get total sale this week
                    $totalTicket = Tickets::where('user_id', $user->userId)->where('week_year', $firstWeekYear)->get();

                    if($totalTicket->quantity >= config('carcoin.condition')[1] &&
                        $user->packageId >= 1)
                    {
                        $maxLevel = 1;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[2] &&
                        $user->packageId >= 2)
                    {
                        $maxLevel = 2;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[3] &&
                        $user->packageId >= 3)
                    {
                        $maxLevel = 3;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[4] &&
                        $user->packageId >= 4)
                    {
                        $maxLevel = 4;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[5] &&
                        $user->packageId >= 5)
                    {
                        $maxLevel = 5;
                    }
                } else {
                    switch($user->packageId) {
                        case 1: $maxLevel = 1;
                                break;
                        case 2: $maxLevel = 2;
                                break;
                        case 3: $maxLevel = 3;
                                break;
                        case 4: $maxLevel = 4;
                                break;
                        case 5: $maxLevel = 5;
                                break;
                    }
                }

                if($maxLevel > 0) {
                    $bonus = 0;
                    self::calculateRevenueByLevel(array($user->userId), $firstWeekYear, 1, $maxLevel, $bonus);

                    //each ticket price 0.0002 btc
                    $bonus = $bonus * 0.0002;
                    $userCoin = $user->userCoin;
                    $userCoin->btcCoinAmount = ($userCoin->btcCoinAmount + $bonus);
                    $userCoin->save();

                    //insert to log
                    $fieldUsd = [
                        'walletType' => Wallet::BTC_WALLET,
                        'type' => Wallet::REVENUE_BONUS,
                        'inOut' => Wallet::IN,
                        'userId' => $user->userId,
                        'amount' => $bonus,
                        'note'   => 'return revenue bonus',
                    ];
                    
                    Wallet::create($fieldUsd);
                }

                //Update cron status from 0 => 1
                if(!is_null($cronStatus)) {
                    $cronStatus->status = 1;
                    $cronStatus->save();
                }
            }

            //Update status from 1 => 0 after run all user
            DB::table('cron_leadership_logs')->update(['status' => 0]);
        } catch(\Exception $e) {
            Log::error('Running Revenue Bonus has error: ' . date('Y-m-d') .$e->getMessage());
            Log::info($e->getTraceAsString());
        }
	}

    /**
    * This cronjob function will run every week ( return by BTC )
    */
    public static function bonusAwardCron()
    {
        set_time_limit(0);
        /* Get previous weekYear */
        /* =======BEGIN ===== */
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        $firstWeek = $weeked -1; //if run cronjob in 00:00:00 sunday
        $firstYear = $year;
        $firstWeekYear = $firstYear.$firstWeek;

        if($firstWeek == 0){
            $firstWeek = 52;
            $firstYear = $year - 1;
            $firstWeekYear = $firstYear.$firstWeek;
        }

        if($firstWeek < 10 && $firstWeek > 0) $firstWeekYear = $firstYear.'0'.$firstWeek;

        /* =======END ===== */
        try {
            $lstUser = UserData::where('status', '=', 1)->get();
            foreach($lstUser as $user){
                //Get cron status
                $cronStatus = CronMatchingLogs::where('userId', $user->userId)->first();
                if(!is_null($cronStatus)) {
                    if($cronStatus->status == 1) continue;
                } else {
                    //insert to log
                    $field = [
                        'userId' => $user->userId,
                        'status' => 0,
                    ];
                    
                    CronMatchingLogs::create($field);
                }

                //in the initial period don't care about condition
                $award = Awards::where('user_id', $user->userId)->where('week_year', $firstWeekYear)->first();

                if($award->value > 0) {
                    $user = User::find($user->userId);
                    self::calculateAwardReturn($user->refererId, $award->value, 1, $firstWeekYear, $user->name);
                }

                //Update cron status from 0 => 1
                if(!is_null($cronStatus)) {
                    $cronStatus->status = 1;
                    $cronStatus->save();
                }
            }

            //Update status from 1 => 0 after run all user
            DB::table('cron_matching_logs')->update(['status' => 0]);
        } catch(\Exception $e) {
            Log::error('Running Award Bonus has error: ' . date('Y-m-d') .$e->getMessage());
            Log::info($e->getTraceAsString());
        }
    }

    /**
    * This cronjob function will run every week ( return by BTC )
    */
    public static function bonusNewAgencyCron()
    {
        set_time_limit(0);
        /* Get previous weekYear */
        /* =======BEGIN ===== */
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        $firstWeek = $weeked -1; //if run cronjob in 00:00:00 sunday
        $firstYear = $year;
        $firstWeekYear = $firstYear.$firstWeek;

        if($firstWeek == 0){
            $firstWeek = 52;
            $firstYear = $year - 1;
            $firstWeekYear = $firstYear.$firstWeek;
        }

        if($firstWeek < 10 && $firstWeek > 0) $firstWeekYear = $firstYear.'0'.$firstWeek;

        /* =======END ===== */
        try {
            $lstUser = UserData::where('status', '=', 1)->get();
            foreach($lstUser as $user){
                //Get cron status
                $cronStatus = CronProfitLogs::where('userId', $user->userId)->first();
                if(!is_null($cronStatus)) {
                    if($cronStatus->status == 1) continue;
                } else {
                    //insert to log
                    $field = [
                        'userId' => $user->userId,
                        'status' => 0,
                    ];
                    
                    CronProfitLogs::create($field);
                }

                $maxLevel = 0;
                //in the initial period don't care about condition
                if(config('app.condition')) {
                    //get total sale this week
                    $totalTicket = Tickets::where('user_id', $user->userId)->where('week_year', $firstWeekYear)->get();

                    if($totalTicket->quantity >= config('carcoin.condition')[1] &&
                        $user->packageId >= 1)
                    {
                        $maxLevel = 1;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[2] &&
                        $user->packageId >= 2)
                    {
                        $maxLevel = 2;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[3] &&
                        $user->packageId >= 3)
                    {
                        $maxLevel = 3;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[4] &&
                        $user->packageId >= 4)
                    {
                        $maxLevel = 4;
                    }

                    if($totalTicket->quantity >= config('carcoin.condition')[5] &&
                        $user->packageId >= 5)
                    {
                        $maxLevel = 5;
                    }
                } else {
                    switch($user->packageId) {
                        case 1: $maxLevel = 1;
                                break;
                        case 2: $maxLevel = 2;
                                break;
                        case 3: $maxLevel = 3;
                                break;
                        case 4: $maxLevel = 4;
                                break;
                        case 5: $maxLevel = 5;
                                break;
                    }
                }

                if($maxLevel > 0) {
                    $bonus = 0;
                    self::calculateBonusOnNewAgency(array($user->userId), $firstWeekYear, 1, $maxLevel, $bonus);

                    $bonusCar = $bonus / HighestPrice::getCarHighestPrice();
                    $userCoin = $user->userCoin;
                    $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $bonusCar);
                    $userCoin->save();

                    //insert to log
                    $fieldUsd = [
                        'walletType' => Wallet::CLP_WALLET,
                        'type' => Wallet::AGENCY_BONUS,
                        'inOut' => Wallet::IN,
                        'userId' => $user->userId,
                        'amount' => $bonusCar,
                        'note'   => 'new agency bonus',
                    ];
                    
                    Wallet::create($fieldUsd);
                }

                //Update cron status from 0 => 1
                if(!is_null($cronStatus)) {
                    $cronStatus->status = 1;
                    $cronStatus->save();
                }
            }

            //Update status from 1 => 0 after run all user
            DB::table('cron_profit_day_logs')->update(['status' => 0]);
        } catch(\Exception $e) {
            Log::error('Running Profit Bonus has error: ' . date('Y-m-d') .$e->getMessage());
            Log::info($e->getTraceAsString());
        }
    }

    /* 
    *  Calculate bonus base on  revenue of agency
    *  @userId array
    *  @maxLevel max level of agency can receive bonus
    */
    public static function calculateRevenueByLevel($userId = array(), $weekYear, $level = 1, $maxLevel, &$bonus)
    {
        //get all F1
        $listF1 = DB::table('users')->whereIn('refererId', $userId)->get();
        //calculate revenue
        $revenue = DB::table('tickets')->whereIn('user_id', $listF1)->where('week_year','=', $weekYear)->sum('quantity');

        $commision = 0;
        if($level == 1) $commision = 0.05;
        if($level == 2) $commision = 0.02;
        if($level == 3) $commision = 0.01;
        if($level == 4) $commision = 0.01;
        if($level == 5) $commision = 0.01;

        $bonus += $revenue * $commision;

        if($level <= $maxLevel)
            self::calculateRevenueByLevel($listF1, $weekYear, $level + 1, $maxLevel, &$bonus);
    }

    /* 
    *  Calculate bonus base on  award
    *  @sponsorId int
    *  @valueAward double value of award
    */
    public static function calculateAwardReturn($sponsorId, $valueAward, $level = 1, $weekYear, $agencyName = '')
    {
        //get all F1
        $sponsorData = UserData::find($sponsorId);
        
        $commission = 0;
        if(config('app.condition')) {
            //get total sale this week
            $totalTicket = Tickets::where('user_id', $sponsorData->userId)->where('week_year', $weekYear)->first();

            if($level == 1 && $sponsorData->packageId >= 1 && 
                $totalTicket->quantity >= config('carcoin.condition')[1]) $commission = 0.02;
            if($level == 2 && $sponsorData->packageId >= 2 && 
                $totalTicket->quantity >= config('carcoin.condition')[2]) $commission = 0.01;
            if($level == 3 && $sponsorData->packageId >= 3 && 
                $totalTicket->quantity >= config('carcoin.condition')[3]) $commission = 0.01;
            if($level == 4 && $sponsorData->packageId >= 4 && 
                $totalTicket->quantity >= config('carcoin.condition')[4]) $commission = 0.005;
            if($level == 5 && $sponsorData->packageId >= 5 && 
                $totalTicket->quantity >= config('carcoin.condition')[5]) $commission = 0.005;
        } else {
            if($level == 1 && $sponsorData->packageId >= 1) $commission = 0.02;
            if($level == 2 && $sponsorData->packageId >= 2) $commission = 0.01;
            if($level == 3 && $sponsorData->packageId >= 3) $commission = 0.01;
            if($level == 4 && $sponsorData->packageId >= 4) $commission = 0.005;
            if($level == 5 && $sponsorData->packageId >= 5) $commission = 0.005;
        }

        $bonus = $valueAward * $commission;

        $userCoin = $sponsorData->userCoin;
        if($userCoin && $bonus > 0)
        {
            $userCoin->btcCoinAmount = ($userCoin->btcCoinAmount + $bonus);
            $userCoin->save();
            
            $fieldUsd = [
                'walletType' => Wallet::BTC_WALLET,
                'type' => Wallet::AWARD_BONUS,
                'inOut' => Wallet::IN,
                'userId' => $sponsorData->userId,
                'amount' => $bonus,
                'note'   => 'return award bonus from ' . $agencyName,
            ];
            
            Wallet::create($fieldUsd);
        }

        if($level <= 5)
            self::calculateAwardReturn($sponsorData->userId, $valueAward, $level + 1);
    }

    /* 
    *  Calculate bonus base on  new agency
    *  @userId array
    *  @maxLevel max level of agency can receive bonus
    */
    public static function calculateBonusOnNewAgency($userId = array(), $weekYear, $level = 1, $maxLevel, &$bonus)
    {
        //get all F1
        $listF1 = DB::table('users')->whereIn('refererId', $userId)->get();
        //calculate revenue
        $totalPackage = DB::table('user_packages')->whereIn('userId', $listF1)->where('weekYear','=', $weekYear)->sum('amount_increase');

        $commision = 0;
        if($level == 1) $commision = 0.05;
        if($level == 2) $commision = 0.04;
        if($level == 3) $commision = 0.03;
        if($level == 4) $commision = 0.02;
        if($level == 5) $commision = 0.01;

        $bonus += $totalPackage * $commision;

        if($level <= $maxLevel)
            self::calculateBonusOnNewAgency($listF1, $weekYear, $level + 1, $maxLevel, &$bonus);
    }
}
