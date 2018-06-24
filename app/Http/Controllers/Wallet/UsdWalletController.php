<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use App\UserCoin;
use App\ExchangeRate;
use Auth;
use function Sodium\compare;
use Symfony\Component\HttpFoundation\Session\Session;
use Validator;
use App\HighestPrice;
use Log;
/**
 * Description of UsdWalletController
 *
 * @author huydk
 */
class UsdWalletController extends Controller
{
    const USD = 1;
    const BTC = 2;
    const CLP = 3;
    const REINVEST = 4;
    
    const BTCUSD = "btcusd";
    const USDCLP = "UsdToClp";
    const CLPUSD = "ClptoUsd";
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    /** 
     * @author GiangDT
     * @edit Huynq
     * @param Request $request
     * @return type
     */
    public function usdWallet( Request $request ) {
        //tranfer if request post
        $currentuserid = Auth::user()->id;
        $query = Wallet::where('userId', '=',$currentuserid);
        if(isset($request->type) && $request->type > 0){
            $query->where('type', $request->type);
        }
        $wallets = $query->where('walletType', Wallet::USD_WALLET)->orderBy('created_at', 'desc')->paginate();

        if(isset($request->type) && $request->type > 0){
             $pagination = $wallets->appends ( array (
                 'type' => $request->type
             ));
        }
        //get Packgage
        $user = Auth::user();
        
        $requestQuery = $request->query();

        $all_wallet_type = config('carcoin.wallet_type');

        $wallet_type = [];
        $wallet_type[0] = trans('adminlte_lang::wallet.title_selection_filter');
        foreach ($all_wallet_type as $key => $val) {
            if($key == 3) $wallet_type[$key] = trans($val);//infinity
            if($key == 1) $wallet_type[$key] = 'Fast Start';//referral
        }
        $wallet_type[25] = 'Convert to CAR';

        ksort($wallet_type);

        return view('adminlte::wallets.usd', [
            'user' => $user, 
            'wallets'=> $wallets,
            'wallet_type'=> $wallet_type,
            'requestQuery'=> $requestQuery,
        ]);
    }
    
    public function buyCar(Request $request) 
    {
       if($request->ajax()) 
       {
            $userCoin = Auth::user()->userCoin;

            $usdAmountErr = '';
            if($request->usdAmount == ''){
                $usdAmountErr = trans('adminlte_lang::wallet.msg_usd_amount_required');
            }elseif (!is_numeric($request->usdAmount) || $request->usdAmount < 0){
                $usdAmountErr = trans('adminlte_lang::wallet.amount_number');
            }elseif ($userCoin->usdAmount < $request->usdAmount){
                $usdAmountErr = trans('adminlte_lang::wallet.error_not_enough');
            }
     
            if($usdAmountErr == '')
            {
                $carRate = HighestPrice::getCarHighestPrice();
                $amountCAR = $request->usdAmount / $carRate;

                $userCoin->usdAmount = $userCoin->usdAmount - $request->usdAmount;
                $userCoin->clpCoinAmount =  $userCoin->clpCoinAmount + $amountCAR;
                $userCoin->save();

                $usd_to_car = [
                    "walletType" => Wallet::USD_WALLET,
                    "type"       => Wallet::USD_TO_CAR,
                    "inOut"      => Wallet::OUT,
                    "userId"     => Auth::user()->id,
                    "amount"     => $request->usdAmount,
                ];
                $result = Wallet::create($usd_to_car);

                $car_from_usd = [
                    "walletType" => Wallet::CLP_WALLET,
                    "type"       => Wallet::USD_TO_CAR,
                    "inOut"      => Wallet::IN,
                    "userId"     => Auth::user()->id,
                    "amount"     => $amountCAR,
                ];
                // Bulk insert
                $result = Wallet::create($car_from_usd);

                $request->session()->flash( 'successMessage', "Convert successfully!" );
                return response()->json(array('err' => false));
                
            } else {
                $result = [
                        'err' => true,
                        'msg' =>[
                                'usdAmountErr' => $usdAmountErr,
                            ]
                    ];
                return response()->json($result);
            }

        }
        return response()->json(array('err' => false, 'msg' => null));
    }
}