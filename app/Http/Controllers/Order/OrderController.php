<?php
/**
 * Created by PhpStorm.
 * User: huydk
 * Date: 11/10/2017
 * Time: 2:20 PM
 */
namespace App\Http\Controllers\Order;

use App\Helper\Helper;
use App\UserData;

use Carbon\Carbon;
use Coinbase\Wallet\Resource\Order;
use Illuminate\Http\Request;
use App\User;
use App\BonusBinary;
use App\UserPackage;
use App\LoyaltyUser;
use App\OrderMin;
use App\ExchangeRate;
use Auth;
use Session;
use App\Http\Controllers\Controller;
use LRedis;
use App\OrderList;
use Log;
use DB;

class OrderController extends Controller
{
    const PROCESSING = 1;
    const CANCEL = 0;
    const SUCCESS = 2;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        //Get today min price
        $oPrice = OrderMin::whereDate('order_date', Carbon::now()->format('Y-m-d'))->first();
        if(empty($oPrice)){
            $price = OrderMin::orderBy('id', 'desc')->first()->price;
        } else {
            $price = $oPrice->price;
        }

        if ( $request->isMethod('post') ){
            $userCoin = Auth::user()->userCoin;
            $btcAmount = $request->amount * $request->price / ExchangeRate::getBTCUSDRate();

            if(!is_numeric($request->amount) || !is_numeric($request->price)) {
                throw new \Exception("Error Processing Request");
            }

            if( $request->amount <= 0 || $request->price <= 0 || $request->price < $price || $btcAmount > $userCoin->btcCoinAmount){
                throw new \Exception("Error Processing Request");
            }

            try {
                $orderList = new OrderList();
                $orderList->code = md5(uniqid(Auth::user()->id, true));
                $orderList->user_id = Auth::user()->id;
                $orderList->amount = $request->amount;
                $orderList->price = $request->price;
                $orderList->btc_rate = ExchangeRate::getBTCUSDRate();
                $orderList->btc_value = $btcAmount;
                $orderList->total = $request->amount * $request->price;
                $orderList->save();

                $currentHour = date('H');
                if($currentHour >= 21) {
                    $startTime = date('Y-m-d 21:00:00');
                    //$endTime = date('Y-m-d 23:59:59');
                } else {
                    $yesterday = Carbon::yesterday()->toDateString();
                    $startTime = strtotime($yesterday . '+21 hours');

                    $startTime = date('Y-m-d H:i:s', $startTime);
                    //$endTime = date('Y-m-d 21:00:00');
                }

                $totalOrderInDay = OrderList::where('created_at', '>', $startTime)->count();
                $totalValueOrderInday = OrderList::where('created_at', '>', $startTime)->sum('amount');
                $totalUSDValueInday = OrderList::where('created_at', '>', $startTime)->sum('total');
                $data = [
                        'totalOrderInDay' => $totalOrderInDay,
                        'totalValueOrderInday' => $totalValueOrderInday,
                        'totalUSDValue' => number_format($totalUSDValueInday, 2)
                    ];
                $dataTableRealTime = DB::table("order_lists")
                    ->select('price', DB::raw('SUM(amount) as amount'),DB::raw('SUM(total) as total'))
                    ->whereNull("deleted_at")
                    ->where('created_at', '>', $startTime)
                    ->groupBy('price')
                    ->orderBy('price','desc')
                    ->limit(20)
                    ->get()
                    ->toArray();

                $data['tableCommand'] = $dataTableRealTime;
                $redis = LRedis::connection();
                $redis->publish('message', json_encode($data) );

                //Return btc amount left
                $btcAmountLeft = number_format(($userCoin->btcCoinAmount - $btcAmount),  5);

                //Subtract btc in btc wallet
                $userCoin->btcCoinAmount = ($userCoin->btcCoinAmount - $btcAmount);
                $userCoin->save();

                return $this->responseSuccess($btcAmountLeft);
            } catch (\Exception $exception){
                Log::info($exception->getMessage());
                Log::info($exception->getTraceAsString());
                throw new \Exception("Error Processing Request");
            }
        }

        $currentHour = date('H');
        if($currentHour >= 21) {
            $startTime = date('Y-m-d 21:00:00');
            //$endTime = date('Y-m-d 23:59:59');
        } else {
            $yesterday = Carbon::yesterday()->toDateString();
            $startTime = strtotime($yesterday . '+21 hours');

            $startTime = date('Y-m-d H:i:s', $startTime);
            //$endTime = date('Y-m-d 21:00:00');
        }

        $totalOrderInDay = OrderList::where('created_at', '>', $startTime)->count();
        $totalValueOrderInday = OrderList::where('created_at', '>', $startTime)->sum('amount');
        $totalUSDValueInday = OrderList::where('created_at', '>', $startTime)->sum('total');
        $dataTableRealTime = DB::table("order_lists")
            ->select('price', DB::raw('SUM(amount) as amount'),DB::raw('SUM(total) as total'))
            ->whereNull("deleted_at")
            ->where('created_at', '>', $startTime)
            ->groupBy('price')
            ->orderByRaw('price Desc')
            ->limit(20)
            ->get()
            ->toArray();
        //Get total value order
        // $oValueOrder = DB::table("order_lists")
        //     ->select(DB::raw('SUM(total) as total'))
        //     ->whereDate('created_at', '=', date('Y-m-d'))
        //     ->get();
        // $totalValueOrder = isset($oValueOrder->total) ? $oValueOrder->total : 0;

        //Get amount BTC
        $amountBTC = Auth::user()->userCoin->btcCoinAmount;
        return view('adminlte::order.index',compact('totalOrderInDay','totalValueOrderInday','dataTableRealTime', 'price', 'totalUSDValueInday', 'amountBTC'));
    }

    /*
     * @author :huynq
     * @input request
     * @return json data
     * */
    public function getHistoryDataOrder (Request $request){
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'amount',
            1 => 'price',
            2 => 'btc_value',
            3 => 'created_at'
        );
        $count = DB::table("order_lists as a")
            ->where('user_id',Auth::user()->id)
            ->whereNull("deleted_at")
            ->count();
        $totalData = $count;
        $totalFiltered = $totalData;
        $sql = DB::table("order_lists as a")
            ->select('a.code','a.amount','a.price','a.btc_value','a.status','a.created_at')
            //bản thân cần tìm gì ở đây
            ->where('user_id',Auth::user()->id)
            ->whereNull("deleted_at")
            ->orderBy('a.created_at', 'desc');
        //Đếm số bản ghi ở đây
        $totalFiltered = $sql;
        $totalFiltered = $totalFiltered->count();
        $sql = $sql->orderBy('a.created_at','desc');
        $sql = $sql->skip($requestData['start'])->take($requestData['length']);
        $data = array();
        $data = $sql->get();
        $tmp = array();

        foreach ($data as $key => $value) {
            $nestedData=array();
            $nestedData[] = date('d-m-Y',strtotime( $value->created_at ));
            if (Carbon::now()->format('Y-m-d') === Carbon::parse($value->created_at)->format('Y-m-d')){
                if($value->status == self::CANCEL){
                    $nestedData[] = '<b><strong>Canceled</strong></b>';
                } elseif($value->status == self::SUCCESS){
                    $nestedData[] = '<b style="color: green"><strong>Success</strong></b>';
                } else {
                    $nestedData[] = '<b style="color: orange"><strong>Processing</strong></b>';
                }
            } else {
                $nestedData[] = '<b><strong>Canceled</strong></b>';
            }
            $nestedData[] = $value->amount;
            $nestedData[] = $value->price;
            $nestedData[] = number_format($value->btc_value, 5);
            // $deltail = "data-ot-register-id=".$value->ot_register_id." "."data-id-usercreat=".$value->usercreat;
            $tmp[] = $nestedData;
        }

        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $tmp
        );

        echo json_encode($json_data);
    }

    /*
     * @function
     * @author huynq
     * @return json data
     * */
    public function getHistoryDataTradeMarket(Request $request){
        $helper = new Helper();
        $dateNow = $helper->get_date_now();

        $requestData = $_REQUEST;
        $columns = array(
            0 => 'amount',
            1 => 'price',
            2 => 'total',
            3 => 'created_at'
        );

        $count = DB::select( DB::raw("SELECT count(*) as count FROM ( SELECT COUNT(id) FROM order_lists as a WHERE a.deleted_at IS NULL AND a.status = 2 AND date(a.created_at) < :dateNow GROUP BY date(a.created_at), a.price ) AS x"),  ["dateNow" => $dateNow] );
        $totalData = $count[0]->count;
        $totalFiltered = $totalData;
        //Đếm số bản ghi ở đây
        $totalFiltered = $count[0]->count;
        $start = $requestData['start'];
        $length = $requestData['length'];
        $data = array();

        if(isset($requestData['order'])){
            $orderby = $columns[$requestData['order'][0]['column']];
            $asc = $requestData['order'][0]['dir'];
            $data = DB::select( DB::raw("SELECT sum( a.amount ) as amount, a.price, sum( a.total ) as total, date(a.created_at ) AS created_at FROM `order_lists` AS a WHERE a.deleted_at IS NULL AND a.status = 2 AND date(a.created_at) < :dateNow GROUP BY date(a.created_at),a.price ORDER BY :orderby :asc LIMIT :length OFFSET :start ") ,
                ["dateNow" => $dateNow, "orderby" => $orderby, "asc" => $asc,"length" => $length, "start" => $start]);
        }else{
            $data = DB::select( DB::raw("SELECT sum( a.amount ) as amount, a.price, sum( a.total ) as total, date(a.created_at ) AS created_at FROM `order_lists` AS a WHERE a.deleted_at IS NULL AND a.status = 2 AND date(a.created_at) < :dateNow GROUP BY date(a.created_at),a.price ORDER BY created_at DESC ,price DESC LIMIT :length OFFSET :start "),
                ['dateNow'=>$dateNow, 'length'=>$length ,'start'=> $start]);
        }

        $tmp = array();
        foreach ($data as $key => $value) {
            $nestedData=array();
            $nestedData[] = date('d-m-Y',strtotime($value->created_at));
            $nestedData[] = $value->amount;
            $nestedData[] = $value->price;
            $nestedData[] = $value->total;
            $tmp[] = $nestedData;
        }

        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $tmp
        );

        echo json_encode($json_data);
    }

}