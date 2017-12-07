<?php
/**
 * Created by PhpStorm.
 * User: huydk
 * Date: 11/30/2017
 * Time: 4:23 PM
 */

namespace App\Http\Controllers\Backend\Order;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ToDayOrderController extends Controller
{
    const CANCEL = 0;
    const PROCESSING = 1;
    const SUCCESS = 2;

    public function show(){
        $arrayVirtualAcc = explode(',',config('app.virtual_account'));
        return view('adminlte::backend.order.todayorder');
    }

    public function getToDayDataOrder(){
        DB::enableQueryLog();
        $arrayVirtualAcc = explode(',',config('app.virtual_account'));

        // storing  request (ie, get/post) global array to a variable
        $requestData= $_REQUEST;

        $columns = array(
        // datatable column index  => database column name
            0 => 'name',
            1 => 'amount',
            2 => 'price',
            3 => 'total',
            4 => 'status',
            5 => 'created_at'
        );

        $count = DB::table("order_lists as a")->whereNotIn('user_id',$arrayVirtualAcc)
            ->whereDate('a.created_at',Carbon::now()->format('Y-m-d') )
            ->count();
        // getting total number records without any search
        $totalData = $count;
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = DB::table("order_lists as a")
            ->select('b.name','a.amount','a.price','a.total','a.status','a.created_at')
            ->join('users as b', 'b.id', '=', 'a.user_id');

        if( !empty($requestData['columns'][0]['search']['value']) ){   //name
            $sql = $sql->where('b.name', 'like', '%'.$requestData['columns'][0]['search']['value'].'%');
        }
        if( !empty($requestData['columns'][1]['search']['value']) ){  //salary
            $sql = $sql->where('a.amount',$requestData['columns'][1]['search']['value'] );
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){ //age
            $sql = $sql->where('a.price',$requestData['columns'][2]['search']['value'] );
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){ //age
            $sql = $sql->where('a.total',$requestData['columns'][3]['search']['value'] );
        }

        if((int)$requestData['columns'][4]['search']['value'] == 3){
            $sql = $sql->where('a.status','=', self::CANCEL);
        }else{
            if(!empty($requestData['columns'][4]['search']['value'])){
                $sql = $sql->where('a.status','=',(int)$requestData['columns'][4]['search']['value'] );
            }
        }

        $sql = $sql->whereDate('a.created_at',Carbon::now()->format('Y-m-d') );
        $sql = $sql->whereNotIn('user_id',$arrayVirtualAcc);
        $totalFiltered = $sql->count(); // when there is a search parameter then we have to modify total number filtered rows as per search result.
//        $laQuery = DB::getQueryLog();
//
//        $lcWhatYouWant = $laQuery[0]['query']; # <-------
//        var_dump($lcWhatYouWant);exit();
//# optionally disable the query log:
//        DB::disableQueryLog();
        $sql = $sql->orderBy($columns[$requestData['order'][0]['column']],$requestData['order'][0]['dir']);
        $sql = $sql->skip($requestData['start'])->take($requestData['length']);

        $data = array();
        $data = $sql->get();
        $tmp = array();

        foreach ($data as $key => $value) {
            $nestedData=array();
            // $nestedData[] = $value->unapproved_created_at;
            $nestedData[] = $value->name;
            $nestedData[] = $value->amount;
            $nestedData[] = $value->price;
            $nestedData[] = $value->total;
            if($value->status == self::CANCEL){
                $nestedData[] = '<b><strong>Canceled</strong></b>';
            } elseif($value->status == self::SUCCESS){
                $nestedData[] = '<b style="color: green"><strong>Success</strong></b>';
            } elseif($value->status == self::PROCESSING) {
                $nestedData[] = '<b style="color: orange"><strong>Processing</strong></b>';
            }

//            if (Carbon::now()->format('Y-m-d') === Carbon::parse($value->created_at)->format('Y-m-d')){
//
//            } else {
//                $nestedData[] = '<b><strong>Canceled</strong></b>';
//            }
            $nestedData[] = $value->created_at;
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