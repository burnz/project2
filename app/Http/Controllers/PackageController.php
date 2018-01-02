<?php
namespace App\Http\Controllers;
use App\UserCoin;
use App\UserData;
use App\UserPackage;
use Illuminate\Http\Request;
use App\User;
use App\Package;
use Auth;
use Session;
use App\Authorizable;
use Validator;
use DateTime;
use App\ExchangeRate;
use App\Wallet;
use App\CronProfitLogs;
use App\CronBinaryLogs;
use App\CronMatchingLogs;
use App\CronLeadershipLogs;
use App\TotalWeekSales;
use App\Cronjob\Bonus;
use App\UserTreePermission;
class PackageController extends Controller
{
    use Authorizable;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $packages = Package::all();
        return view('adminlte::package.index')->with('packages', $packages);
    }
    public function create()
    {
        return view('adminlte::package.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
                'name'=>'required|unique:packages',
                'price'=>'required|integer|unique:packages',
                'pack_id'=>'required|integer|unique:packages',
            ]
        );
        $package = Package::create($request->only('pack_id', 'name', 'price', 'token'));
        return redirect()->route('packages.index')
            ->with('flash_message',
                'Packages '. $package->name.' added!');
    }

    /**
    * Buy package action( upgrade package)
    */

    public function buyPackage()
    {
        $package=Package::all();
        $userPack=UserPackage::getHistoryPackage();
        $datetimeNow = new DateTime(date("Y-m-d"));
        $exchange=ExchangeRate::where([['from_currency','=','clp'],['to_currency','=','usd']])->first();
        $rate_clp_usd=isset($exchange->exchrate)?$exchange->exchrate:1;
        $dataPack=[];
        if(count($package)>0)
        {
            foreach($package as $pkey=>$pval)
            {
                $pval->min_price_clp=round($pval->min_price/$rate_clp_usd,4);
                $pval->max_price_clp=round($pval->max_price/$rate_clp_usd,4);
                array_push($dataPack, $pval);
            }
        }
        return view('adminlte::package.buy')->with(compact('dataPack','package','exchange','userPack','datetimeNow'));
    }



    public function rankProcess()
    {
        $lstUser = User::where('active', '=', 1)->get();
        foreach($lstUser as $user){
            $userData=$user->userData;
            $packageId=$userData->packageId;
            $rank=0;
            $totalLeft=$userData->totalSaleLeft;
            $totalRight=$userData->totalSaleRight;
            if($totalLeft >= config('carcoin.loyalty_upgrate_silver') && 
                $totalRight >= config('carcoin.loyalty_upgrate_silver') && 
                $packageId >= 1 )
            {
                $rank=1;
            }

            if($totalLeft >= config('carcoin.loyalty_upgrate_gold') && 
                $totalRight >=config('carcoin.loyalty_upgrate_gold') && 
                $packageId >= 2)
            {
                $rank=2;
            }

            if($totalLeft >= config('carcoin.loyalty_upgrate_pear') && 
                $totalRight >= config('carcoin.loyalty_upgrate_pear') && 
                $packageId >= 3)
            {
                $rank=3;
            }

            if($totalLeft >= config('carcoin.loyalty_upgrate_emerald') && 
                $totalRight >= config('carcoin.loyalty_upgrate_emerald') && 
                $packageId == 4)
            {
                $rank=4;
            }

            if($totalLeft >= config('carcoin.loyalty_upgrate_diamond') && 
                $totalRight >= config('carcoin.loyalty_upgrate_diamond') && 
                $packageId == 4)
            {
                $rank=5;
            }

            if($userData->loyaltyId<$rank)
            {
                $userData->loyaltyId=$rank;
                $userData->save();
            }

        }
    }

    public function invest(Request $request)
    {

        $currentuserid = Auth::user()->id;
        $user = Auth::user();
        
        if($user && $request->isMethod('post')) 
        {
            $msgReturn='';
            Validator::extend('packageCheck', function ($attribute, $value, $parameters) {
                global $msgReturn;
                $packageId = $parameters[0];
                //Get packageid 
                //min_price|max_price|amount-->$
                $package = Package::find($packageId);
                if($package->min_price <= $value && $value <= $package->max_price)
                {
                    return true;
                }
                return false;
            });

            Validator::extend('amountDivided',function($attribute,$value,$parameters){
                if(floatval($value%10)==0)
                    return true;
                return false;
            });
            Validator::extend('fundCheck',function($attribute, $value, $parameters){
                if($value!=Package::TYPE_USD && $value!=Package::TYPE_CAR)
                {
                    return false;
                }
                return true;
            });
            Validator::extend('amountCheck',function($attribute,$value,$parameters){
                    $userCoin=UserCoin::where('userId','=',Auth::user()->id)->first();
                    $walletId=$parameters[0];
                    //change value to carcoin
                    switch ($walletId) {
                        case 2:
                                $value=round($value/ExchangeRate::getCLPUSDRate(),2);
                                if($value<=$userCoin->clpCoinAmount)
                                {
                                    return true;
                                }
                            break;
                        case 3:
                                if($value<=$userCoin->reinvestAmount)
                                {
                                    return true;
                                }
                            break;
                        default:
                                return false;
                            break;
                    }
                    return false;
            });

            $errors=['packageAmount.package_check'=>'Invest amount and package selected does not match','packageAmount.amount_check'=>'Wallet amount does not enough to buy package','packageAmount.amount_divided'=>'Amount must be divided by 10','refundType.fund_check'=>'Please select refund type'];
            $this->validate($request, [
                'packageAmount'    => 'required|packageCheck:' . $request->packageId.'|amountCheck:'.$request->walletId.'|amountDivided',
                'packageId' => 'required|not_in:0',
                'walletId'=>  'required|not_in:0',
                'refundType'=>'required|fundCheck:'.$request->refundType
            ],$errors);

            //add data to user data
            $amount_increase = $request->packageAmount;
            $packageOldId = 0;
            $userData = $user->userData;
            $packageOldId = $userData->packageId;
            if($request->packageId > $packageOldId) {
                $userData->packageDate = date('Y-m-d H:i:s');
                $userData->packageId = $request->packageId;
                $userData->status = 1;
                $userData->save();
            }
            //end add data to user data


            //Insert to cron logs for binary, profit
            if($packageOldId == 0) {
                if(CronProfitLogs::where('userId', $currentuserid)->count() < 1) 
                    CronProfitLogs::create(['userId' => $currentuserid]);
                if(CronBinaryLogs::where('userId', $currentuserid)->count() < 1) 
                    CronBinaryLogs::create(['userId' => $currentuserid]);
                if(CronMatchingLogs::where('userId', $currentuserid)->count() < 1) 
                    CronMatchingLogs::create(['userId' => $currentuserid]);
                if(CronLeadershipLogs::where('userId', $currentuserid)->count() < 1) 
                    CronLeadershipLogs::create(['userId' => $currentuserid]);
                if(TotalWeekSales::where('userId', $currentuserid)->count() < 1) 
                    TotalWeekSales::create(['userId' => $currentuserid]);
            }

            //add data to user package
            //Get weekYear
            $weeked = date('W');
            $year = date('Y');
            $weekYear = $year.$weeked;
            if($weeked < 10) $weekYear = $year.'0'.$weeked;
            $packageSelected = Package::find($request->packageId);
            UserPackage::create([
                'userId' => $currentuserid,
                'packageId' => $request->packageId,
                'amount_increase' => $amount_increase,
                'refund_type'=>$request->refundType,
                'amount_carcoin'=>round($amount_increase / ExchangeRate::getCLPUSDRate(), 2),
                'buy_date' => date('Y-m-d H:i:s'),
                'release_date' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . "+ " . $packageSelected->capital_release ." days")),
                'weekYear' => $weekYear,
            ]);
            //end add data to user package


            $amountCLPDecrease = round($amount_increase / ExchangeRate::getCLPUSDRate(), 2);
            $userCoin = $userData->userCoin;
            if($request->walletId==2)
                $userCoin->clpCoinAmount = $userCoin->clpCoinAmount - $amountCLPDecrease;
            if($request->walletId==3)
                $userCoin->reinvestAmount = $userCoin->reinvestAmount - $amountCLPDecrease;

            $userCoin->save();
            $walletType=$request->walletId==2?Wallet::CLP_WALLET : Wallet::REINVEST_WALLET;
            $fieldUsd = [
                'walletType' => $walletType,//usd
                'type' => Wallet::BUY_PACK_TYPE,//bonus f1
                'inOut' => Wallet::OUT,
                'userId' => Auth::user()->id,
                'amount' => $amountCLPDecrease,
                'note'   => 'USD value ' . $amount_increase 
            ];
            



            Wallet::create($fieldUsd);
            // Calculate fast start bonus
            User::investBonus($user->id, $user->refererId, $request['packageId'], $amount_increase);
            
            // Case: User already in tree and then upgrade package => re-caculate loyalty
            if($userData->binaryUserId && $userData->packageId > 0)
                User::bonusLoyaltyUser($userData->userId, $userData->refererId, $userData->leftRight);

            // Case: User already in tree and then upgrade package => re-caculate binary bonus
            if($userData->binaryUserId > 0 && in_array($userData->leftRight, ['left', 'right'])) {
                
                $leftRight = $userData->leftRight == 'left' ? 1 : 2;
                User::bonusBinary($userData->userId, 
                                $userData->refererId, 
                                $request->packageId, 
                                $userData->binaryUserId, 
                                $leftRight,
                                true,
                                false
                            );
            }

            //process rank
            $this->rankProcess();

            return redirect('packages/buy')
            ->with('flash_success','Buy package successfully.');         
        }
        return redirect('packages/buy')
        ->with('flash_error','Whoops. Something went wrong.');
    }


    public function show($id)
    {
        return redirect('packages');
    }
    public function edit($id)
    {
        $package = Package::find($id);
        return view('adminlte::package.edit', compact('package'));
    }
    public function update(Request $request, $id)
    {
        $package = Package::find($id);
        if($package) {
            $this->validate($request, [
                    'name' => 'required|unique:packages,name,' . $id,
                    'price' => 'required|integer|unique:packages,price,' . $id,
                    'pack_id' => 'required|integer|unique:packages,pack_id,' . $id,
                ]
            );
            $input = $request->only(['pack_id', 'name', 'price', 'token']);
            $package->fill($input)->save();
            return redirect()->route('packages.index')
                ->with('flash_message',
                    'Package ' . $package->name . ' updated!');
        }else{
            return redirect()->route('Packages.index')
                ->with('error',
                    'Package not update!');
        }
    }
    public function destroy($id)
    {
        $package = Package::find($id);
        if($package){
            $package->delete();
            return redirect()->route('Packages.index')
                ->with('flash_message',
                    'Package deleted!');
        }else{
            return redirect()->route('Packages.index')
                ->with('error',
                    'Package not delete!');
        }
    }
    
    /**
     * @author Huy NQ
     * @param Request $request
     * @return type
     */



    public function reduceAmount($amount_increase)
    {
        $lstUser = User::where('active', '=', 1)->get();
        $currentuserid=Auth::user()->id;
        foreach($lstUser as $user){
            $userData=$user->userData;;
            $userTree=UserTreePermission::where('userId',$user->id)->first();
            if($userTree)
            {
                $dataLeft=$userTree->genealogy_left;
                $dataRight=$userTree->genealogy_right;

                if($dataLeft!='')//calculator left
                {
                    $dataNode=explode(',',$dataLeft);
                    if(!empty($dataNode))
                    {
                        foreach($dataNode as $nKey=>$nVal)
                        {
                            if($nVal==$currentuserid)//left
                            {
                                $userData->totalSaleLeft=$userData->totalSaleLeft-$amount_increase;
                                $userData->save();
                            }
                        }
                    }
                }

                if($dataRight!='')//calculator right
                {
                    $dataNode=explode(',',$dataRight);
                    if(!empty($dataNode))
                    {
                        foreach($dataNode as $nKey=>$nVal)
                        {
                            if($nVal==$currentuserid)//left
                            {
                                $userData->totalSaleRight=$userData->totalSaleRight-$amount_increase;
                                $userData->save();
                            }
                        }
                    }
                }


            }
        }
    }

    public function withDraw(Request $request) {
        if($request->ajax()){
            $tempHistoryPackage = UserPackage::where("userId",Auth::user()->id)
                    ->where('id',$request->id)->first();
            if(!isset($tempHistoryPackage)){
                $message = trans("adminlte_lang::home.not_buy_package");
                return $this->responseError($errorCode = true,$message);
            }
            //check userID and check withdraw
            if( $tempHistoryPackage->withdraw == 1 ){
                $message = trans("adminlte_lang::home.package_withdrawn");
                return $this->responseError($errorCode = true,$message);
            }
           
            $datetime1 = new DateTime(date("Y-m-d H:i:s"));
            //get release date của package cuối cùng <-> max id
            $datetime2 = new DateTime($tempHistoryPackage->release_date);
            $interval = $datetime1->diff($datetime2);

            //compare
            if( $interval->format('%R%a') > 0 ){
                $message = trans("adminlte_lang::home.not_enought_time");
                return $this->responseError($errorCode = true,$message);
            }else{
                UserPackage::where("id",$tempHistoryPackage->id)->update(["withdraw"=> 1 ]);
                $amountCLP=$tempHistoryPackage->refund_type==1?round($tempHistoryPackage->amount_increase / ExchangeRate::getCLPUSDRate(), 2):$tempHistoryPackage->amount_carcoin;
                $money = Auth()->user()->userCoin->clpCoinAmount + $amountCLP;
                $update = UserCoin::where("userId",Auth::user()->id)
                        ->update(["clpCoinAmount" => $money]);
                $fieldUsd = [
                    'walletType' => Wallet::CLP_WALLET,//usd
                    'type' => Wallet::WITHDRAW_PACK_TYPE,
                    'inOut' => Wallet::IN,
                    'userId' => Auth::user()->id,
                    'amount' => $amountCLP,
                    'note'   => 'Withdraw $'.$tempHistoryPackage->amount_increase.' = '.$amountCLP.' Carcoin from package '.$tempHistoryPackage->packageId
                ];
                Wallet::create($fieldUsd);
                //Update packageId = 0 after withdraw
                //If over 12 months from release_date then withdraw don't update packageId = 
                $twelveMonth = strtotime($tempHistoryPackage->release_date . "+ 6 months");
                $datetime2 = new DateTime(date('Y-m-d H:i:s', $twelveMonth));
                $interval = $datetime1->diff($datetime2);

                $this->reduceAmount($tempHistoryPackage->amount_increase);//reduce amount

                if( $interval->format('%R%a') > 0 ) 
                    $update=UserData::where('userId', Auth::user()->id)->update(["packageId" => 0,"packageDate"=>null]);
                if($update){
                    return $this->responseSuccess( $data = $money );
                }
            }
        }
    }
}