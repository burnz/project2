<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\UserData;
use App\LoyaltyUser;
use App\BonusBinary;
use App\Package;
use App\UserCoin;
use App\User;
use App\UserPackage;
use App\Wallet;
use Auth;
use Log;
use DB;
use DateTime;
use App\ExchangeRate;
use App\UserTreePermission;
/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $data = [];
        
        //Goi Packgade id
        $userData = UserData::where('userId', Auth::user()->id)->get()->first();
        //Caculate total bonus from start
        $totalBonus = Wallet::where('userId', Auth::user()->id)
                            ->whereIn('walletType', [Wallet::CLP_WALLET, Wallet::REINVEST_WALLET])
                            ->where('inOut', Wallet::IN)
                            ->get();


        $amount = 0;
        if(count($totalBonus)>0)
        {
            foreach($totalBonus as $bonus) {
                if($bonus->type == Wallet::FAST_START_TYPE //bonus children buy package 
                    || $bonus->type == Wallet::INTEREST_TYPE//bonus day interest
                    || $bonus->type == Wallet::BONUS_TYPE
                    ) {
                    $amount += $bonus->amount;
                }
            }
        }
        $data['total_bonus'] = round($amount *ExchangeRate::getCLPUSDRate(),2);


        //Calculate today earning
        $tdAmount=0;
        $todayEarning = Wallet::where('userId', $userData->userId)
                            ->whereIn('walletType',[Wallet::CLP_WALLET, Wallet::REINVEST_WALLET])
                            ->where('inOut', Wallet::IN)
                            ->where('created_at','>=',date('Y-m-d').' 00:00:00')
                            ->get();

        if(count($todayEarning)>0)
        {
            foreach($todayEarning as $bonus)
            {
                if($bonus->type == Wallet::FAST_START_TYPE //bonus children buy package 
                    || $bonus->type == Wallet::INTEREST_TYPE//bonus day interest
                    || $bonus->type == Wallet::BONUS_TYPE
                    ) {
                    $tdAmount += $bonus->amount;
                }
            }
        }
        $data['today_earning']=round($tdAmount *ExchangeRate::getCLPUSDRate(),2);


        //Get F1 lef, right Volume
        $ttSale=$this->getTotalSale();

        //Get lịch sử package
        $data['history_package'] = UserPackage::getHistoryPackage();
        // check turn on/off button withdraw
        

        //get today interest
        $todayInterest=Wallet::where([['userId','=',$userData->userId],['created_at','>=',date('Y-m-d').' 00:00:00'],['inOut','=',WALLET::IN]])->whereIn('type',[Wallet::INTEREST_TYPE,Wallet::BONUS_TYPE])->sum('amount');
        //end get today interest

        return view('adminlte::home.index')->with(compact('data','todayInterest','totalSale','ttSale'));
    }


    private function getTotalSale()
    {
        $userData=UserData::where('userId','=',Auth::user()->id)->first();
        
        $data['left'] = isset($userData->saleGenLeft) ? $userData->saleGenLeft : 0;
        $data['right'] = isset($userData->saleGenRight) ? $userData->saleGenRight : 0;

        return $data;
    }

}