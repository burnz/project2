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
use Auth;
use Session;
use App\Http\Controllers\Controller;
use LRedis;
use App\OrderList;
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
        if ( $request->isMethod('post') ){
            if( $request->amount * $request->price <= 0 || $request->price < 0.3 || $request->price < 0){
                return $this->responseError("Error");
            }
            try {
                $orderList = new OrderList();
                $orderList->code = md5(uniqid(Auth::user()->id, true));
                $orderList->user_id = Auth::user()->id;
                $orderList->amount = $request->amount;
                $orderList->price = $request->price;
                $orderList->total = $request->amount * $request->price;
                $orderList->save();
                $totalOrderInDay = OrderList::whereDate('created_at',date('Y-m-d'))->count();
                $totalValueOrderInday = OrderList::whereDate('created_at',date('Y-m-d'))->sum('amount');
                $data = [
                        'totalOrderInDay' => $totalOrderInDay,
                        'totalValueOrderInday' => $totalValueOrderInday
                    ];
                $dataTableRealTime = DB::table("order_lists")
                    ->select('price', DB::raw('SUM(amount) as amount'),DB::raw('SUM(total) as total'))
                    ->whereNull("deleted_at")
                    ->whereDate('created_at', '=', date('Y-m-d'))
                    ->groupBy('price')
                    ->orderBy('price','desc')
                    ->limit(20)
                    ->get()
                    ->toArray();

                $data['tableCommand'] = $dataTableRealTime;
                $redis = LRedis::connection();
                $result = $redis->publish('message', json_encode($data) );
                return $this->responseSuccess($result);
            } catch (\Exception $exception){
                return $this->responseError(404,'Error Socket');
            }
        }
        $totalOrderInDay = OrderList::whereDate('created_at',date('Y-m-d'))->count();
        $totalValueOrderInday = OrderList::whereDate('created_at',date('Y-m-d'))->sum('amount');
        $dataTableRealTime = DB::table("order_lists")
            ->select('price', DB::raw('SUM(amount) as amount'),DB::raw('SUM(total) as total'))
            ->whereNull("deleted_at")
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->groupBy('price')
            ->orderByRaw('price Desc')
            ->limit(20)
            ->get()
            ->toArray();
        //Get total value order
        $oValueOrder = DB::table("order_lists")
            ->select(DB::raw('SUM(total) as total'))
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->get();
        $totalValueOrder = isset($oValueOrder->total) ? $oValueOrder->total : 0;

        //Get today min price
        $oPrice = OrderMin::whereDate('order_date', Carbon::now()->format('Y-m-d'))->first();
        $price = $oPrice->price;

        //Get amount BTC
        $amountBTC = Auth::user()->userCoin->btcCoinAmount;
        return view('v1.order.index',compact('totalOrderInDay','totalValueOrderInday','dataTableRealTime', 'price', 'totalValueOrder', 'amountBTC'));
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
            2 => 'total',
            3 => 'created_at'
        );
        $count = DB::table("order_lists as a")
            ->where('user_id',Auth::user()->id)
            ->whereNull("deleted_at")
            ->count();
        $totalData = $count;
        $totalFiltered = $totalData;
        $sql = DB::table("order_lists as a")
            ->select('a.code','a.amount','a.price','a.total','a.status','a.created_at')
            //bản thân cần tìm gì ở đây
            ->where('user_id',Auth::user()->id)
            ->whereNull("deleted_at");
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
            // $nestedData[] = $value->unapproved_created_at;
            $nestedData[] = $value->amount;
            $nestedData[] = $value->price;
            $nestedData[] = $value->total;
            $nestedData[] = $value->created_at;

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
            $nestedData[] = $value->created_at;
            $nestedData[] = '';
            $nestedData[] = $value->price;
            $nestedData[] = $value->total;
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