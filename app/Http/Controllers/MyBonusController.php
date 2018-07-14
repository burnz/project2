<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

use App\User;
use App\UserData;
use App\UserPackage;
use App\BonusFastStart;
use App\BonusBinary;
use App\Tickets;
use App\Awards;
use App\WeekTicketsHistory;
use App\WeekAgencyHistory;
use App\WeekAwardsHistory;
use App\LoyaltyUser;
use Auth;
use Session;
use Carbon\Carbon;

class MyBonusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function faststart(Request $request){
		$currentuserid = Auth::user()->id;
        $fastStarts = BonusFastStart::where('userId', '=',$currentuserid)->orderBy('id', 'desc')->paginate();
        return view('adminlte::mybonus.faststart')->with('fastStarts', $fastStarts);
    }
	
	public function binary(Request $request){
		$currentuserid = Auth::user()->id;
        $binarys = BonusBinary::where('userId', '=',$currentuserid)->orderBy('id', 'desc')->paginate();
        return view('adminlte::mybonus.binary')->with('binarys', $binarys);
    }

    public function tickets(Request $request)
    {
        $currentuserid = Auth::user()->id;

        $binarys = WeekTicketsHistory::where('user_id','=', $currentuserid)->orderBy('id','desc')->paginate();

        return view('adminlte::mybonus.sale_ticket',compact('binarys'));
    }

    public function detailTicket(Request $request)
    {
        $level = $request->level;
        $week = $request->week;

        //get list user by level
        $listUser = [];

        User::getListUserByLevel(0, $level, $listUser);

        if(!isset($listUser[$level])) $listUser[$level] = [];
        $binarys = Tickets::whereIn('user_id', $listUser[$level])
                    ->where('week_year', $week)
                    ->where('quantity', '>', 0)
                    ->paginate();

        if($level == 0) $percent = 5;
        if($level == 1) $percent = 5;
        if($level == 2) $percent = 2;
        if($level == 3) $percent = 1;
        if($level == 4) $percent = 1;
        if($level == 5) $percent = 1;

        return view('adminlte::mybonus.detail_level_ticket', compact('binarys', 'level', 'percent'));
    }

    public function awards(Request $request)
    {
        $currentuserid = Auth::user()->id;

        $binarys = WeekAwardsHistory::where('user_id','=', $currentuserid)->orderBy('id','desc')->paginate();

        return view('adminlte::mybonus.awards',compact('binarys'));
    }

    public function detailAward(Request $request)
    {
        $level = $request->level;
        $week = $request->week;

        //get list user by level
        $listUser = [];

        User::getListUserByLevel(0, $level, $listUser);

        if(!isset($listUser[$level])) $listUser[$level] = [];
        $binarys = Awards::whereIn('user_id', $listUser[$level])->where('week_year', $week)->where('value', '>', 0)->paginate();

        if($level == 0) $percent = 2.5;
        if($level == 1) $percent = 0.5;
        if($level == 2) $percent = 0.5;
        if($level == 3) $percent = 0.5;
        if($level == 4) $percent = 0.5;
        if($level == 5) $percent = 0.5;

        return view('adminlte::mybonus.detail_level_award',compact('binarys', 'level', 'percent'));
    }


    public function binaryCalculatorBonus(Request $request){
	    $totalBonus = 0;
        $currentuserid = Auth::user()->id;
        $user = User::find($currentuserid);
        if($user){
            $totalBonusPercent = self::binaryCalculatorBonusPercent($user->packageId);
            $weeked = date('W');
            $year = date('Y');
            $weekYear = $year.$weeked;
            
            $binary = BonusBinary::where('userId', '=',$currentuserid)->where('weekYear', '=',$weekYear)->get();
            $totalBonus = round($totalBonusPercent * $binary->settled);
        }
        return $totalBonus;
    }
    function binaryCalculatorBonusPercent($packageId = 1){
        $totalBonusPercent = 0;
        $numLeft = User::where('refererId', '=',$currentuserid)->where('leftRight', '=','left')->where('packageId', $packageId+1)->count();
        $numRight = User::where('refererId', '=',$currentuserid)->where('leftRight', '=','right')->where('packageId', $packageId+1)->count();
        if($numLeft>=3 && $numRight>=3){
            if($packageId == 1) {
                $totalBonusPercent = 0.05;
            }elseif($packageId == 2){
                $totalBonusPercent = 0.06;
            }elseif($packageId == 3){
                $totalBonusPercent = 0.07;
            }elseif($packageId == 4){
                $totalBonusPercent = 0.08;
            }elseif($packageId == 5){
                $totalBonusPercent = 0.09;
            }elseif($packageId == 6){
                $totalBonusPercent = 0.1;
            }
        }else{
            if($packageId>1)
                $totalBonusPercent = self::binaryCalculatorBonusPercent($packageId - 1);
        }
        return $totalBonusPercent;
    }
    public function loyaltys(){

    }
    public function loyalty(){
        $loyaltyBonus = config('carcoin.loyalty_bonus');
        $currentuserid = Auth::user()->id;
        $loyaltyUser = LoyaltyUser::where('userId', $currentuserid)->get()->first();
        $loyaltyUserData = array();
        if($loyaltyUser){
            $loyaltyUserData = array(
                'silverLeft' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isSilver', 1)->where('leftRight', '=', 'left')->count(),
                'silverRight' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isSilver', 1)->where('leftRight', '=', 'right')->count(),
                'goldLeft' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isGold', 1)->where('leftRight', '=', 'left')->count(),
                'goldRight' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isGold', 1)->where('leftRight', '=', 'right')->count(),
                'pearLeft' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isPear', 1)->where('leftRight', '=', 'left')->count(),
                'pearRight' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isPear', 1)->where('leftRight', '=', 'right')->count(),
                'emeraldLeft' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isEmerald', 1)->where('leftRight', '=', 'left')->count(),
                'emeraldRight' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isEmerald', 1)->where('leftRight', '=', 'right')->count(),
                'diamondLeft' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isDiamond', 1)->where('leftRight', '=', 'left')->count(),
                'diamondRight' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isDiamond', 1)->where('leftRight', '=', 'right')->count(),
            );
        }

        return view('adminlte::mybonus.loyalty', array('loyaltyUser' => $loyaltyUser, 'loyaltyBonus' => $loyaltyBonus, 'loyaltyUserData' => $loyaltyUserData));
    }
}
