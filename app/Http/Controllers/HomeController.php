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
use App\Tickets;
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
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        $sunday = date("Y-m-d", strtotime('last sunday'));

        $data = [];
        
        //Caculate pre week commssion from tickets
        $PreTicketCommission = Wallet::where('userId', Auth::user()->id)
                            ->where('walletType', Wallet::CLP_WALLET)
                            ->where('type', Wallet::REVENUE_UNILEVEL_BONUS)
                            ->where('created_at','>=', $sunday)
                            ->first();

        //Caculate pre week binary commission
        $PreBinaryCommission = Wallet::where('userId', Auth::user()->id)
                            ->where('walletType', Wallet::CLP_WALLET)
                            ->where('type', Wallet::BINARY_TYPE)
                            ->where('created_at','>=', $sunday)
                            ->first();

        //Caculate pre week commission from agency
        $PreAgencyCommission = Wallet::where('userId', Auth::user()->id)
                            ->where('walletType', Wallet::CLP_WALLET)
                            ->where('type', Wallet::AGENCY_BONUS)
                            ->where('created_at','>=', $sunday)
                            ->first();

        $data['PreTicketCommission'] = isset($PreTicketCommission) ? $PreTicketCommission->amount : 0;
        $data['PreBinaryCommission'] = isset($PreBinaryCommission) ? $PreBinaryCommission->amount_usd : 0;
        $data['PreAgencyCommission'] = isset($PreAgencyCommission) ? $PreAgencyCommission->amount_usd : 0;

        //Get F1 lef, right Volume
        $levelRevenue = $this->getTicketByLevel(Auth::user()->id, $weekYear);

        //Get lịch sử package
        $data['history_package'] = UserPackage::getHistoryPackage();
        // check turn on/off button withdraw

        //get direct sale
        $directSale = $this->getDirectSale(Auth::user()->id, $weekYear);
        
        //get this week sales interest
        $ticketThisWeek = Tickets::where([['user_id','=', Auth::user()->id],['week_year','=', $weekYear]])->first();
        $ticketThisWeek = isset($ticketThisWeek) ? $ticketThisWeek->personal_quantity : 0;
        //end get today interest

        return view('adminlte::home.index')->with(compact('data','ticketThisWeek','levelRevenue', 'directSale'));
    }


    public function getTicketByLevel($userId, $weekYear)
    {
        //get all F1
        $listF1 = DB::table('user_datas')->where('refererId', $userId)->where('packageId', '>', 0)->pluck('userId')->toArray();
        //calculate revenue
        $revenueF1 = DB::table('tickets')->whereIn('user_id', $listF1)->where('week_year','=', $weekYear)->sum('quantity');

        //get ticket level 2
        $listF2 = DB::table('user_datas')->whereIn('refererId', $listF1)->where('packageId', '>', 0)->pluck('userId')->toArray();
        //calculate revenue
        $revenueF2 = DB::table('tickets')->whereIn('user_id', $listF2)->where('week_year','=', $weekYear)->sum('quantity');

        //get ticket level 3
        $listF3 = DB::table('user_datas')->whereIn('refererId', $listF2)->where('packageId', '>', 0)->pluck('userId')->toArray();
        //calculate revenue
        $revenueF3 = DB::table('tickets')->whereIn('user_id', $listF3)->where('week_year','=', $weekYear)->sum('quantity');

        //get ticket level 4
        $listF4 = DB::table('user_datas')->whereIn('refererId', $listF3)->where('packageId', '>', 0)->pluck('userId')->toArray();
        //calculate revenue
        $revenueF4 = DB::table('tickets')->whereIn('user_id', $listF4)->where('week_year','=', $weekYear)->sum('quantity');

        //get ticket level 5
        $listF5 = DB::table('user_datas')->whereIn('refererId', $listF4)->where('packageId', '>', 0)->pluck('userId')->toArray();
        //calculate revenue
        $revenueF5 = DB::table('tickets')->whereIn('user_id', $listF5)->where('week_year','=', $weekYear)->sum('quantity');

        $levelRevenue['f1'] = $revenueF1;
        $levelRevenue['f2'] = $revenueF2;
        $levelRevenue['f3'] = $revenueF3;
        $levelRevenue['f4'] = $revenueF4;
        $levelRevenue['f5'] = $revenueF5;

        return $levelRevenue;
    }

    public function getDirectSale($userId, $weekYear)
    {
        //get all F1
        $listF1 = DB::table('user_datas')->where('refererId', $userId)->where('packageId', '=', 0)->pluck('userId')->toArray();

        //calculate revenue
        $revenueF1 = DB::table('tickets')->whereIn('user_id', $listF1)->where('week_year','=', $weekYear)->sum('personal_quantity');

        return $revenueF1;
    }

}