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
use DB;

/**
 * Description of UpdateStatusBTCTransaction
 *
 * @author giangdt
 */
class Bonus
{
	
	/**
	* This cronjob function will every days to caculate and return interest to user's wallet 
	*/
	public static function bonusDayCron(){
		set_time_limit(0);
		try {
			$lstUser = User::where('active', '=', 1)->get();
			foreach($lstUser as $user){
				//Get cron status
				$cronStatus = CronProfitLogs::where('userId', $user->id)->first();
				if(isset($cronStatus) && $cronStatus->status == 1) continue;

				$userData = $user->userData;
				//Get all pack in user_packages
				$package = UserPackage::where('userId', $user->id)
							->where('withdraw', '<', 1)
							->groupBy(['userId'])
							->selectRaw('sum(amount_increase) as totalValue')
							->get()
							->first();
				if($package) 
				{
					$bonus = isset($userData->package->bonus) ? $userData->package->bonus : 0;

					$usdAmount = $package->totalValue * $bonus;

					$userCoin = $user->userCoin;
					$userCoin->usdAmount = ($userCoin->usdAmount + $usdAmount);
					$userCoin->save();

					$fieldUsd = [
						'walletType' => Wallet::USD_WALLET,//usd
						'type' => Wallet::INTEREST_TYPE,//bonus day
						'inOut' => Wallet::IN,
						'userId' => $user->id,
						'amount' => $usdAmount
					];

					Wallet::create($fieldUsd);

					//Update cron status from 0 => 1
					$cronStatus->status = 1;
					$cronStatus->save();
				}
			}

			//Update status from 1 => 0 after run all user
			DB::table('cron_profit_day_logs')->update(['status' => 0]);

		} catch(\Exception $e) {
			\Log::error('Running bonusDayCron has error: ' . date('Y-m-d') .$e->getMessage());
			//throw new \Exception("Running bonusDayCron has error");
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
				if (User::checkBinaryCount($binary->userId, 5)) {
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
					} elseif ($userPackage->pack_id == 7) {
						$bonus = $settled * config('cryptolanding.binary_bonus_7_pay');
					} elseif ($userPackage->pack_id == 8) {
						$bonus = $settled * config('cryptolanding.binary_bonus_8_pay');
					}
				}
			}

			$binary->settled = $settled;

			//Bonus canot over maxout $35,000
			if($bonus > config('cryptolanding.bonus_maxout')) $bonus = config('cryptolanding.bonus_maxout');

			$binary->bonus = $bonus;
			$binary->save();

			if($bonus > 0){
				$usdAmount = $bonus * config('cryptolanding.clp_bonus_pay');
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

	/**
	* This cronjob function will run every 00:01 Monday of week to caculate and return bonus to user's wallet 
	*/
	public static function bonusMatchingWeekCron()
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

		//Get all user in loyalty table with loyaltyId > 0
		$listLoyaltyUser = UserData::where('loyaltyId', '>', 0)->where('status', 1)->get();
		foreach($listLoyaltyUser as $user)
		{
			//Get cron status
			$cronStatus = CronMatchingLogs::where('userId', $binary->userId)->first();
			if(isset($cronStatus) && $cronStatus->status == 1) continue;

			$totalGenealogyBonus = 0;
			self::calTotalBonus(&$totalGenealogyBonus, $firstWeekYear, $user->userId, $user->loyaltyId, 1);
			$bonus = $totalGenealogyBonus * config('cryptolanding.binary_matching_bonus');

			if($bonus > 0)
			{
				$clpAmount = $bonus * config('cryptolanding.clp_bonus_pay') / ExchangeRate::getCLPUSDRate();
				$reinvestAmount = $bonus * config('cryptolanding.reinvest_bonus_pay') / ExchangeRate::getCLPUSDRate();

				$userCoin = $binary->userCoin;
				$userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $clpAmount);
				$userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
				$userCoin->save();

				$fieldUsd = [
					'walletType' => Wallet::CLP_WALLET,//
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

			//Update cron status from 0 => 1
			$cronStatus->status = 1;
			$cronStatus->save();
		}

		//Update status from 1 => 0 after run all user
		DB::table('cron_matching_logs')->update(['status' => 0]);
	}

	public static function calTotalBonus(&$totalBonus, $firstWeekYear, $referralId, $loyaltyId, $deepLevel = 1)
	{
		//Cal total member F1
		$f1Users = UserData::where('refererId', $referralId)->get();
		//Total binany bonus F1
		foreach($f1Users as $userId) {
			$bonusBinary = BonusBinary::where('weekYear', '=', $firstWeekYear)->where('userId', $userId)->get();
			$totalBonus += $bonusBinary->bonus;
		}

		$deepLevel++;
		//IsSilver
		if($loyaltyId == 1 && $deepLevel <= 2) {
			foreach($f1Users as $userId) {
				self::calTotalBonus($totalBonus, $userId, $loyaltyId, $deepLevel);
			}
		}

		//IsGold
		if($loyaltyId == 2 && $deepLevel <= 4){
			foreach($f1Users as $userId) {
				self::calTotalBonus($totalBonus, $userId, $loyaltyId, $deepLevel);
			}
		}

		//IsPear
		if($loyaltyId == 3 && $deepLevel <= 6){
			foreach($f1Users as $userId) {
				self::calTotalBonus($totalBonus, $userId, $loyaltyId, $deepLevel);
			}
		}

		//IsEmerald
		if($loyaltyId == 4 && $deepLevel <= 8){
			foreach($f1Users as $userId) {
				self::calTotalBonus($totalBonus, $userId, $loyaltyId, $deepLevel);
			}
		}

		//IsDiamond
		if($loyaltyId == 5 && $deepLevel <= 10) {
			foreach($f1Users as $userId) {
				self::calTotalBonus($totalBonus, $userId, $loyaltyId, $deepLevel);
			}
		}
	}

	/**
	* This cronjob function will run every 00:01 first day of month to caculate and return bonus to user's wallet 
	*/
	public static function bonusLeadershipMonthCron()
	{
		set_time_limit(0);

		$firstDayPreviousMonth;
		$firstDayThisMonth;

		$totalCompanyIncome = 0;
		
		$buyPack = DB::table('user_packages')
				->select(DB::raw('SUM(amount_increase) as sumamount'))
				->where('created_at', '>=', $firstDayPreviousMonth) 
				->where('created_at', '<', $firstDayThisMonth) //use updated_at because of private sale issue
				->get();

		$totalCompanyIncome = $buyPack->sumamount;

		

		//Number of Diamond
		$numberOfDiamond = DB::table('user_datas')
				->select(DB::raw('count(userId) as number_of_diamond'))
				->where('loyaltyId', 3)
				->where('status', 1)
				->where('packageId', '>', 0)
				->get();

		//Number of BlueDiamond
		$numberOfBlueDiamond = DB::table('user_datas')
				->select(DB::raw('count(userId) as number_of_bluediamond'))
				->where('loyaltyId', 3)
				->where('status', 1)
				->where('packageId', '>', 0)
				->get();

		//Number of BlackDiamond
		$numberOfBlackDiamond = DB::table('user_datas')
				->select(DB::raw('count(userId) as number_of_blackdiamond'))
				->where('loyaltyId', 3)
				->where('status', 1)
				->where('packageId', '>', 0)
				->get();

		$diamondBonus = config('cryptolanding.diamond_leadership_bonus');
		$blueDiamondBonus = config('cryptolanding.bluediamond_leadership_bonus');
		$blackDiamondBonus = config('cryptolanding.blackdiamond_leadership_bonus');

		$bonusDiamond = $totalCompanyIncome * $diamondBonus / ($numberOfDiamond + $numberOfBlueDiamond + $numberOfBlackDiamond);

		$bonusBlueDiamond = $totalCompanyIncome * $blueDiamondBonus / ($numberOfBlueDiamond + $numberOfBlackDiamond);

		$bonusBlackDiamond = $totalCompanyIncome * $blackDiamondBonus / $numberOfBlackDiamond;

		//Get all user in loyalty table with loyaltyId > 0
		$listLoyaltyUser = UserData::where('loyaltyId', '>', 2)
							->where('status', 1)
							->where('packageId', '>', 0)
							->get();

		foreach($listLoyaltyUser as $user)
		{
			//Get cron status
			$cronStatus = CronLeadershipLogs::where('userId', $binary->userId)->first();
			if(isset($cronStatus) && $cronStatus->status == 1) continue;

			if($user->loyaltyId == 3)
				$bonus = $bonusDiamond;

			if($user->loyaltyId == 4)
				$bonus = $bonusBlueDiamond;

			if($user->loyaltyId == 3)
				$bonus = $bonusBlackDiamond;

			if($bonus > 0)
			{
				$clpAmount = $bonus * config('cryptolanding.clp_bonus_pay') / ExchangeRate::getCLPUSDRate();
				$reinvestAmount = $bonus * config('cryptolanding.reinvest_bonus_pay') / ExchangeRate::getCLPUSDRate();

				$userCoin = $binary->userCoin;
				$userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $clpAmount);
				$userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
				$userCoin->save();

				$fieldUsd = [
					'walletType' => Wallet::CLP_WALLET,//
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

			//Update cron status from 0 => 1
			$cronStatus->status = 1;
			$cronStatus->save();
		}

		//Update status from 1 => 0 after run all user
		DB::table('cron_leadership_logs')->update(['status' => 0]);
	}
}
