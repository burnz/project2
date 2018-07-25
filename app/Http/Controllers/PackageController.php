<?php
namespace App\Http\Controllers;
use App\UserCoin;
use App\UserData;
use App\UserPackage;
use App\Tickets;
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
use App\HighestPrice;
use Carbon\Carbon;

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

    public function showBuyPackage(Request $request)
    {
        $wid=$request->wid;
        // if(!empty($wid) && ($wid==2 | $wid==3 ))
        // {

            $package=Package::all();
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
            return view('adminlte::package.iBuy',compact('dataPack','package','exchange','userPack'));
        // }
        // return redirect('packages/buy')
        // ->with('flash_error','Whoops. Something went wrong.');
        
    }

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



   
    public function invest(Request $request)
    {

        $currentuserid = Auth::user()->id;
        $user = Auth::user();
        
        if($user && $request->isMethod('post')) 
        {
            $msgReturn='';

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
                        default:
                                return false;
                            break;
                    }
                    return false;
            });

            Validator::extend('packageCheck', function ($attribute, $value) {
                $user = Auth::user();
                // if($user->userData->packageId < $value)
                // {
                    $package = Package::find($value);
                    if($package){
                        $packageOldId = $user->userData->packageId;
                        $usdCoinAmount = $package->min_price;

                        if($packageOldId > 0){
                            $usdCoinAmount = $usdCoinAmount - $user->userData->package->min_price;
                        }

                        $clpCoinAmount = $usdCoinAmount / ExchangeRate::getCLPUSDRate();
                        if(round($user->userCoin->clpCoinAmount, 2) >= $clpCoinAmount){
                            return true;
                        }
                    }
                // }
            });

            Validator::extend('downCheck', function ($attribute, $value) {
                $user = Auth::user();
                if($user->userData->packageId < $value)
                {
                    return true;
                }

                return false;
            });

            Validator::extend('withdrawCheck', function ($attribute, $value) {
                $userPack = UserPackage::where("userId", Auth::user()->id)->where('withdraw',1)->first();
                $user = Auth::user();
                if($user->userData->packageId == 0 && isset($userPack->withdraw))
                {
                    return false;
                }

                return true;
            });

            $errors=['packageId.package_check'=>'Wallet amount is not enough to buy package', 'packageId.down_check'=>'The package downgrade is not allowed', 'packageId.withdraw_check'=>'You cannot become agency again after cancellation'];
            $this->validate($request, [
                'packageId' => 'required|not_in:0|packageCheck|downCheck|withdrawCheck',
            ],$errors);

            //add data to user data
            $amount_increase = 0;
            $packageOldId = 0;
            $userData = $user->userData;
            $packageOldId = $userData->packageId;
            $packageOldPrice = isset($userData->package->min_price) ? $userData->package->min_price : 0;

            $package = Package::find($request->packageId);
            if ($package) {
                $amount_increase = $package->min_price;
            }

            if($packageOldId > 0){
                $amount_increase = $package->min_price - $packageOldPrice;
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
            
            $packageSelected = Package::find($request->packageId);
            UserPackage::create([
                'userId' => $currentuserid,
                'packageId' => $request->packageId,
                'amount_increase' => $amount_increase,
                'amount_carcoin'=>round($amount_increase / ExchangeRate::getCLPUSDRate(), 2),
                'buy_date' => date('Y-m-d H:i:s'),
                'refund_type' => 2,
                'release_date' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") ."+ 90 days")),
                'weekYear' => $weekYear,
            ]);

            //deduct ticket sale of agency sponsor 
            if($packageOldId == 0) {
                //find agency
                $parentId = 0;
                User::_getAgency($user->id, $parentId);

                if($parentId > 0) 
                {
                    $agency = UserData::where('userId', $parentId)->first();
                    if($agency->packageId > 0) {
                        $sponsorTicket = Tickets::where('user_id', $agency->userId)->where('week_year', $weekYear)->first();
                        $oTicket = Tickets::where('user_id', $user->id)->where('week_year', $weekYear)->first();
                        if($sponsorTicket && $oTicket) {
                            $sponsorTicket->quantity -= $oTicket->personal_quantity;
                            $sponsorTicket->save();
                        }
                    }
                }
            }

            $userData->packageDate = date('Y-m-d H:i:s');
            $userData->packageId = $request->packageId;
            $userData->status = 1;
            $userData->save();
            //end add data to user package

            $amountCLPDecrease = round($amount_increase / ExchangeRate::getCLPUSDRate(), 2);
            $userCoin = $userData->userCoin;
            $userCoin->clpCoinAmount = $userCoin->clpCoinAmount - $amountCLPDecrease;
            $userCoin->save();
            $fieldUsd = [
                'walletType' => Wallet::CLP_WALLET,//usd
                'type' => Wallet::BUY_PACK_TYPE,//bonus f1
                'inOut' => Wallet::OUT,
                'userId' => Auth::user()->id,
                'amount' => $amountCLPDecrease,
                'note'   => 'USD value ' . $amount_increase 
            ];

            Wallet::create($fieldUsd);
            // Calculate fast start bonus
            User::investBonus($user->id, $user->refererId, $request->packageId, $amount_increase, 1);
            
            // Case: User already in tree and then upgrade package => re-caculate loyalty
            /*if($userData->binaryUserId && $userData->packageId > 0)
                User::bonusLoyaltyUser($userData->userId, $userData->refererId, $userData->leftRight);*/

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
            //$this->rankProcess();

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

    public function withDraw(Request $request) 
    {
        if($request->ajax())
        {
            $datetime1 = new DateTime(date("Y-m-d H:i:s"));
            
            //compare
            $userPackages = UserPackage::where("userId",Auth::user()->id)->where('withdraw', 0)->get();
            foreach($userPackages as $package) 
            {
                //get release date của package cuối cùng <-> max id
                $datetime2 = new DateTime(date('Y-m-d H:i:s', strtotime($package->buy_date . "+ 90 days")));
                $interval = $datetime1->diff($datetime2);
                if( $interval->format('%R%a') > 0 ){
                    $message = trans("adminlte_lang::home.not_enought_time");
                    return $this->responseError($errorCode = true,$message);
                }

                $amountCLP = $package->refund_type == 1 ? round($package->amount_increase / HighestPrice::getCarHighestPrice(), 2):$package->amount_carcoin;

                // if($package->refund_type == 1)
                // {
                //     $money = Auth()->user()->userCoin->usdAmount + $package->amount_increase;
                //     $update = UserCoin::where("userId",Auth::user()->id)
                //             ->update(["usdAmount" => $money]);
                //     $fields = [
                //         'walletType' => Wallet::CLP_WALLET,//usd
                //         'type' => Wallet::WITHDRAW_PACK_TYPE,
                //         'inOut' => Wallet::IN,
                //         'userId' => Auth::user()->id,
                //         'amount' => $package->amount_increase,
                //         'note'   => 'Withdraw $'.$package->amount_increase.' from package '.$package->packageId
                //     ];
                //     Wallet::create($fields);
                // } 
                // else 
                // {
                $money = Auth()->user()->userCoin->clpCoinAmount + $amountCLP;
                $update = UserCoin::where("userId",Auth::user()->id)
                        ->update(["clpCoinAmount" => $money]);
                $fields = [
                    'walletType' => Wallet::CLP_WALLET,//clp
                    'type' => Wallet::WITHDRAW_PACK_TYPE,
                    'inOut' => Wallet::IN,
                    'userId' => Auth::user()->id,
                    'amount' => $amountCLP,
                    'note'   => 'Withdraw $'.$package->amount_increase.' = '.$amountCLP.' car from package '.$package->packageId
                ];
                Wallet::create($fields);
                //}

                $package->withdraw = 1;
                $package->save();
            }
           
            $update = UserData::where('userId', Auth::user()->id)->update(["packageId" => 0, "status" => 0]);
            if($update){
                return $this->responseSuccess( $data = $money );
            }
        }
    }
}