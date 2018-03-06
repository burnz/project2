<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Wallet;

use App\UserCoin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Package;
use App\User;
use App\Wallet;
use App\Withdraw;
use Auth;
use Symfony\Component\HttpFoundation\Session\Session; 
use Validator;
use Log;
use App\CLPWalletAPI;
use App\CLPWallet;
use App\ExchangeRate;
use Google2FA;
use Carbon\Carbon;

/**
 * Description of ClpWalletController
 *
 * @author huydk
 */
class ClpWalletController extends Controller {
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function viewClpTransfer(Request $request)
    {
        return view('adminlte::wallets.clpTransfer');
    }

    public function viewClpWithdraw(Request $request)
    {
        return view('adminlte::wallets.clpWithdraw');
    }
    public function viewClpDeposit(Request $request){
        $currentuserid = Auth::user()->id;
        $clpWallet = CLPWallet::where('userId', $currentuserid)->selectRaw('address')->first();
        $walletAddress = isset($clpWallet->address) ? $clpWallet->address : '';
        return view('adminlte::wallets.clpDeposit',compact('walletAddress'));
    }

    /**
     * @author Huynq
     * @return type
     */
    public function clpWallet(Request $request) {
        $currentuserid = Auth::user()->id;
        $query = Wallet::where('userId', '=',$currentuserid);
        if(isset($request->type) && $request->type > 0){
            $query->where('type', $request->type);
        }
        $wallets = $query->where('walletType', Wallet::CLP_WALLET)->orderBy('id', 'desc')->paginate();

        if(isset($request->type) && $request->type > 0){
             $pagination = $wallets->appends ( array (
                 'type' => $request->type
             ));
        }
        //get Packgage
        $user = Auth::user();
        $packages = Package::all();
        $lstPackSelect = array();
        foreach ($packages as $package){
            $lstPackSelect[$package->id] = $package->name;
        }
        $requestQuery = $request->query();

        $all_wallet_type = config('carcoin.wallet_type');

        //CLP Wallet has 6 type:15-buy pack, 14-Deposit, 10-Withdraw, 7-Buy CLP by BTC, 8-Sell CLP, 5-Buy CLP by USD, 6-Transfer From Holding Wallet
        $wallet_type = [];
        $wallet_type[0] = trans('adminlte_lang::wallet.title_selection_filter');
        foreach ($all_wallet_type as $key => $val) {

            if($key == 7) $wallet_type[$key] = trans($val);//buy car by btc
            if($key == 10) $wallet_type[$key] = trans($val);//withdraw
            if($key == 12) $wallet_type[$key] = trans($val);//transfer
            if($key == 14) $wallet_type[$key] = trans($val);//deposit
            if($key == 15) $wallet_type[$key] = trans($val);//buy package
            if($key == 2) $wallet_type[$key] = trans($val);//interest
            if($key == 3) $wallet_type[$key] = trans($val);//infinity
            if($key == 18) $wallet_type[$key] = trans($val);//infinity interest
            if($key == 19) $wallet_type[$key] = trans($val);//global bonus
            if($key == 1) $wallet_type[$key] = trans($val);//referral
        }

        ksort($wallet_type);

        $clpWallet = CLPWallet::where('userId', $currentuserid)->selectRaw('address')->first();
        $walletAddress = isset($clpWallet->address) ? $clpWallet->address : '';
        
        return view('adminlte::wallets.clp', ['packages' => $packages, 
            'user' => $user, 
            'lstPackSelect' => $lstPackSelect, 
            'wallets'=> $wallets,
            'wallet_type'=> $wallet_type,
            'walletAddress' =>  $walletAddress,
            'requestQuery'=> $requestQuery,
            'active' => 1
        ]);
        
    }

    public static function generateCLPWallet() {
        $client = new CLPWalletAPI();

        $result = $client->generateWallet();
        if($result['success'] == 1) {
            $fields = [
                'address'     => $result['address'],
                'transaction'     => $result['tx'],
            ];

            CLPWallet::create();
        }

    }

    /** 
     * @author GiangDT
     * @param Request $request
     * @return type
     */
    public function clptranfer(Request $request){
        if($request->ajax()){

            $userCoin = Auth::user()->userCoin;
            $clpAmountErr = $clpUsernameErr = $clpUidErr = $clpOTPErr = $transferRuleErr = '';

            if($request->carAmount == ''){
                $clpAmountErr = trans('adminlte_lang::wallet.amount_required');
            }elseif (!is_numeric($request->carAmount) || $request->carAmount < 0){
                $clpAmountErr = trans('adminlte_lang::wallet.amount_number');
            }elseif ($userCoin->clpCoinAmount < $request->carAmount){
                $clpAmountErr = trans('adminlte_lang::wallet.error_not_enough');
            }

            if($request->carUsername == ''){
                $clpUsernameErr = trans('adminlte_lang::wallet.username_required');
            }elseif (!preg_match('/^\S*$/u', $request->carUsername)){
                $clpUsernameErr = trans('adminlte_lang::wallet.username_notspace');
            }elseif (!User::where('name', $request->carUsername)->where('active', 1)->count()){
                $clpUsernameErr = trans('adminlte_lang::wallet.username_not_invalid');
            }

            if($request->carUid == ''){
                $clpUidErr = trans('adminlte_lang::wallet.uid_required');
            }elseif (!preg_match('/^\S*$/u', $request->carUid)){
                $clpUidErr = trans('adminlte_lang::wallet.uid_notspace');
            }elseif (!User::where('uid', $request->carUid)->where('active', 1)->count()){
                $clpUidErr = trans('adminlte_lang::wallet.ui_not_invalid');
            }

            if($request->carOTP == ''){
                $clpOTPErr = trans('adminlte_lang::wallet.otp_required');
            }else{
                $key = Auth::user()->google2fa_secret;
                $valid = Google2FA::verifyKey($key, $request->carOTP);
                if(!$valid){
                    $clpOTPErr = trans('adminlte_lang::wallet.otp_not_match');
                }
            }

            //Only transfer CLP, Withdraw $10.000 per day
            $topLeaders = explode(',', config('app.top_leaders'));
            if( !in_array(Auth::user()->id, $topLeaders) )
            {
                $totalMoneyOut = UserCoin::getTotalWithdrawTransferDay(Auth::user()->id);

                $currentTotal = $request->carAmount * ExchangeRate::getCLPUSDRate() + $totalMoneyOut;

                if($currentTotal > 60000)
                {
                    $clpAmountErr = 'Daily transfer cannot exceed $60,000';
                }
            }
            

            /******************* Only transfer in Genealogy ***************/
            // Get all Genealogy current user
            $lstCurrentGenealogyUser = [];
            if($userTreePermission = Auth::user()->userTreePermission)
                $lstCurrentGenealogyUser = explode(',', $userTreePermission->genealogy);

            // Get all Genealogy transfer user
            $transferUser = User::where('name', '=', $request->carUsername)->first();
            $lstTransferGenealogyUser = [];
            if($userTreePermission = $transferUser->userTreePermission)
                $lstTransferGenealogyUser = explode(',', $userTreePermission->genealogy);

            if(!in_array($transferUser->id, $lstCurrentGenealogyUser) 
                && !in_array(Auth::user()->id, $lstTransferGenealogyUser)) {
                $transferRuleErr = trans('adminlte_lang::wallet.msg_transfer_rule');
            }

            if($clpAmountErr =='' && $clpUsernameErr == '' && $clpOTPErr == '' && $clpUidErr == '' && $transferRuleErr == ''){
                $userCoin->clpCoinAmount = $userCoin->clpCoinAmount - $request->carAmount;
                $userCoin->save();
                $userRi = User::where('name', $request->carUsername)->where('active', 1)->first();
                $userRiCoin = $userRi->userCoin;
                if($userRiCoin){
                    $userRiCoin->clpCoinAmount = $userRiCoin->clpCoinAmount + $request->carAmount;
                    $userRiCoin->save();

                    $field = [
                        'walletType' => Wallet::CLP_WALLET,//btc
                        'type' =>  Wallet::TRANSFER_CLP_TYPE,//transfer BTC
                        'inOut' => Wallet::OUT,
                        'userId' => $userCoin->userId,
                        'amount' => $request->carAmount,
                        'note' => 'To ' . $request->carUsername
                    ];

                    Wallet::create($field);

                    $field = [
                        'walletType' => Wallet::CLP_WALLET,//btc
                        'type' => Wallet::TRANSFER_CLP_TYPE,//transfer BTC
                        'inOut' => Wallet::IN,
                        'userId' => $userRiCoin->userId,
                        'amount' => $request->carAmount,
                        'note' => 'From ' . Auth::user()->name
                    ];

                    Wallet::create($field);

                    $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.msg_transfer_success') );
                    return response()->json(array('err' => false));
                }else{
                    $result = [
                        'err' => true,
                        'msg' =>[
                                'carAmountErr' => '',
                                'carUsernameErr' => trans('adminlte_lang::wallet.user_required'),
                                'carOTPErr' => '',
                                'carUidErr' => '',
                                'transferRuleErr' => '',
                            ]
                    ];
                    return response()->json($result);
                }
            }else{
                $result = [
                    'err' => true,
                    'msg' =>[
                        'carAmountErr' => $clpAmountErr,
                        'carUsernameErr' => $clpUsernameErr,
                        'carOTPErr' => $clpOTPErr,
                        'carUidErr' => $clpUidErr,
                        'transferRuleErr' => $transferRuleErr,
                    ]
                ];
                return response()->json($result);
            }
        }
        return response()->json(array('err' => true, 'msg' => null));
    }

    /**
     * @author Huynq
     * @param Request $request
     * @return null
     */
    public function getClpWallet(Request $request)
    {
        if($request->ajax())
        {
            set_time_limit(0);
            $userId = Auth::user()->id;

            if( CLPWallet::where('userId', $userId)->count() == 0 ){
                CLPWallet::create(['userId' => $userId]);
            } elseif ( CLPWallet::where('userId', $userId)->count() > 0 ){
                return response()->json(array('err' => true, 'msg' => null));
            }

            try {
                $clpAddress = new CLPWalletAPI();
                $result = $clpAddress->generateWallet();

                if ($result['success']) {
                    CLPWallet::where('userId',$userId )->update(['address' => $result['address']]);
                    return response()->json(array('data'=>$result['address'],'err' => false, 'msg' => null));
                } else {
                    CLPWallet::where('userId', $userId)->forcedelete();
                    return response()->json(array('err' => true, 'msg' => null));
                }
            } catch ( \Exception $e) {
                CLPWallet::where('userId', $userId)->forcedelete();
                throw $e;
            }
        }
    }
}
