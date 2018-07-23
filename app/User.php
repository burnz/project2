<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswords;
use Auth;
use DB;
use App\Http\Controllers\Backend\Report\RepoReportController as Report;
use App\HighestPrice;
use Carbon\Carbon;

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
	public static function investBonus($userId = 0, $refererId = 0, $packageId = 0, $usdCoinAmount = 0, $level = 1)
	{
		if($refererId > 0)
		{
			$packageBonus = 0;
			$userData = UserData::find($refererId);
			
			if(isset($userData) && $userData->packageId > 0 && $level <= 5)
			{
				if($level == 1)
				{//F1
                    $packageBonus = $usdCoinAmount * config('carcoin.agency_level_1');
                }elseif($level == 2 && isset($userData->package) &&  $userData->package->pack_id >= 2)
                {//F2
                    $packageBonus = $usdCoinAmount * config('carcoin.agency_level_2');
                }elseif($level == 3 && isset($userData->package) &&  $userData->package->pack_id >= 3)
                {//F3
                    $packageBonus = $usdCoinAmount * config('carcoin.agency_level_3');
                }elseif($level == 4 && isset($userData->package) &&  $userData->package->pack_id >= 4)
                {//F4
                    $packageBonus = $usdCoinAmount * config('carcoin.agency_level_4');
                }elseif($level == 5 && isset($userData->package) &&  $userData->package->pack_id >= 5)
                {//F5
                    $packageBonus = $usdCoinAmount * config('carcoin.agency_level_5');
                }

				$userCoin = $userData->userCoin;
				if($userCoin && $packageBonus > 0)
				{
					//Get info of user
					$user = Auth::user();

					$carBonus = $packageBonus / HighestPrice::getCarHighestPrice();
					$userCoin->clpCoinAmount = ($userCoin->clpCoinAmount + $carBonus);
					//$userCoin->usdAmount = ($userCoin->usdAmount + $packageBonus);
					$userCoin->save();
					
					$fields = [
						'walletType' => Wallet::CLP_WALLET,
						'type' => Wallet::FAST_START_TYPE,
						'inOut' => Wallet::IN,
						'userId' => $userData->userId,
						'amount' => $carBonus,
						'note'   => '$' . $packageBonus . ' from ' . $user->name . ' became a new agency/upgrade',
					];
					
					Wallet::create($fields);
				}

				if($packageBonus > 0)
					self::investBonusFastStart($refererId, $userId, $packageId, $packageBonus, $level);

				self::investBonus($userId, $userData->refererId, $packageId, $usdCoinAmount, ($level + 1));
			}
		}
	}

	/**
	*   Insert log for Fast Start Bonus
	*/
	public static function investBonusFastStart($userId = 0, $partnerId = 0, $packageId = 0, $amount = 0, $level)
	{
		if($userId > 0) {
			$fields = [
				'userId'     => $userId,
				'partnerId'     => $partnerId,
				'generation'     => $level,
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
			
			if($user->binaryUserId > 0 && $user->packageId > 0) {
				User::bonusBinary($userId, $partnerId, $packageId, $user->binaryUserId, $nextLegpos, $isUpgrade, $continue);
			}
		}
	}

	public static function bonusBinaryWeek($binaryUserId = 0, $usdCoinAmount = 0, $legpos)
	{
		$year = date('Y');
                
        $dt = Carbon::now();
        $weeked = $dt->weekOfYear;
        //neu la CN thi day la ve cua tuan moi
        if($dt->dayOfWeek == 0){
            $weeked = $weeked + 1;
        }

        //neu la thu 7 nhung qua 9h thi day la ve cua tuan moi
        if($dt->dayOfWeek == 6 && $dt->hour > 8){
            $weeked = $weeked + 1;
        }

        if($weeked == 53) {
        	$weeked = 1;
        	$year += 1;
        }

        $weekYear = $year . $weeked;

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
		}
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

	public static function reUpdateUserGenealogy($refererId, $userId = 0){
		if($userId == 0)$userId = $refererId;
		$user = UserTreePermission::find($refererId);
		if($user){
			$listUsers = explode(',', $user->genealogy);
			if(!in_array($userId, $listUsers))
			{
				$user->genealogy = $user->genealogy .','.$userId;
				$user->genealogy_total = $user->genealogy_total + 1;
				$user->save();
			}
			
			if($user->userData->refererId > 0)
			self::reUpdateUserGenealogy($user->userData->refererId, $userId);
		}
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

	public static function getNewUser( $date ){
        return self::where('active' , 1)
            ->whereDate('created_at','>=', $date['from_date'])
            ->whereDate('created_at','<=', $date['to_date'])
            ->count();
    }

    public static function getDataReport($date,$opt){
        switch ($opt){
            case Report::DAY_NOW :
                return self::selectRaw('date(created_at) as date,COUNT(users.id) as totalPrice')
                    ->where('active' , 1)
                    ->whereDate('created_at','>=', $date['from_date'])
                    ->whereDate('created_at','<=', $date['to_date'])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::WEEK_NOW :
                return self::selectRaw(
                    'DATE(users.created_at) AS date, 
                CONCAT(WEEKOFYEAR(users.created_at),YEAR(users.created_at)) AS week_month_year,
                COUNT(users.id) AS totalPrice')
                    ->whereDate('users.created_at','>=', $date['from_date'])
                    ->whereDate('users.created_at','<=', $date['to_date'])
                    ->groupBy('week_month_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::MONTH_NOW :
                return self::selectRaw(
                    'DATE(users.created_at) AS date, 
                CONCAT(MONTH(users.created_at),YEAR(users.created_at)) AS week_month_year,
                COUNT(users.id) AS totalPrice')
                    ->whereDate('users.created_at','>=', $date['from_date'])
                    ->whereDate('users.created_at','<=', $date['to_date'])
                    ->groupBy('week_month_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
        }

    }

    public static function getListUserByLevel($level, $expectLevel, &$expectListUser, $listUser = [])
    {
        $curUserId = Auth::user()->id;

        if($level == 1 || $level == 0) {
            $listUser = [$curUserId];
        }

        if($level == 0)
        	$oUserF1 = UserData::whereIn('refererId', $listUser)->where('packageId', 0)->get();
        else
        	$oUserF1 = UserData::whereIn('refererId', $listUser)->where('packageId', '>', 0)->get();

        foreach($oUserF1 as $f1)
        {
            $expectListUser[$level][] = $f1->userId;
        }

        if(!isset($expectListUser[$level])) $expectListUser[$level] = [];

        if($level <= $expectLevel) {
            $nextListUser = $expectListUser[$level];
            self::getListUserByLevel($level + 1, $expectLevel, $expectListUser, $nextListUser);
        }
    }


    //Return id of agency
    public static function _getAgency($userId)
    {
        $returnId = 0;
        $oUserData = UserData::where('userId', $userId)->first();
        if($oUserData->packageId == 0)
        {
            //next user
            $oUserDataF2 = UserData::where('userId', $oUserData->refererId)->first();
            if($oUserDataF2->packageId == 0)
            {
                $oUserDataF3 = UserData::where('userId', $oUserDataF2->refererId)->first();

                if($oUserDataF3->packageId == 0)
                {
                    $oUserDataF4 = UserData::where('userId', $oUserDataF3->refererId)->first();
                    if($oUserDataF4->packageId == 0)
                    {
                        $oUserDataF5 = UserData::where('userId', $oUserDataF4->refererId)->first();
                        if($oUserDataF5->packageId == 0)
                        {
                            $oUserDataF6 = UserData::where('userId', $oUserDataF5->refererId)->first();
                            if($oUserDataF6->packageId == 0)
                            {

                            }
                            else 
                            {
                                $returnId = $oUserDataF6->userId;
                            }
                        }
                        else 
                        {
                            $returnId = $oUserDataF5->userId;
                        }
                    }
                    else 
                    {
                        $returnId = $oUserDataF4->userId;
                    }
                }
                else 
                {
                    $returnId = $oUserDataF3->userId;
                }
            }
            else 
            {
                $returnId = $oUserDataF2->userId;
            }
        } 
        else 
        {
            $returnId = $oUserData->userId;
        }

        return $returnId;
    }

}

