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

        $this->getTotalSale();
        return view('adminlte::home.index')->with(compact('data','todayInterest','totalSale','ttSale'));
    }


    private function getTotalSale()
    {
        $allNode=UserTreePermission::where('userId','=',Auth::user()->id)->first();
        $totalLeft=0;
        $totalRight=0;
        $data['left']=0;
        $data['right']=0;
        if(!empty($allNode))
        {
            $totalLeft=$this->getNodeData($allNode->genealogy_left);
            $totalRight=$this->getNodeData($allNode->genealogy_right);
            $data['left']=$totalLeft;
            $data['right']=$totalRight;
        }
        return $data;
    }

    private function getNodeData($data)
    {
        $total=0;
        if($data!='')
        {
            $dataNode=explode(',',$data);
            if(!empty($dataNode))
            {
                foreach($dataNode as $nKey=>$nVal)
                {
                    if($nVal!='')
                    {
                        $total+=UserPackage::getTotalAmount($nVal);
                    }
                }
            }
        }
        return $total;
    }


    private function getLeftTotalPackage()
    {
        $list=UserTreePermission::where('userId','=',Auth::user()->id)->get();
        
    }

    /*
    *Author huynq
    *Doanh so F1 moi tinh trong tuan hien tai and trai and phai
    */
    private function newF1InWeek($value='')
    {
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;
        if($weeked < 10)$weekYear = $year.'0'.$weeked;
        try {
            $data =  BonusBinary::where('userId',Auth::user()->id)->where('weekYear', $weekYear)
                ->get();
            if(count($data) > 0){
                $data['total']   = $data[0]->leftNew + $data[0]->rightNew;
                $data['leftNew'] = $data[0]->leftNew;
                $data['rightNew']= $data[0]->rightNew;
                $data['leftOpen']= $data[0]->leftOpen;
                $data['rightOpen']= $data[0]->rightOpen;
            }else{
                $data['total'] = 0;
                $data['leftNew'] = 0;
                $data['rightNew'] = 0;
                $data['leftOpen']= 0;
                $data['rightOpen']= 0;
            }
            return $data;
        } catch (Exception $e) {
            Log::error( $e->gettraceasstring() );
        }
    }

    /*
    *Author huynq
    * Tong doanh so F1 tu khi tham gia and trai and phai
    */
    private function getF1CurrentWeek($value='')
    {
        try {
            $data = UserData::where('refererId', Auth::user()->id)
                ->pluck('userId');
            if ($data) {
                $firstDayThisWeek = date("Y-m-d 00:00:00", strtotime('monday this week'));

                $amount = 0;
                foreach( $data as $userId ) {
                    // Get current week package from table user_packages
                    $pakages = UserPackage::where('userId', $userId)->where('buy_date', '>',  $firstDayThisWeek)
                    ->get();
                    
                    foreach ($pakages as $package) {
                        $amount += $package->amount_increase;
                    }
                }

                //
                return $amount;
            }else{
                //Debug
                Log::error('Cannot get user with userid = ' . Auth::user()->id);
            }
        } catch (Exception $e) {
            Log::error($e->gettraceasstring());
        }
    }

    /**
    * @Author GiangDT
    * Total F1 from beginning day
    */
    private function getF1TotalSale()
    {
        try {
            $data = UserData::where('refererId', Auth::user()->id)
                ->pluck('userId');
            if ($data) {

                $amount = 0;
                foreach( $data as $userId ) {
                    // Get current week package from table user_packages
                    $pakages = UserPackage::where('userId', $userId)->get();
                    
                    foreach ($pakages as $package) {
                        $amount += $package->amount_increase;
                    }
                }

                //
                return $amount;
            }else{
                //Debug
                Log::error('Cannot get user with userid = ' . Auth::user()->id);
            }
        } catch (Exception $e) {
            Log::error($e->gettraceasstring());
        }
    }

    /*
    *Author huynq
    *Thông tin coin 
    */
    private function getInfoCoin(){
        try {
            $data = UserCoin::where("userId",Auth::user()->id)
                    ->get();
            return $data;
        } catch (Exception $ex) {
            echo $e->gettraceasstring();
        }
    }

    private function userStaticsLoyalty(){
        $loyaltyLeft = $loyaltyRight = [
            'isSilver' => 0,
            'isGold' => 0,
            'isPear' => 0,
            'isEmerald' => 0,
            'isDiamond' => 0
        ];

        $binaryUserLeft = UserData::where('binaryUserId', '=', Auth::user()->id)->where('leftRight', '=', 'left')->first();
        $binaryUserRight = UserData::where('binaryUserId', '=', Auth::user()->id)->where('leftRight', '=', 'right')->first();



        $lstUserLeft = $lstUserRight = [];
        if(isset($binaryUserLeft->userId)){
            $lstUserLeft = $this->userBinaryLoop($lstUserLeft, $binaryUserLeft->userId);
        }
        if(isset($binaryUserRight->userId)){
            $lstUserRight = $this->userBinaryLoop($lstUserRight, $binaryUserRight->userId);
        }

        if( isset($binaryUserLeft->userId) ) $lstUserLeft[] = $binaryUserLeft->userId;
        if( isset($binaryUserRight->userId) ) $lstUserRight[] = $binaryUserRight->userId;

        if($lstUserLeft){
            $lstLoyalty = LoyaltyUser::whereIn('userId', $lstUserLeft)->get();
            if($lstLoyalty){
                foreach($lstLoyalty as $loyalty){
                    if($loyalty->isDiamond){
                        $loyaltyLeft['isDiamond'] = $loyaltyLeft['isDiamond'] + 1;
                    }elseif($loyalty->isEmerald){
                        $loyaltyLeft['isEmerald'] = $loyaltyLeft['isEmerald'] + 1;
                    }elseif($loyalty->isPear){
                        $loyaltyLeft['isPear'] = $loyaltyLeft['isPear'] + 1;
                    }elseif($loyalty->isGold){
                        $loyaltyLeft['isGold'] = $loyaltyLeft['isGold'] + 1;
                    }elseif($loyalty->isSilver){
                        $loyaltyLeft['isSilver'] = $loyaltyLeft['isSilver'] + 1;
                    }
                }
            }
        }
        if($lstUserRight){
            $lstLoyalty = LoyaltyUser::whereIn('userId', $lstUserRight)->get();
            if($lstLoyalty){
                foreach($lstLoyalty as $loyalty){
                    if($loyalty->isDiamond){
                        $loyaltyRight['isDiamond'] = $loyaltyRight['isDiamond'] + 1;
                    }elseif($loyalty->isEmerald){
                        $loyaltyRight['isEmerald'] = $loyaltyRight['isEmerald'] + 1;
                    }elseif($loyalty->isPear){
                        $loyaltyRight['isPear'] = $loyaltyRight['isPear'] + 1;
                    }elseif($loyalty->isGold){
                        $loyaltyRight['isGold'] = $loyaltyRight['isGold'] + 1;
                    }elseif($loyalty->isSilver){
                        $loyaltyRight['isSilver'] = $loyaltyRight['isSilver'] + 1;
                    }
                }
            }
        }
        return ['loyaltyLeft' => $loyaltyLeft, 'loyaltyRight' => $loyaltyRight];
    }

    private function userBinaryLoop($lstUser = [], $userId){
        $binaryUser = UserData::where('binaryUserId', '=', $userId)->get();
        if($binaryUser){
            foreach($binaryUser as $binary){
                if($binary && $binary->userId > 0){
                    if(!in_array($binary->userId, $lstUser)){
                        $lstUser[] = $binary->userId;
                    }
                    $lstUser = $this->userBinaryLoop($lstUser, $binary->userId);
                }
            }
        }
        return $lstUser;
    }
}