<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswords;
use Auth;
use DB;

class User extends Authenticatable
{
	use Notifiable, HasRoles;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'status', 'active', 'refererId', 'firstname', 'lastname', 'phone', 'is2fa', 'google2fa_secret', 'password', 'address', 'address2', 'city', 'state', 'postal_code', 'name_country','country', 'birthday', 'passport', 'uid','approve','photo_verification','password'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function posts()
	{
		return $this->hasMany(Post::class);
	}
	public function userData() {
		return $this->hasOne(UserData::class, 'userId', 'id');
	}
	public function userCoin() {
		return $this->hasOne(UserCoin::class, 'userId', 'id');
	}
	public function userTreePermission() {
		return $this->hasOne(UserTreePermission::class, 'userId', 'id');
	}
	public function fastStart() {
		//return $this->belongsTo(BonusFastStart::class);
		return $this->hasOne(BonusFastStart::class, 'userId', 'id');
	}
	public function userLoyaty() {
		return $this->hasOne(LoyaltyUser::class, 'userId', 'id');
	}
	public function userLoyatys() {
		return $this->hasMany(LoyaltyUser::class, 'refererId', 'id');
	}

	public static function getUid(){
		$uid = mt_rand(1001, 999999);
		if(User::where('uid', $uid)->count()){
			$uid = self::getUid();
		}
		return $uid;
	}


    public static function userHasRole( $user_id )
    {
       return DB::table('model_has_roles')->where('model_id', '=', $user_id)->get();
    }

	/**
	* Calculate fast start bonus
	*/
	public static function investBonus($userId = 0, $refererId = 0, $packageId = 0, $usdCoinAmount = 0)
	{
		if($refererId > 0)
		{
			$packageBonus = 0;
			$userData = UserData::find($refererId);
			
			if(isset($userData) && $userData->packageId > 0)
			{
				
				if($userData->packageId == 1)
					$packageBonus = $usdCoinAmount * config('carcoin.bonus_range_1_pay');

				if($userData->packageId == 2)
					$packageBonus = $usdCoinAmount * config('carcoin.bonus_range_2_pay');

				if($userData->packageId ==3)
					$packageBonus = $usdCoinAmount * config('carcoin.bonus_range_3_pay');

				if($userData->packageId == 4)
					$packageBonus = $usdCoinAmount * config('carcoin.bonus_range_4_pay');

				$userData->totalBonus = $userData->totalBonus + $packageBonus;
				$userData->save();

				


				$userCoin = $userData->userCoin;
				if($userCoin && $packageBonus > 0)
				{
					//Get info of user
					$user = Auth::user();

					$clpAmount = ($packageBonus * config('carcoin.clp_bonus_pay') / ExchangeRate::getCLPUSDRate());
					$reinvestAmount = ($packageBonus * config('carcoin.reinvest_bonus_pay') / ExchangeRate::getCLPUSDRate());
					$userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $clpAmount);
					$userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
					$userCoin->save();
					
					$fieldUsd = [
						'walletType' => Wallet::CLP_WALLET,
						'type' => Wallet::FAST_START_TYPE,
						'inOut' => Wallet::IN,
						'userId' => $userData->userId,
						'amount' => $clpAmount,
						'note'   => $user->name . ' bought package',
					];
					
					Wallet::create($fieldUsd);

					$fieldInvest = [
						'walletType' => Wallet::REINVEST_WALLET,//reinvest
						'type' => Wallet::FAST_START_TYPE,
						'inOut' => Wallet::IN,
						'userId' => $userData->userId,
						'amount' => $reinvestAmount,
						'note'   => $user->name . ' bought package'
					];
					Wallet::create($fieldInvest);
				}

				if($packageBonus > 0)
					self::investBonusFastStart($refererId, $userId, $packageId, $packageBonus);
			}
			
			self::bonusBinaryThisWeek($userId);
		}
	}

	/**
	*   Insert log for Fast Start Bonus
	*/
	public static function investBonusFastStart($userId = 0, $partnerId = 0, $packageId = 0, $amount = 0)
	{
		if($userId > 0) {
			$fields = [
				'userId'     => $userId,
				'partnerId'     => $partnerId,
				'generation'     => 1,
				'packageId'     => $packageId,
				'amount'     => $amount,
			];

			BonusFastStart::create($fields);
		}
	}


	/**
	* Loop to root to re-assign lastLeft, lastRight user in tree and caculate binary sales for each node. 
	*/
	public static function bonusBinary($userId = 0, $partnerId = 0, $packageId = 0, $binaryUserId = 0, $legpos, $isUpgrade = false, $continue=true)
	{
		$userRoot = UserData::find($userId);
		$user = UserData::find($binaryUserId);
		$usdCoinAmount = 0;

		if($user)
		{
			if($isUpgrade == true) 
			{
				$userPackage = UserPackage::where('userId', $userId)
								->where('packageId', $packageId)
								->orderBy('id', 'desc')
								->first();
				$usdCoinAmount = isset($userPackage->amount_increase) ? $userPackage->amount_increase : 0;
				// If $userRoot already in binary tree
				if ($legpos == 1){
					//Total sale on left
					$user->totalSaleLeft = $user->totalSaleLeft + $usdCoinAmount;
					
					$isInGenealogy = self::updateUserGenealogyLeftRight($binaryUserId, $userId, $legpos);
					if($isInGenealogy)
						$user->saleGenLeft = $user->saleGenLeft + $usdCoinAmount;
				}else{
					//Total sale on right
					$user->totalSaleRight = $user->totalSaleRight + $usdCoinAmount;

					$isInGenealogy = self::updateUserGenealogyLeftRight($binaryUserId, $userId, $legpos);
					if($isInGenealogy)
						$user->saleGenRight = $user->saleGenRight + $usdCoinAmount;
				}
			} 
			elseif($userRoot->totalMembers == 0) 
			{
				
				$userPackage = UserPackage::where('userId', $userId)
								->sum('amount_increase');
				$usdCoinAmount = $userPackage;			

				// If $userRoot don't have own tree
				if ($legpos == 1){
					//Update genelogy on left
					$isInGenealogy = self::updateUserGenealogyLeftRight($binaryUserId, $userId, $legpos);

					//Total sale on left
					if($isInGenealogy)
						$user->saleGenLeft = $user->saleGenLeft + $usdCoinAmount;

					if($continue)
						$user->lastUserIdLeft = $userRoot->lastUserIdLeft;

					$user->leftMembers = $user->leftMembers + 1;
					$user->totalSaleLeft = $user->totalSaleLeft + $usdCoinAmount;
				}else{
					//Update genelogy on right
					$isInGenealogy = self::updateUserGenealogyLeftRight($binaryUserId, $userId, $legpos);
					//Total sale on right
					if($isInGenealogy)
						$user->saleGenRight = $user->saleGenRight + $usdCoinAmount;
					if($continue) 
						$user->lastUserIdRight = $userRoot->lastUserIdRight;

					$user->rightMembers = $user->rightMembers + 1;
					$user->totalSaleRight = $user->totalSaleRight + $usdCoinAmount;
				}

				$user->totalMembers = $user->totalMembers + 1;
				
			}

			$user->save();

			//Update binary list user
			self::updateUserBinary($binaryUserId, $userId);

			//Update binary left, right list user
			self::updateUserBinaryLeftRight($binaryUserId, $userId, $legpos);

			//Caculate binary bonus for up level of $userRoot in binary tree
			// $binaryUserId = $user->userId
			self::bonusBinaryWeek($binaryUserId, $usdCoinAmount, $legpos);

			$nextLegpos = isset($user->leftRight) ? $user->leftRight : -1;
			
			if($nextLegpos == $userRoot->leftRight && $continue == true) $continue = true;
			else $continue = false;
			
			//convert left, right to 1,2
			$nextLegpos = ($nextLegpos == 'left') ? 1 : 2;
			
			//Caculate loyalty bonus for up level of $userRoot in binary tree
			// $user->userId = $binaryUserId
			if($user->packageId > 0) self::bonusLoyaltyUser($user->userId, $user->refererId, $nextLegpos);
			
			if($user->binaryUserId > 0 && $user->packageId > 0) {
				User::bonusBinary($userId, $partnerId, $packageId, $user->binaryUserId, $nextLegpos, $isUpgrade, $continue);
			}
		}
	}

	public static function bonusBinaryWeek($binaryUserId = 0, $usdCoinAmount = 0, $legpos)
	{
		$weeked = date('W');
		$year = date('Y');
		$weekYear = $year.$weeked;

		if($weeked < 10) $weekYear = $year.'0'.$weeked;

		$week = BonusBinary::where('userId', '=', $binaryUserId)->where('weekYear', '=', $weekYear)->first();

		if($week && $week->id > 0) { //If already have record just update amount increase 
			if($legpos == 1){
				$week->leftNew = $week->leftNew + $usdCoinAmount;
			}else{

				$week->rightNew = $week->rightNew + $usdCoinAmount;
			}
			$week->save();
		} else {
			$fields = [
				'userId'     => $binaryUserId,
				'weeked'     => $weeked,
				'year'     => $year,
				'weekYear'     => $weekYear,
			];

			$fields['leftOpen'] = 0;
			$fields['rightOpen'] = 0;

			if($legpos == 1){
				$fields['leftNew'] = $usdCoinAmount;
				$fields['rightNew'] = 0;
			}else{
				$fields['rightNew'] = $usdCoinAmount;
				$fields['leftNew'] = 0;
			}

			BonusBinary::create($fields);

			$interestFields = [
				'userId'     => $binaryUserId,
				'weekYear'     => $weekYear,
				'leftOpen'	=> 0,
				'rightOpen'	=> 0,
				'leftNew'	=> 0,
				'rightNew'	=> 0
			];
			$bonusBinaryInterest=BonusBinaryInterest::where('userId',$binaryUserId)->where('weekYear',$weekYear)->first();
			if(count($bonusBinaryInterest)==0)
			{
				BonusBinaryInterest::create($interestFields);
			}
		}

		//Caculate temporary binary bonus this week right after have a new user in tree
		self::bonusBinaryThisWeek($binaryUserId);
	}

	/**
	*   Caculate temporary binary bonus this week right after have a new user in tree
	*/
	public static function bonusBinaryThisWeek($userId){
		$weeked = date('W');
		$year = date('Y');
		$weekYear = $year.$weeked;

		if($weeked < 10) $weekYear = $year.'0'.$weeked;

		$binary = BonusBinary::where('weekYear', '=', $weekYear)->where('userId', '=', $userId)->first();
		if($binary){
			$leftOver = $binary->leftOpen + $binary->leftNew;
			$rightOver = $binary->rightOpen + $binary->rightNew;
			
			//Caculate level to get binary commision
			$bonus = 0;
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

			$bonus = $level * $percentBonus;

			if($bonus > config('carcoin.bonus_maxout')) $bonus = config('carcoin.bonus_maxout');

			$binary->settled = $level;
			$binary->bonus_tmp = $bonus;
			$binary->save();
		}

	}


	/**
	*   Calculate loyalty bonus
	*/
	public static function bonusLoyaltyUser($userId, $refererId, $legpos){

		$userData = UserData::where('userId', $userId)->where('packageId', '>', 0)->first();


		//Get sale left, right
		$saleOnLeft = $userData->saleGenLeft;

		$saleOnRight = $userData->saleGenLeft;
		
		//Get UserData
		$userInfo = UserData::where('userId', '=', $userId)->get()->first();

		$rank = self::getRank($saleOnLeft, $saleOnRight, $userInfo->packageId);

		$userInfo->loyaltyId = $rank;
		$userInfo->save();
	}


	/**
	*  Check and Get loyalty type
	*/
	public static function getRank($saleOnLeft, $saleOnRight, $packageId)
	{
		$rank = 0;
		if($saleOnLeft >= config('carcoin.loyalty_upgrate_silver') 
			&& $saleOnRight >= config('carcoin.loyalty_upgrate_silver')
			&& $packageId > 0) {
			$rank = 1;
		}
	
		
		if($saleOnLeft >= config('carcoin.loyalty_upgrate_gold') 
			&& $saleOnRight >= config('carcoin.loyalty_upgrate_gold')
			&& $packageId > 1) {
			$rank = 2;
		}
	
		if($saleOnLeft >= config('carcoin.loyalty_upgrate_pear') 
			&& $saleOnRight >= config('carcoin.loyalty_upgrate_pear')
			&& $packageId > 2) {
			$rank = 3;
		}
	
		if($saleOnLeft >= config('carcoin.loyalty_upgrate_emerald') 
			&& $saleOnRight >= config('carcoin.loyalty_upgrate_emerald')
			&& $packageId > 3) {
			$rank = 4;
		}
	
		if($saleOnLeft >= config('carcoin.loyalty_upgrate_diamond') 
			&& $saleOnRight >= config('carcoin.loyalty_upgrate_diamond')
			&& $packageId > 3) {
			$rank = 5;
		}

		return $rank;
	}


	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswords($token));
	}

	public static function updateUserGenealogy($refererId, $userId = 0){
		if($userId == 0)$userId = $refererId;
		$user = UserTreePermission::find($refererId);
		if($user){
			$user->genealogy = $user->genealogy .','.$userId;
			$user->genealogy_total = $user->genealogy_total + 1;
			$user->save();
		}else{
			UserTreePermission::create(['userId'=>$refererId, 'genealogy' => $userId, 'genealogy_total' => 0]);
			$user = UserTreePermission::find($userId);
		}
		if($user->userData->refererId > 0)
			self::updateUserGenealogy($user->userData->refererId, $userId);
	}

	public static function updateUserBinary($binaryUserId, $userId = 0){
		if($userId == 0)$userId = $binaryUserId;
		$user = UserTreePermission::find($binaryUserId);
		if($user){
			$user->binary = $user->binary .','.$userId;
			$user->binary_total = $user->binary_total + 1;
			$user->save();
		}else{
			UserTreePermission::create(['userId'=>$binaryUserId, 'binary' => $userId, 'binary_total' => 1]);
			$user = UserTreePermission::find($userId);
		}
	}

	public static function updateUserBinaryLeftRight($binaryUserId, $userId, $leftOrRight = '')
	{
		$user = UserTreePermission::find($binaryUserId);
		if($user){
			if($leftOrRight == 1) {
				$user->binary_left = $user->binary_left .',' . $userId;
				$user->save();
			}

			if($leftOrRight == 2) {
				$user->binary_right = $user->binary_right .',' . $userId;
				$user->save();
			}
		}
	}

	/**
	*  Update Genealogy on the left leg
	*
	*/
	public static function updateUserGenealogyLeftRight($binaryUserId, $userId, $leftOrRight = ''){
		$user = UserTreePermission::find($binaryUserId);
		//Get first left binary
		$listGenealogyUser = explode(',', $user->genealogy);
		if( $listGenealogyUser && in_array($userId, $listGenealogyUser) ) {
			if($leftOrRight == 1) {
				$user->genealogy_left = $user->genealogy_left .',' . $userId;
				$user->save();
			}

			if($leftOrRight == 2) {
				$user->genealogy_right = $user->genealogy_right .',' . $userId;
				$user->save();
			}

			return true;
		}

		return false;
	}

}

