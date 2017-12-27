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
use App\TotalWeekSales;
use App\UserTreePermission;
use App\BonusBinaryInterest;
use App\LoyaltyUser;
use DB;
use Log;
use App\Package;

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

		/* Get current weekYear */
		$weeked = date('W');
		$year = date('Y');
		$weekYear = $year.$weeked;

		if($weeked < 10) $weekYear = $year.'0'.$weeked;
		try {
			$lstUser = User::where('active', '=', 1)->get();
			foreach($lstUser as $user){
				//Get cron status
				//$cronStatus = CronProfitLogs::where('userId', $user->id)->first();
				//if(isset($cronStatus) && $cronStatus->status == 1) continue;

				$userData = $user->userData;
								
				//Get all pack in user_packages
				$packages = UserPackage::where('userId', $user->id)
							->where('withdraw', '<', 1)
							->get();

				if(count($packages)>0)
				{
					//Calculate total week interest for each users
					$weekTotal = TotalWeekSales::where('userId', $user->id)->first();
					$totalInterest = 0;

					//Pakages
					foreach($packages as $pack)
					{
						$bonus = rand(config('carcoin.min_interest')*100, config('carcoin.max_interest')*100)/100;

						$usdAmount = ($pack->amount_increase * $bonus)/100;
						$clpAmount = $usdAmount / ExchangeRate::getCLPUSDRate();



						//Them bang nua interest_weekly

						$userCoin = $user->userCoin;
						$userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $clpAmount);
						$userCoin->save();

						//Get package information
						$packInfo = Package::where('pack_id', $pack->packageId)->first();

						$fieldUsd = [
							'walletType' => Wallet::CLP_WALLET,//usd
							'type' => Wallet::INTEREST_TYPE,//bonus day
							'inOut' => Wallet::IN,
							'userId' => $user->id,
							'amount' => $clpAmount,
							'note' => '$' . $usdAmount . ' of package'. $packInfo->min_price . '-' .$packInfo->max_price
						];

						Wallet::create($fieldUsd);

						$fieldTotal = [
							'userId' => $user->id,
							'total_interest' => $clpAmount,
							'weekYear' => '$' . $usdAmount . ' of package'. $packInfo->min_price . '-' .$packInfo->max_price
						];

						//Calculate total week interest for each users
						$totalInterest += $clpAmount;
						

						if($pack->packageId > 1)
						{
							$bonusPack = $pack->amount_increase * $packInfo->bonus;

							$clpAmount = $bonusPack / ExchangeRate::getCLPUSDRate();

							$userCoin = $user->userCoin;
							$userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $clpAmount);
							$userCoin->save();

							//Calculate total week interest for each users
							$totalInterest += $clpAmount;

							//Get package information
							$packInfo = Package::where('pack_id', $pack->packageId)->first();

							$fieldBonus = [
								'walletType' => Wallet::CLP_WALLET,//usd
								'type' => Wallet::INTEREST_TYPE,//bonus day
								'inOut' => Wallet::IN,
								'userId' => $user->id,
								'amount' => $clpAmount,
								'note' => '$' . $bonusPack . ' of package'. $packInfo->min_price . '-' .$packInfo->max_price.' - Daily Interest Bonus'
							];

							Wallet::create($fieldBonus);
						}
					}

					$weekTotal->total_interest = $totalInterest;//tinh tong->
					$weekTotal->weekYear = $weekYear;
					$weekTotal->save();

					//Update cron status from 0 => 1
					//$cronStatus->status = 1;
					//$cronStatus->save();
				}



				//update bonus binary interest
				
				$volInfo = self::_calLeftRightVolume($user->id);
				$binaryInterest=BonusBinaryInterest::where('userId','=',$user->id)->first();

				if($binaryInterest)
				{

					$binaryInterest->leftNew+=$volInfo['totalLeft'];
					$binaryInterest->rightNew+=$volInfo['totalRight'];
					$binaryInterest->save();
				}
				else
				{

					$fields=[
						'userId'=>$user->id,
						'leftNew'=>$volInfo['totalLeft'],
						'rightNew'=>$volInfo['totalRight'],
						'leftOpen'=>0,
						'rightOpen'=>0,
						'bonus'=>0,
						'weekYear'=>$weekYear
					];
					BonusBinaryInterest::create($fields);
				}
				//echo $user->id;
				//echo'<br/>';


			}


			//Update status from 1 => 0 after run all user
			DB::table('cron_profit_day_logs')->update(['status' => 0]);

		} catch(\Exception $e) {
			Log::error('Running bonusDayCron has error: ' . date('Y-m-d') .$e->getMessage());
			Log::info($e->getTraceAsString());
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

		//$firstWeek = $weeked -1; //if run cronjob in 00:00:00 sunday
		$firstWeek = $weeked;
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

			//Caculate level to get binary commision
			$level = 0;
			$percentBonus = 0;
			$packageId = $binary->userData->packageId;

			if($leftOver >= config('carcoin.bi_sale_cond_lv_1') && 
				$rightOver >= config('carcoin.bi_sale_cond_lv_1') && 
				$packageId >= 1 )
			{
				$level = config('carcoin.bi_sale_cond_lv_1');
				$percentBonus = config('carcoin.bi_lv_1_bonus');
			}

			if($leftOver >= config('carcoin.bi_sale_cond_lv_2') && 
				$rightOver >= config('carcoin.bi_sale_cond_lv_2') && 
				$packageId >= 2)
			{
				$level = config('carcoin.bi_sale_cond_lv_2');
				$percentBonus = config('carcoin.bi_lv_2_bonus');
			}

			if($leftOver >= config('carcoin.bi_sale_cond_lv_3') && 
				$rightOver >= config('carcoin.bi_sale_cond_lv_3') && 
				$packageId >= 3)
			{
				$level = config('carcoin.bi_sale_cond_lv_3');
				$percentBonus = config('carcoin.bi_lv_3_bonus');
			}

			if($leftOver > config('carcoin.bi_sale_cond_lv_4') && 
				$rightOver > config('carcoin.bi_sale_cond_lv_4') && 
				$packageId == 4)
			{
				$level = config('carcoin.bi_sale_cond_lv_4');
				$percentBonus = config('carcoin.bi_lv_4_bonus');
			}

			$leftOpen = $leftOver - $level;
			$rightOpen = $rightOver - $level;


			$bonus = $level * $percentBonus;
			

			$binary->settled = $level;

			//Bonus canot over maxout $30,000
			if($bonus > config('carcoin.bonus_maxout')) $bonus = config('carcoin.bonus_maxout');

			$binary->bonus = $bonus;
			$binary->save();

			if($bonus > 0){
				$clpAmount = $bonus * config('carcoin.clp_bonus_pay') / ExchangeRate::getCLPUSDRate();
				$reinvestAmount = $bonus * config('carcoin.reinvest_bonus_pay') / ExchangeRate::getCLPUSDRate();

				$userCoin = $binary->userCoin;
				$userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $clpAmount);
				$userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
				$userCoin->save();

				$fieldUsd = [
					'walletType' => Wallet::CLP_WALLET,//usd
					'type' =>  Wallet::BINARY_TYPE,//bonus week
					'inOut' => Wallet::IN,
					'userId' => $binary->userId,
					'amount' => $clpAmount,
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

				//update leftNew
				$week->leftNew=0;//reset leftNew
				$week->rightNew=0;//reset rightNew
				//update RightNew

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
	public static function bonusMatchingWeekCron()//infinity interest
	{
		set_time_limit(0);
		/* Get previous weekYear */
		/* =======BEGIN ===== */
		$weeked = date('W');
		$year = date('Y');
		$weekYear = $year.$weeked;

		if($weeked < 10) $weekYear = $year.'0'.$weeked;

		//$firstWeek = $weeked - 1;
		$firstWeek = $weeked;
		$firstYear = $year;
		$firstWeekYear = $firstYear.$firstWeek;

		if($firstWeek == 0){
			$firstWeek = 52;
			$firstYear = $year - 1;
			$firstWeekYear = $firstYear.$firstWeek;
		}

		if($firstWeek < 10) $firstWeekYear = $firstYear.'0'.$firstWeek;

		/* =======END ===== */

		$listBinaryInterest = BonusBinaryInterest::where('weekYear', '=', $firstWeekYear)->get();
		foreach($listBinaryInterest as $binary)
		{
			//Get cron status
			//$cronStatus = CronMatchingLogs::where('userId', $binary->userId)->first();
			//if(isset($cronStatus) && $cronStatus->status == 1) continue;

			//$volInfo = self::_calLeftRightVolume($binary->userId);

			$leftOver = $binary->leftNew + $binary->leftOpen;
			$rightOver = $binary->rightNew + $binary->rightOpen;
			
			//Caculate level to get binary commision
			$level = 0;
			$percentBonus = 0;
			$packageId = $binary->userData->packageId;

			if($leftOver >= config('carcoin.bi_inter_cond_lv_1') && 
				$rightOver >= config('carcoin.bi_inter_cond_lv_1') && 
				$packageId >= 1 )
			{
				$level = config('carcoin.bi_inter_cond_lv_1');
				$percentBonus = config('carcoin.bi_lv_1_inter_bonus');
			}

			if($leftOver >= config('carcoin.bi_inter_cond_lv_2') && 
				$rightOver >= config('carcoin.bi_inter_cond_lv_2') && 
				$packageId >= 2)
			{
				$level = config('carcoin.bi_inter_cond_lv_2');
				$percentBonus = config('carcoin.bi_lv_2_inter_bonus');
			}

			if($leftOver >= config('carcoin.bi_inter_cond_lv_3') && 
				$rightOver >= config('carcoin.bi_inter_cond_lv_3') && 
				$packageId >= 3)
			{
				$level = config('carcoin.bi_inter_cond_lv_3');
				$percentBonus = config('carcoin.bi_lv_3_inter_bonus');
			}

			if($leftOver > config('carcoin.bi_inter_cond_lv_4') && 
				$rightOver > config('carcoin.bi_inter_cond_lv_4') && 
				$packageId == 4)
			{
				$level = config('carcoin.bi_inter_cond_lv_4');
				$percentBonus = config('carcoin.bi_lv_4_inter_bonus');
			}

			$leftOpen = $leftOver - $level;
			$rightOpen = $rightOver - $level;

			$bonus = $level * $percentBonus;
			if($bonus > 0)
			{
				$clpAmount = $bonus * config('carcoin.clp_bonus_pay') / ExchangeRate::getCLPUSDRate();
				$reinvestAmount = $bonus * config('carcoin.reinvest_bonus_pay') / ExchangeRate::getCLPUSDRate();

				$userCoin = $binary->userCoin;
				$userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $clpAmount);
				$userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
				$userCoin->save();

				$fieldUsd = [
					'walletType' => Wallet::CLP_WALLET,//
					'type' =>  Wallet::MATCHING_TYPE,//bonus week
					'inOut' => Wallet::IN,
					'userId' => $binary->userId,
					'amount' => $clpAmount,
				];

				Wallet::create($fieldUsd);

				$fieldInvest = [
					'walletType' => Wallet::REINVEST_WALLET,//reinvest
					'type' => Wallet::MATCHING_TYPE,//bonus week
					'inOut' => Wallet::IN,
					'userId' => $binary->userId,
					'amount' => $reinvestAmount,
				];

				Wallet::create($fieldInvest);
			}


			$weeked = date('W');
			$year = date('Y');
			$weekYear = $year.$weeked;
			if($weeked < 10) $weekYear = $year.'0'.$weeked;
			$week = BonusBinaryInterest::where('userId', '=', $binary->userId)->where('weekYear', '=', $weekYear)->first();
			if(isset($week) && $week->id > 0) {
				$week->leftOpen = $leftOpen;
				$week->rightOpen = $rightOpen;

				//update leftNew
				$week->leftNew=0;//reset leftNew
				$week->rightNew=0;//reset rightNew
				$week->bonus=$bonus;
				//update RightNew

				$week->save();
			} else {
				// No => create new
				$field = [
					'userId' => $binary->userId,
					'leftNew' => 0,
					'rightNew' => 0,
					'bonus'=>0,
					'leftOpen' => $leftOpen,
					'rightOpen' => $rightOpen,
					'weekYear' => $weekYear,
				];

				BonusBinaryInterest::create($field);
			}


			//Update cron status from 0 => 1
			//$cronStatus->status = 1;
			//$cronStatus->save();
		}

		//Update status from 1 => 0 after run all user
		DB::table('cron_matching_logs')->update(['status' => 0]);
	}

	private static function _calLeftRightVolume($userId)//
	{
		$userTree = UserTreePermission::where('userId','=',$userId)->first();
		$totalLeftVol = $totalRightVol = 0;
		if($userTree)
		{
			$memberLeft = $userTree->binary_left;
			$memberRight = $userTree->binary_right;

			$listMemberLeft = explode(',', $memberLeft);
			$listMemberRight = explode(',', $memberRight);

			$chunkLeft = array_chunk($listMemberLeft, 50);
			foreach($chunkLeft as $chunk)
			{
				$weekSale = TotalWeekSales::whereIn('userId', $chunk)
										->selectRaw('sum(total_interest) as totalVol')
										->get()
										->first();

				$totalLeftVol += $weekSale->totalVol;
			}

			$chunkRight = array_chunk($listMemberRight, 50);
			foreach($chunkRight as $chunk)
			{
				$weekSale = TotalWeekSales::whereIn('userId', $chunk)
										->selectRaw('sum(total_interest) as totalVol')
										->get()
										->first();

				$totalRightVol += $weekSale->totalVol;
			}
		}
		

		return ['totalLeft' => $totalLeftVol, 'totalRight' => $totalRightVol];
	}


	public static function globalBonus()
	{
		set_time_limit(0);

		$lstUser = User::where('active', '=', 1)->get();
		foreach($lstUser as $user){
			$userData = $user->userData;
			$leftOver=floatval($userData->totalSaleLeft);
			$rightOver=floatval($userData->totalSaleRight);
			$packageId=$userData->packageId;
			$rank=0;
			$level = 0;
			$percentBonus = 0;
			if($leftOver >= config('carcoin.loyalty_upgrate_silver') && 
				$rightOver >= config('carcoin.loyalty_upgrate_silver') && 
				$packageId >= 1 )
			{
				$level = config('carcoin.loyalty_upgrate_silver');
				$percentBonus = config('carcoin.sapphire_leadership_bonus');
				$rank=1;
			}

			if($leftOver >= config('carcoin.loyalty_upgrate_gold') && 
				$rightOver >= config('carcoin.loyalty_upgrate_gold') && 
				$packageId >= 2)
			{
				$level = config('carcoin.loyalty_upgrate_gold');
				$percentBonus = config('carcoin.emerald_leadership_bonus');
				$rank=2;
			}

			if($leftOver >= config('carcoin.loyalty_upgrate_pear') && 
				$rightOver >= config('carcoin.loyalty_upgrate_pear') && 
				$packageId >= 3)
			{
				$level = config('carcoin.loyalty_upgrate_pear');
				$percentBonus = config('carcoin.diamond_leadership_bonus');
				$rank=3;
			}

			if($leftOver > config('carcoin.loyalty_upgrate_emerald') && 
				$rightOver > config('carcoin.loyalty_upgrate_emerald') && 
				$packageId == 4)
			{
				$level = config('carcoin.loyalty_upgrate_emerald');
				$percentBonus = config('carcoin.bluediamond_leadership_bonus');
				$rank=4;
			}

			if($leftOver > config('carcoin.loyalty_upgrate_diamond') && 
				$rightOver > config('carcoin.loyalty_upgrate_diamond') && 
				$packageId == 4)
			{
				$level = config('carcoin.loyalty_upgrate_diamond');
				$percentBonus = config('carcoin.blackdiamond_leadership_bonus');
				$rank=5;
			}
			$bonus = $level * $percentBonus;
			if($bonus>0)
			{
				$clpAmount = $bonus * config('carcoin.clp_bonus_pay') / ExchangeRate::getCLPUSDRate();
				$reinvestAmount = $bonus * config('carcoin.reinvest_bonus_pay') / ExchangeRate::getCLPUSDRate();

				$userCoin = $user->userCoin;
				$userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $clpAmount);
				$userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
				$userCoin->save();

				//update loyalty
				$userLoyalty = LoyaltyUser::where('userId', $user->id)->first();
				if($userLoyalty)
				{
					$userLoyalty->isSilver=0;
					$userLoyalty->isGold=0;
					$userLoyalty->isPear=0;
					$userLoyalty->isEmerald=0;
					$userLoyalty->isDiamond=0;
					if($rank==1)
					{
						$userLoyalty->isSilver=1;
					}
					if($rank==2){
						$userLoyalty->isGold=1;
					}
					if($rank==3){
						$userLoyalty->isPear=1;
					}
					if($rank==4){
						$userLoyalty->isEmerald=1;
					}
					if($rank==5){
						$userLoyalty->isDiamond=1;
					}

					$userLoyalty->save();
				}
				//

				//update rank
				$userData->loyaltyId=$rank;
				$userData->save();

				$fieldUsd = [
					'walletType' => Wallet::CLP_WALLET,//usd
					'type' =>  Wallet::GLOBAL_BONUS,//global bonus
					'inOut' => Wallet::IN,
					'userId' => $user->id,
					'amount' => $clpAmount,
				];

				Wallet::create($fieldUsd);

				$fieldInvest = [
					'walletType' => Wallet::REINVEST_WALLET,//reinvest
					'type' => Wallet::GLOBAL_BONUS,//global bonus
					'inOut' => Wallet::IN,
					'userId' => $user->id,
					'amount' => $reinvestAmount,
				];

				Wallet::create($fieldInvest);
			}
		}
	}

	/**
	* This cronjob function will run every 00:01 first day of month to caculate and return bonus to user's wallet 
	*/
	public static function bonusLeadershipMonthCron()
	{
		set_time_limit(0);
		//
		$firstDayPreviousMonth = new \DateTime('FIRST DAY OF PREVIOUS MONTH');
		$firstDayThisMonth = new \DateTime('FIRST DAY OF THIS MONTH');
		$totalCompanyIncome = 0;
		
		$buyPack = DB::table('user_packages')
				->select(DB::raw('SUM(amount_increase) as sumamount'))
				->where('created_at', '>=', $firstDayPreviousMonth->format('Y-m-d 00:00:00')) 
				->where('created_at', '<', $firstDayThisMonth->format('Y-m-d H:i:s')) //use updated_at because of private sale issue
				->get();

		$totalCompanyIncome =isset($buyPack[0]->sumamount)?$buyPack[0]->sumamount:0;

		//Number of Sapphire
		$numberOfSapphire = DB::table('user_datas')
				->select(DB::raw('count(userId) as number_of_sapphire'))
				->where('loyaltyId', 1)
				->where('status', 1)
				->where('packageId', '>', 0)
				->get();

		//Number of Emerald
		$numberOfEmerald = DB::table('user_datas')
				->select(DB::raw('count(userId) as number_of_emerald'))
				->where('loyaltyId', 2)
				->where('status', 1)
				->where('packageId', '>', 0)
				->get();

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

		$sapphireBonus = config('carcoin.sapphire_leadership_bonus');
		$emeraldBonus = config('carcoin.emerald_leadership_bonus');
		$diamondBonus = config('carcoin.diamond_leadership_bonus');
		$blueDiamondBonus = config('carcoin.bluediamond_leadership_bonus');
		$blackDiamondBonus = config('carcoin.blackdiamond_leadership_bonus');

		$bonusSapphire = $totalCompanyIncome * $sapphireBonus / 
						($numberOfSapphire + $numberOfEmerald + $numberOfDiamond + $numberOfBlueDiamond + $numberOfBlackDiamond);

		$bonusEmerald = $totalCompanyIncome * $emeraldBonus / 
						($bonusEmerald + $numberOfDiamond + $numberOfBlueDiamond + $numberOfBlackDiamond);

		$bonusDiamond = $totalCompanyIncome * $diamondBonus / 
						($numberOfDiamond + $numberOfBlueDiamond + $numberOfBlackDiamond);

		$bonusBlueDiamond = $totalCompanyIncome * $blueDiamondBonus / 
						($numberOfBlueDiamond + $numberOfBlackDiamond);

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

			if($user->loyaltyId == 1)
				$bonus = $bonusSapphire;

			if($user->loyaltyId == 2)
				$bonus = $bonusEmerald;

			if($user->loyaltyId == 3)
				$bonus = $bonusDiamond;

			if($user->loyaltyId == 4)
				$bonus = $bonusBlueDiamond;

			if($user->loyaltyId == 3)
				$bonus = $bonusBlackDiamond;

			if($bonus > 0)
			{
				$clpAmount = $bonus * config('carcoin.clp_bonus_pay') / ExchangeRate::getCLPUSDRate();
				$reinvestAmount = $bonus * config('carcoin.reinvest_bonus_pay') / ExchangeRate::getCLPUSDRate();

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
