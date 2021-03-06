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
use App\WeekTicketsHistory;
use App\WeekAgencyHistory;
use App\WeekAwardsHistory;
use App\Tickets;
use App\Awards;
use Carbon\Carbon;

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
		$dt = Carbon::now();
        $weeked = $dt->weekOfYear;
        $year = date('Y');

        $firstWeekYear = $year . $weeked; //current week because the cronjob run on Sunday

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
                    $percentBonus = config('carcoin.binary_level_1');
                }

                if($lefAgencyF1 >= 2 &&
                    $rightAgencyF1 >= 2 &&
                    $packageId >= 2)
                {
                    $percentBonus = config('carcoin.binary_level_2');
                }

                if($lefAgencyF1 >= 3 &&
                    $rightAgencyF1 >= 3 &&
                    $packageId >= 3)
                {
                    $percentBonus = config('carcoin.binary_level_3');
                }

                if($lefAgencyF1 > 4 &&
                    $rightAgencyF1 > 4 &&
                    $packageId >= 4)
                {
                    $percentBonus = config('carcoin.binary_level_4');
                }

                if($lefAgencyF1 > 5 &&
                    $rightAgencyF1 > 5 &&
                    $packageId >= 5)
                {
                    $percentBonus = config('carcoin.binary_level_5');
                }

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

                $binary->settled = $settled;

                $bonus = $settled * $percentBonus;

                //Bonus canot over maxout $30,000
                if($bonus > config('carcoin.bonus_maxout')) $bonus = config('carcoin.bonus_maxout');

                $binary->bonus = $bonus;
                $binary->save();

                if($bonus > 0){
                    $clpAmount = $bonus / HighestPrice::getCarHighestPrice();

                    $userCoin = $binary->userCoin;
                    $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $clpAmount);
                    //$userCoin->usdAmount = ($userCoin->usdAmount + $bonus);
                    $userCoin->save();

                    $fieldUsd = [
                        'walletType' => Wallet::CLP_WALLET,//usd
                        'type' =>  Wallet::BINARY_TYPE,//bonus week
                        'inOut' => Wallet::IN,
                        'userId' => $binary->userId,
                        'amount' => $clpAmount,
                        'note'	=> ''
                    ];

                    Wallet::create($fieldUsd);
                }

                //Check already have record for this week?
                $todayDate = Carbon::now();
                $weeked = $todayDate->weekOfYear;

                if($todayDate->dayOfWeek == 0){ //because run on sunday
                    $weeked = $weeked + 1;
                }

                if($weeked == 53) {
                    $weeked = 1;
                    $year += 1;
                }

                $weekYear = $year . $weeked;

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

        $dt = Carbon::now();
        $weeked = $dt->weekOfYear;
        $year = date('Y');

        $firstWeekYear = $year . $weeked; //current week because the cronjob run on Sunday

        try {

            $lstUser = UserData::where('packageId', '>', 0)->orderBy('userId','asc')->get();
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
                //get total sale this week
                $totalTicket = Tickets::where('user_id', $user->userId)->where('week_year', $firstWeekYear)->first();
                $personalSale = isset($totalTicket) ? $totalTicket->quantity : 0;

                if($personalSale >= config('carcoin.condition')[1] &&
                    $user->packageId >= 1)
                {
                    $maxLevel = 1;
                }

                if($personalSale >= config('carcoin.condition')[2] &&
                    $user->packageId >= 2)
                {
                    $maxLevel = 2;
                }

                if($personalSale >= config('carcoin.condition')[3] &&
                    $user->packageId >= 3)
                {
                    $maxLevel = 3;
                }

                if($personalSale >= config('carcoin.condition')[4] &&
                    $user->packageId >= 4)
                {
                    $maxLevel = 4;
                }

                if($personalSale >= config('carcoin.condition')[5] &&
                    $user->packageId >= 5)
                {
                    $maxLevel = 5;
                }

                if($maxLevel > 0) {
                    //Inset to weekly log
                    $fields = [
                        'user_id' => $user->userId,
                        'week_year' => $firstWeekYear,
                    ];

                    WeekTicketsHistory::create($fields);

                    //calculate revenue
                    $oTicket = Tickets::where('user_id', $user->userId)
                            ->where('week_year','=', $firstWeekYear)
                            ->first();

                    if(isset($oTicket)) $revenue = $oTicket->quantity - $oTicket->personal_quantity;
                    else $revenue = 0;
                    
                    $bonusDirect =  $revenue * config('carcoin.ticket_dr_cus');

                    if($bonusDirect > 0) {
                        $btcBonus = $bonusDirect * config('carcoin.price_per_ticket');
                        //insert to log
                        $fieldUsd = [
                            'walletType' => Wallet::BTC_WALLET,
                            'type' => Wallet::REVENUE_RETAIL_BONUS,
                            'inOut' => Wallet::IN,
                            'userId' => $user->userId,
                            'amount' => $btcBonus,
                            'note'   => 'Retail Bonus',
                        ];
                        
                        Wallet::create($fieldUsd);

                        WeekTicketsHistory::where('week_year', $firstWeekYear)
                                    ->where('user_id', $user->userId)
                                    ->update(['direct_cus' => $bonusDirect]);

                    }

                    $bonus = 0;
                    self::calculateRevenueByLevel(array($user->userId), $firstWeekYear, 1, $maxLevel, $bonus, $user->userId);

                    if($bonus > 0) {
                        //each ticket price 0.0002 btc
                        $btcAmountBonus = $bonus * config('carcoin.price_per_ticket');
                        $userCoin = $user->userCoin;
                        $userCoin->btcCoinAmount = ($userCoin->btcCoinAmount + $btcAmountBonus);
                        $userCoin->save();

                        //insert to log
                        $fieldUsd = [
                            'walletType' => Wallet::BTC_WALLET,
                            'type' => Wallet::REVENUE_UNILEVEL_BONUS,
                            'inOut' => Wallet::IN,
                            'userId' => $user->userId,
                            'amount' => $btcAmountBonus,
                            'note'   => 'Unilevel Bonus',
                        ];
                        
                        Wallet::create($fieldUsd);

                        WeekTicketsHistory::where('week_year', $firstWeekYear)
                        ->where('user_id', $user->userId)
                        ->update(['total' => $bonus]);
                    }
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

        $dt = Carbon::now();
        $weeked = $dt->weekOfYear;
        $year = date('Y');

        $firstWeekYear = $year . $weeked; //current week because the cronjob run on Sunday

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

                $maxLevel = 0;
                //in the initial period don't care about condition
                //get total sale this week
                $totalTicket = Tickets::where('user_id', $user->userId)->where('week_year', $firstWeekYear)->first();

                $personalSale = isset($totalTicket) ? $totalTicket->quantity : 0;

                if($personalSale >= config('carcoin.condition')[1] &&
                    $user->packageId >= 1)
                {
                    $maxLevel = 1;
                }

                if($personalSale >= config('carcoin.condition')[2] &&
                    $user->packageId >= 2)
                {
                    $maxLevel = 2;
                }

                if($personalSale >= config('carcoin.condition')[3] &&
                    $user->packageId >= 3)
                {
                    $maxLevel = 3;
                }

                if($personalSale >= config('carcoin.condition')[4] &&
                    $user->packageId >= 4)
                {
                    $maxLevel = 4;
                }

                if($personalSale >= config('carcoin.condition')[5] &&
                    $user->packageId >= 5)
                {
                    $maxLevel = 5;
                }

                if($maxLevel > 0) {
                    //Inset to weekly log
                    $fields = [
                        'user_id' => $user->userId,
                        'week_year' => $firstWeekYear,
                    ];

                    WeekAwardsHistory::create($fields);

                    $oAward = Awards::where('user_id', $user->userId)
                            ->where('week_year','=', $firstWeekYear)
                            ->first();

                    if(isset($oAward)) $value = $oAward->value - $oAward->personal_value;
                    else $value = 0;
                    
                    $directBonus = $value * config('carcoin.award_dr_cus');

                    if($directBonus > 0) {
                        WeekAwardsHistory::where('week_year', $firstWeekYear)
                                ->where('user_id', $user->userId)
                                ->update(['direct_cus' => $directBonus]);

                        $fieldUsd = [
                            'walletType' => Wallet::BTC_WALLET,
                            'type' => Wallet::AWARD_WINNING_BONUS,
                            'inOut' => Wallet::IN,
                            'userId' => $user->userId,
                            'amount' => $directBonus,
                            'note'   => 'Winning Bonus',
                        ];
                        
                        Wallet::create($fieldUsd);
                    }

                    $bonus = 0;
                    self::calculateAwardReturn(array($user->userId), $firstWeekYear, 1, $maxLevel, $bonus, $user->userId);

                    if($bonus > 0) {
                        $userCoin = $user->userCoin;
                        $userCoin->btcCoinAmount = ($userCoin->btcCoinAmount + $bonus);
                        $userCoin->save();

                        //insert to log
                        $fieldUsd = [
                            'walletType' => Wallet::BTC_WALLET,
                            'type' => Wallet::AWARD_UNILEVEL_BONUS,
                            'inOut' => Wallet::IN,
                            'userId' => $user->userId,
                            'amount' => $bonus,
                            'note'   => 'Winning Unilevel Bonus',
                        ];
                        
                        Wallet::create($fieldUsd);

                        WeekAwardsHistory::where('week_year', $firstWeekYear)
                        ->where('user_id', $user->userId)
                        ->update(['total' => $bonus]);
                    }
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
    // public static function bonusNewAgencyCron()
    // {
    //     set_time_limit(0);
    //     /* Get previous weekYear */
    //     /* =======BEGIN ===== */
    //     $weeked = date('W');
    //     $year = date('Y');
    //     $weekYear = $year.$weeked;

    //     $firstWeek = $weeked -1; //if run cronjob in 00:00:00 sunday
    //     $firstYear = $year;
    //     $firstWeekYear = $firstYear.$firstWeek;

    //     if($firstWeek == 0){
    //         $firstWeek = 52;
    //         $firstYear = $year - 1;
    //         $firstWeekYear = $firstYear.$firstWeek;
    //     }

    //     if($firstWeek < 10 && $firstWeek > 0) $firstWeekYear = $firstYear.'0'.$firstWeek;

    //     /* =======END ===== */
    //     try {
    //         $lstUser = UserData::where('status', '=', 1)->get();
    //         foreach($lstUser as $user){
    //             //Get cron status
    //             $cronStatus = CronProfitLogs::where('userId', $user->userId)->first();
    //             if(!is_null($cronStatus)) {
    //                 if($cronStatus->status == 1) continue;
    //             } else {
    //                 //insert to log
    //                 $field = [
    //                     'userId' => $user->userId,
    //                     'status' => 0,
    //                 ];
                    
    //                 CronProfitLogs::create($field);
    //             }

    //             $maxLevel = 0;
    //             //in the initial period don't care about condition
    //             if(config('app.condition')) {
    //                 //get total sale this week
    //                 $totalTicket = Tickets::where('user_id', $user->userId)->where('week_year', $firstWeekYear)->get();

    //                 if($totalTicket->quantity >= config('carcoin.condition')[1] &&
    //                     $user->packageId >= 1)
    //                 {
    //                     $maxLevel = 1;
    //                 }

    //                 if($totalTicket->quantity >= config('carcoin.condition')[2] &&
    //                     $user->packageId >= 2)
    //                 {
    //                     $maxLevel = 2;
    //                 }

    //                 if($totalTicket->quantity >= config('carcoin.condition')[3] &&
    //                     $user->packageId >= 3)
    //                 {
    //                     $maxLevel = 3;
    //                 }

    //                 if($totalTicket->quantity >= config('carcoin.condition')[4] &&
    //                     $user->packageId >= 4)
    //                 {
    //                     $maxLevel = 4;
    //                 }

    //                 if($totalTicket->quantity >= config('carcoin.condition')[5] &&
    //                     $user->packageId >= 5)
    //                 {
    //                     $maxLevel = 5;
    //                 }
    //             } else {
    //                 switch($user->packageId) {
    //                     case 1: $maxLevel = 1;
    //                             break;
    //                     case 2: $maxLevel = 2;
    //                             break;
    //                     case 3: $maxLevel = 3;
    //                             break;
    //                     case 4: $maxLevel = 4;
    //                             break;
    //                     case 5: $maxLevel = 5;
    //                             break;
    //                 }
    //             }

    //             if($maxLevel > 0) {
    //                 $exit = WeekAgencyHistory::where('user_id', $user->userId)->where('week_year', $firstWeekYear)->first();

    //                 if(!isset($exit)) {
    //                     $fields = [
    //                         'user_id' => $user->userId,
    //                         'week_year' => $firstWeekYear,
    //                     ];

    //                     WeekAgencyHistory::create($fields);
    //                 }

    //                 $bonus = 0;
    //                 self::calculateBonusOnNewAgency(array($user->userId), $firstWeekYear, 1, $maxLevel, $bonus, $user->userId);

    //                 if($bonus > 0) {
    //                     $bonusCar = $bonus / HighestPrice::getCarHighestPrice();
    //                     $userCoin = $user->userCoin;
    //                     $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $bonusCar);
    //                     $userCoin->save();

    //                     //insert to log
    //                     $fieldUsd = [
    //                         'walletType' => Wallet::CLP_WALLET,
    //                         'type' => Wallet::AGENCY_BONUS,
    //                         'inOut' => Wallet::IN,
    //                         'userId' => $user->userId,
    //                         'amount' => $bonusCar,
    //                         'amount_usd' => $bonus,
    //                         'note'   => 'agency bonus',
    //                     ];
                        
    //                     Wallet::create($fieldUsd);
    //                 }
    //             }

    //             //Update cron status from 0 => 1
    //             if(!is_null($cronStatus)) {
    //                 $cronStatus->status = 1;
    //                 $cronStatus->save();
    //             }
    //         }

    //         //Update status from 1 => 0 after run all user
    //         DB::table('cron_profit_day_logs')->update(['status' => 0]);
    //     } catch(\Exception $e) {
    //         Log::error('Running Profit Bonus has error: ' . date('Y-m-d') .$e->getMessage());
    //         Log::info($e->getTraceAsString());
    //     }
    // }

    /* 
    *  Calculate bonus base on  revenue of agency
    *  @userId array
    *  @maxLevel max level of agency can receive bonus
    */
    public static function calculateRevenueByLevel($userId = array(), $weekYear, $level = 1, $maxLevel, &$bonus, $rootId)
    {
        if($level == 1) {
            $listF1Agency = DB::table('user_datas')->whereIn('refererId', $userId)
                            ->where('packageId', '>', 0)
                            ->pluck('userId')
                            ->toArray();

            //calculate revenue
            $revenue = DB::table('tickets')->whereIn('user_id', $listF1Agency)
                    ->where('week_year','=', $weekYear)
                    ->sum('quantity');
            $bonus += $revenue * config('carcoin.ticket_level_1');

            WeekTicketsHistory::where('week_year', $weekYear)
                        ->where('user_id', $rootId)
                        ->update(['level_' . $level => $revenue *  config('carcoin.ticket_level_1')]);

            $listF1 = $listF1Agency;
        } else {
            //get all F1
            $listF1 = DB::table('user_datas')->whereIn('refererId', $userId)
                            ->where('packageId', '>', 0)
                            ->pluck('userId')
                            ->toArray();

            //calculate revenue
            $revenue = DB::table('tickets')->whereIn('user_id', $listF1)->where('week_year','=', $weekYear)->sum('quantity');
            $commission = 0;
            if($level == 2) $commission = config('carcoin.ticket_level_2');
            if($level == 3) $commission = config('carcoin.ticket_level_3');
            if($level == 4) $commission = config('carcoin.ticket_level_4');
            if($level == 5) $commission = config('carcoin.ticket_level_5');

            $bonus += $revenue * $commission;
        
            WeekTicketsHistory::where('week_year', $weekYear)
                        ->where('user_id', $rootId)
                        ->update(['level_' . $level => $revenue * $commission]);
        }

        if($level < $maxLevel)
            self::calculateRevenueByLevel($listF1, $weekYear, $level + 1, $maxLevel, $bonus, $rootId);
    }

    /* 
    *  Calculate bonus base on  award
    *  @sponsorId int
    *  @valueAward double value of award
    */
    public static function calculateAwardReturn($userId = array(), $weekYear, $level = 1, $maxLevel, &$bonus, $rootId)
    {
        if($level == 1) {
            //calculate revenue
            $listF1Agency = DB::table('user_datas')->whereIn('refererId', $userId)
                            ->where('packageId', '>', 0)
                            ->pluck('userId')
                            ->toArray();

            //calculate revenue
            $value = DB::table('awards')->whereIn('user_id', $listF1Agency)
                    ->where('week_year','=', $weekYear)
                    ->sum('value');
            $bonus += $value * config('carcoin.award_agency');

            WeekAwardsHistory::where('week_year', $weekYear)
                        ->where('user_id', $rootId)
                        ->update(['level_' . $level => $value * config('carcoin.award_agency')]);

            $listF1 = $listF1Agency;
        } else {
            //get all F1
            $listF1 = DB::table('user_datas')->whereIn('refererId', $userId)
                            ->where('packageId', '>', 0)
                            ->pluck('userId')
                            ->toArray();
            //calculate revenue
            $value = DB::table('awards')->whereIn('user_id', $listF1)->where('week_year','=', $weekYear)->sum('value');

            $bonus += $value * config('carcoin.award_agency');
        
            WeekAwardsHistory::where('week_year', $weekYear)
                        ->where('user_id', $rootId)
                        ->update(['level_' . $level => $value * config('carcoin.award_agency')]);
        }

        if($level <= $maxLevel)
            self::calculateAwardReturn($listF1, $weekYear, $level + 1, $maxLevel, $bonus, $rootId);
    }

    /* 
    *  Calculate bonus base on  new agency
    *  @userId array
    *  @maxLevel max level of agency can receive bonus
    */
    // public static function calculateBonusOnNewAgency($userId = array(), $weekYear, $level = 1, $maxLevel, &$bonus, $rootId)
    // {
    //     //get all F1
    //     $listF1 = DB::table('users')->whereIn('refererId', $userId)->pluck('id')->toArray();
    //     //calculate revenue
    //     $totalPackage = DB::table('user_packages')->whereIn('userId', $listF1)->where('weekYear','=', $weekYear)->sum('amount_increase');

    //     $commission = 0;
    //     if($level == 1) $commission = self::AGENCY_LEVEL_1;
    //     if($level == 2) $commission = self::AGENCY_LEVEL_2;
    //     if($level == 3) $commission = self::AGENCY_LEVEL_3;
    //     if($level == 4) $commission = self::AGENCY_LEVEL_4;
    //     if($level == 5) $commission = self::AGENCY_LEVEL_5;

    //     $bonus += $totalPackage * $commission;

    //     WeekAgencyHistory::where('week_year', $weekYear)
    //                     ->where('user_id', $rootId)
    //                     ->update(['level_' . $level => $totalPackage * $commission]);

    //     if($level < $maxLevel)
    //         self::calculateBonusOnNewAgency($listF1, $weekYear, $level + 1, $maxLevel, $bonus, $rootId);
    // }
}
